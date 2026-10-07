<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

/**
 * Contrôleur de la page d'accueil
 */
class ControllerHome extends Controller

{
    /**
     * Affiche la page d'accueil.
     */
    
    public function index(): void{
        $this->render('ViewHome');
    }

}