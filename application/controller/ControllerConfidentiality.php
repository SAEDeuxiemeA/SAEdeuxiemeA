<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerConfidentiality extends Controller
{
    public function index(): void{
        $this->render('ViewConfidentiality');
    }
}