<?php

namespace controller;
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . '/../model/ModelGameDAO.php';
require_once __DIR__ . '/../model/ModelWordDAO.php';

use model\ModelGameDAO;
use model\ModelWordDAO;

/**
 * Contrôleur de la page training
 */
class ControllerTraining extends Controller
{
    /**
     * Affiche la page training.
     */
    public function index(): void
    {
        $secretWord = 'TECHD';
        $wordId = 1;

        try {
            $wordDAO = new ModelWordDAO();
            $wordObj = $wordDAO->getDailyWord();

            if (!$wordObj) {
                $wordObj = $wordDAO->getRandomWord();
            }

            if ($wordObj) {
                $secretWord = $wordObj->getWord();
                $wordId = $wordObj->getId();
            }
        } catch (\Exception $e) {
        }

        $data = [
            'secretWord' => $secretWord,
            'wordId'     => $wordId
        ];

        $this->render('ViewTraining', $data);
    }

    public function saveGame(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $username = $_SESSION['user']['username'] ?? null;
        $wordId   = (int) ($data['word_id'] ?? 0);
        $attempts = (int) ($data['attempts'] ?? 0);
        $time     = (int) ($data['time_seconds'] ?? 0);
        $isWon    = (bool) ($data['is_won'] ?? false);

        try {
            if ($username && $wordId > 0) {
                $gameDAO = new ModelGameDAO();
                $gameId = $gameDAO->createGame($username, $wordId);
                if ($gameId) {
                    $gameDAO->finishGame($gameId, $attempts, $time, $isWon);
                }
            }
        } catch (\Exception $e) {
        }

        echo json_encode(['status' => 'success']);
        exit;
    }
}