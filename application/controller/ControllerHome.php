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
        $secretWord = 'LINUX';
        $wordId = 1;
        try {
            //Connexion et récupération
            $wordDAO = new ModelWordDAO();
            //mode Daily
            $wordObj = $wordDAO->getDailyWord();
            //Tirage aléatoire si aucun mot n'est assigné au Daily
            if (!$wordObj) {
                $wordObj = $wordDAO->getRandomWord();
            }
            //Remplacement des valeurs de sécurité par les vraies données
            if ($wordObj) {
                $secretWord = $wordObj->getWord();
                $wordId = $wordObj->getId();
            }
        } catch (\Throwable $e) {}
        $this->render('ViewHome', [
            'secretWord' => $secretWord,
            'wordId'     => $wordId
        ]);
    }
}