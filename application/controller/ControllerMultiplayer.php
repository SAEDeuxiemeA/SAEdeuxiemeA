<?php
namespace controller;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/ModelRoomDAO.php';
require_once __DIR__ . '/../model/ModelWordDAO.php';

use model\ModelRoomDAO $roomDAO;
use model\ModelWordDAO $wordDAO;

class ControllerMultiplayer extends Controller
{
    private ModelRoomDAO $roomDAO;
    private ModelWordDAO $wordDAO;

    public function __construct()
    {
        $this->roomDAO = new ModelRoomDAO();
        $this->wordDAO = new ModelWordDAO();
    }

    private function jsonResponse(array $data, int $statusCode = 200): void //pour ne pas renvoyer de HTML et renvoyer du JSON
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    private function getUsername(): string //pour vérifier si le joueur est bien connecté
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
    }
        if (empty($_SESSION['username'])) {
        $this->jsonResponse(['error' => 'Tu dois être connecté pour jouer.'], 401);
        }
        return $_SESSION['username'];
    }

    public function create(): void
    {
        $username = $this->getUsername();
        $word = $this->wordDAO->getRandomWord();
        if (!$word) {
            $this->jsonResponse(['error' => 'Aucun mot dans la base'], 500);
        }
        //Générer un code à 5 lettres/chiffres
        $code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
        $roomId = $this->roomDAO->createRoom($code, $username, $word->getId());
        if ($roomId) {
            $this->jsonResponse([
                'room_id' => $roomId
                'success' => true,
                'code' => $code
            ]);
        }
        $this->jsonResponse(['error' => 'Erreur lors de la création'], 500);
    }

    public function join(): void
    {
        $username = $this->getUsername();
        $code = strtoupper(trim($_POST['code'] ?? ''));
        if (empty($code)) {
            $this->jsonResponse(['error' => 'Aucun code'], 400);
        }
        $room = $this->roomDAO->getRoomByCode($code);
        if (!$room) {
            $this->jsonResponse(['error' => 'Salon introuvable'], 404);
        }
        if ($room->getStatus() !== 'waiting') {
            $this->jsonResponse(['error' => 'La partie a déjà commencé'], 403);
        }
        $sucess = $this->roomDAO->joinRoom($room->getId(), $username);
        if ($sucess) {
            $this->jsonResponse(['success' => true, 'room_id' => $room->getId()]);
        }
        $this->jsonResponse(['error' => 'Erreur pour rejoindre'], 500);
        }
    }