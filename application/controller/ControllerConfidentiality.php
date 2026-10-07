<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

/**
* Contrôleur de la page de politique de confidentialité (contenu statique).
*/

class ControllerConfidentiality extends Controller
{
    /**
    * Affiche la page de politique de confidentialité.
    */
    public function index(): void{
        $this->render('ViewConfidentiality');
    }
}