<?php

namespace controller;

//fichier parent des autres controllers pour charger les vues
class Controller
{
    function render(string $view, array $data = []): void{
        $file = __DIR__ . '/../vue/' . $view . '.php';

        if (!file_exists($file)) {
            exit("View doesn't exist");
        }

        extract($data);
        require $file;
    }

}