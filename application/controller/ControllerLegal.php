<?php

namespace controller;
require_once __DIR__ . "/Controller.php";


class ControllerLegal extends Controller
{
    public function index(): void {
        $this->render('ViewLegal');
    }
}