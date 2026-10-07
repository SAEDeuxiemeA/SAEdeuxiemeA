<?php

namespace controller;
require_once __DIR__ . "/Controller.php";
/**
 * Contrôleur d'affichage du formulaire de nouveau mot de passe.
 *
 * La logique de réinitialisation (jeton, mise à jour) se trouve
 * dans ControllerPassword.
 */
class ControllerReset extends Controller
{
    /**
     * Affiche le formulaire de nouveau mot de passe.
     */
    public function index(): void{
        $this->render('ViewReset');
    }
}