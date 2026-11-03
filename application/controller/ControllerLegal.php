<?php

namespace controller;

/**
 * Contrôleur de la page de mentions légales (contenu statique).
 */

class ControllerLegal extends Controller
{
    /**
     * Affiche la page de mentions légales.
     */
    //charger la vue legal
    public function index(): void {
        $this->render('ViewLegal');
    }
}