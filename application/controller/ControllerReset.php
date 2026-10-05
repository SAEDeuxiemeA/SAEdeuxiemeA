<?php

namespace controller;
require_once __DIR__ . "/Controller.php";

class ControllerReset extends Controller
{
    public function index(): void{
        $this->render('ViewReset');
    }
}