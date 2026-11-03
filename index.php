<?php

/**
 * Démarre la session PHP, puis délègue le traitement de la requête
 * au routeur.
 */
    session_start();

    require_once __DIR__ . '/router.php';
    require_once __DIR__ . '/autoloader.php';

    $routeur = new router();
    $routeur->routerRequete();