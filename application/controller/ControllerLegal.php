<?php

namespace controller;
require_once __DIR__ . "/Controller.php";


class ControllerLegal extends Controller
{
    //charger la vue legal
    public function index(): void {
        $this->render('ViewLegal');
    }
}