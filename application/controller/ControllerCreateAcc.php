<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerCreateAcc
{
    public function index(){
        $this->render('VueInscription');
    }
}