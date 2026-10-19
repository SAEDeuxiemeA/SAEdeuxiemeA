<?php

namespace controller;
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . '/../model/ModelGameDAO.php';

use model\ModelGameDAO;
/**
 * Contrôleur de la page d'accueil
 */
class ControllerHome extends Controller

{
    /**
     * Affiche la page d'accueil.
     */

    //charger la vue de la page d'acceuil
    public function index(): void{
        $this->render('ViewHome');
    }

    // Appelée une seule fois à la fin de la partie
    public function saveGame(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // On récupère les données envoyées par le JavaScript
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $_SESSION['user']['username'] ?? null;
        $wordId   = (int) ($data['word_id'] ?? 0);
        $attempts = (int) ($data['attempts'] ?? 0);
        $time     = (int) ($data['time_seconds'] ?? 0);
        $isWon    = (bool) ($data['is_won'] ?? false);
        if ($username && $wordId > 0) {
            $gameDAO = new ModelGameDAO();
            $gameId = $gameDAO->createGame($username, $wordId);
            if ($gameId) {
                $gameDAO->finishGame($gameId, $attempts, $time, $isWon);
            }
        }
        echo json_encode(['status' => 'success']);
        exit;
    }
}