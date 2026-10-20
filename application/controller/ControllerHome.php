<?php

namespace controller;
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . '/../model/ModelWordDAO.php';

use model\ModelWordDAO;

/**
 * Contrôleur de la page d'accueil
 */
class ControllerHome extends Controller
{
    /**
     * Affiche la page d'accueil.
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

        $this->render('ViewHome', $data);
    }
}