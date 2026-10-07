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
    
    //charger la vue de la page d'acceuil
    public function index(): void{
        $this->render('ViewHome');
    }

}