<?php
namespace controller;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/ModelRoomDAO.php';
require_once __DIR__ . '/../model/ModelWordDAO.php';

use model\ModelRoomDAO;
use model\ModelWordDAO;

class ControllerMultiplayer extends Controller
{
    private ModelRoomDAO $roomDAO;
    private ModelWordDAO $wordDAO;

    public function __construct()
    {
        $this->roomDAO = new ModelRoomDAO();
        $this->wordDAO = new ModelWordDAO();
    }

    private function getUsername(): string //pour vérifier si le joueur est bien connecté
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
    }
        $username = $_SESSION['user']['username'] ?? $_SESSION['username'] ?? null; //sécurise avec ?? null pour éviter que PHP ne crashe si la clé n'existe pas encore
        if (empty($username)) {
            header('Location: index.php?route=login');
            exit();
        }
        return $username;
    }

    public function create(): void
    {
        $username = $this->getUsername();
        $word = $this->wordDAO->getRandomWord();
        //Générer un code à 5 lettres/chiffres
        $code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
        $roomId = $this->roomDAO->createRoom($code, $username, $word->getId());
        header("Location: index.php?route=multiplayer_lobby&room_id=$roomId");
        exit();
    }

    public function join(): void
    {
        $username = $this->getUsername();
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $room = $this->roomDAO->getRoomByCode($code);
        if ($room && $room->getStatus() === 'waiting') {
            $this->roomDAO->joinRoom($room->getId(), $username);
            header("Location: index.php?route=multiplayer_lobby&room_id=" . $room->getId());
            exit();
        }
        $this->render('multiplayer_menu', ['error' => 'Code invalide ou partie déjà lancée.']);
    }

    public function lobby(): void
    {
        $username = $this->getUsername();
        $roomId = (int) ($_GET['room_id'] ?? 0);
        $room = $this->roomDAO->getRoomById($roomId);
        //si le salon n'existe pas (pour la sécurité)
        if (!$room) {
            header("Location: index.php?route=multiplayer_menu");
            exit();
        }
        //si la partie a démarré on nous envoie direct sur la page de jeu
        if ($room->getStatus() === 'playing') {
            header("Location: index.php?route=game&room_id=$roomId");
            exit();
        }
        $players = $this->roomDAO->getPlayers($roomId);
        $isCreator = ($room->getUsername() === $username);
        $this->render('lobby', [
            'room'      => $room,
            'players'   => $players,
            'isCreator' => $isCreator
        ]);
    }
    public function start(): void
    {
        $roomId = (int) ($_POST['room_id'] ?? 0);
        $this->roomDAO->startGame($roomId);
        //on redirige vers le jeu
        header("Location: index.php?route=game&room_id=$roomId");
        exit();
    }
}