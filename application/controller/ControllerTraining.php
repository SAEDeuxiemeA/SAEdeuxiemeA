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
        $secretWord = 'LINUX';
        $wordId = 1;
        try {
            $wordDAO = new ModelWordDAO();
            $wordObj = $wordDAO->getRandomWord();

            if ($wordObj) {
                $secretWord = $wordObj->getWord();
                $wordId = $wordObj->getId();
            }
        } catch (\Throwable $e) {
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

        $username = $_SESSION['user']['username'] ?? $_SESSION['username'] ?? null;        $wordId   = (int) ($data['word_id'] ?? 0);
        $attempts = (int) ($data['attempts'] ?? 0);
        $time     = (int) ($data['time_seconds'] ?? 0);
        $isWon    = (bool) ($data['is_won'] ?? false);
        $guesses  = (array) ($data['guesses'] ?? []);

        try {
            if ($username && $wordId > 0) {
                $gameDAO = new ModelGameDAO();
                $gameId = $gameDAO->createGame($username, $wordId);
                if ($gameId) {
                    foreach ($guesses as $index => $word) {
                        $gameDAO->addGuess($gameId, $index + 1, $word); //pour sauvegarder chaque mot
                    }
                    $gameDAO->finishGame($gameId, $attempts, $time, $isWon);
                }
            }
        } catch (\Throwable $e) {
        }

        $this->render('ViewTraining'); //vue t
    }
}