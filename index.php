<?php

require_once __DIR__ . '/routeur.php';

$routeur = new Routeur();
// Note : la méthode routeurRequete() est un nom d'exemple,
// vous pouvez la renommer selon le vrai nom de la méthode.
$routeur->routerRequete();