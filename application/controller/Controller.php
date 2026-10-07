<?php

namespace controller;

/**
 * Classe parente de tous les contrôleurs.
 *
 * Fournit la méthode {@see self::render()} qui affiche une vue en lui
 * transmettant des données. Les contrôleurs de l'application
 * (ControllerHome, ControllerLogin, etc.) en héritent.
 */

//fichier parent des autres controllers pour charger les vues
class Controller
{

    /**
     * Affiche une vue.
     *
     * Cherche le fichier `vue/<$view>.php`, rend les éléments de `$data`
     * disponibles sous forme de variables dans la vue (la clé `error`
     * devient `$error`), puis inclut le fichier.
     *
     * Exemple :
     * <code>
     * $this->render('ViewLogin', ['error' => 'Mot de passe incorrect']);
     * </code>
     *
     * @param string $view Nom de la vue, sans extension (ex. `'ViewHome'`).
     *                     Ne doit jamais provenir d'une saisie utilisateur.
     * @param array  $data Données à transmettre à la vue, sous la forme
     *                     `['nomVariable' => valeur]`. Vide par défaut.
     *
     * @return void Arrête le script avec un message si la vue n'existe pas.
     */
    
    function render(string $view, array $data = []): void{
        $file = __DIR__ . '/../vue/' . $view . '.php';

        if (!file_exists($file)) {
            exit("View doesn't exist");
        }

        extract($data);
        require $file;
    }

}