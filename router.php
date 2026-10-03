<?php

class router
{
    const ROUTES_AVAIL = [
        'home' => 'ControllerHome',
        'createacc' => 'ControllerCreateAcc',
        'legal' => 'ControllerLegal',
        'login' => 'ControllerLogin',
        'password' => 'ControllerPassword',
        'confidentiality' => 'ControllerConfidentiality'
    ];

    const ROUTES_DEFAULT = 'home';
    const ACTION_DEFAULT = 'index';

    public function routerRequete(): void
    {
        $page = $_GET['page'] ?? self::ROUTES_DEFAULT;
        $action = $_GET['action'] ?? self::ACTION_DEFAULT;

        if (!array_key_exists($page, self::ROUTES_AVAIL)) {
            $page = self::ROUTES_DEFAULT;
        }
        $controller = self::ROUTES_AVAIL[$page];
        $file = __DIR__ . '/application/controller/' . $controller . '.php';

        require_once $file;
        $class = 'controller\\' . $controller;
        $controller = new $class();

        if (!method_exists($controller, $action)) {
            $action = self::ACTION_DEFAULT;
        }
        $controller -> $action();
    }
}
