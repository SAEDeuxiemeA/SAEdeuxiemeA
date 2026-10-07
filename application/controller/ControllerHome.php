<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerHome extends Controller

{
    //charger la vue de la page d'acceuil
    public function index(): void{
        $this->render('ViewHome');
    }

}