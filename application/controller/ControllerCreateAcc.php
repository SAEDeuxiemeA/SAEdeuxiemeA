<?php

namespace controller;
use model\ModelAccountDAO;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";

/**
 * Contrôleur de la création de compte.
 */

class ControllerCreateAcc extends Controller
{

    /**
     * Affiche le formulaire d'inscription.
     */

    public function index(){
        $this->render('ViewInscription');
    }

/**
     * Valide les données saisies dans le formulaire d'inscription.
     *
     * Règles : pseudo de 1 à 25 caractères, email valide, mots de passe
     * identiques et d'au moins 8 caractères.
     *
     * @param string $username         Pseudo choisi.
     * @param string $email            Adresse e-mail.
     * @param string $password         Mot de passe.
     * @param string $password_confirm Confirmation du mot de passe.
     *
     * @return string|null Message d'erreur, ou null si les données sont valides.
     */

    public function validation(string $username, string $email, string $password, string $password_confirm): ?string{
        if ($username == '' || $username == null || strlen($username) > 25 || strlen($username) < 1) {
            return "Le username doit être entre 1 et 25 caracteres";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'email n'est pas valide";
        }
        if ($password != $password_confirm) {
            return "Les mots de passe ne correspondent pas";
        }
        if (strlen($password) < 8) {
            return "Le mot de passe doit contenir au moins 8 caracteres";
        }
        return null;
    }

    /**
     * Traite le formulaire d'inscription.
     *
     * Lit `login`, `email`, `password` et `password_confirm` dans `$_POST`,
     * valide les données, vérifie que le pseudo et l'email ne sont pas déjà
     * utilisés, puis crée le compte et redirige vers la connexion.
     * En cas d'erreur, réaffiche le formulaire avec le message.
     */

    public function register(){
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $validation = $this->validation($login, $email, $password, $password_confirm);

        if ($validation === null){
            $account = new ModelAccountDAO();
            if ($account->findAccountByUsername($login) || $account->findAccountByEmail($email)){
                $validation = "Username ou email déjà existant";
            }
            elseif ($account->createAccount($login, $email, $password)){
                header('Location: index.php?page=login&action=index');
                exit;
            }

            $this->render('ViewInscription', ['login' => $login, 'email' => $email, 'validation' => $validation] );
        }




    }
}