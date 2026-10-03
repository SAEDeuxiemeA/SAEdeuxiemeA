<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerCreateAcc extends Controller
{
    public function index(){
        $this->render('ViewInscription');
    }
}