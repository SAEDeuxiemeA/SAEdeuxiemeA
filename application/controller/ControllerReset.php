<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerReset extends Controller
{
    //charger la vue reset
    public function index(): void{
        $this->render('ViewReset');
    }
}