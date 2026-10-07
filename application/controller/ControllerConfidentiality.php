<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerConfidentiality extends Controller
{
    //charger la vue Confidentiality
    public function index(): void{
        $this->render('ViewConfidentiality');
    }
}