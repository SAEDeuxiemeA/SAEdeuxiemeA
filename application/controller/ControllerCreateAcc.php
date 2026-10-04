<?php

namespace controller;
use model\ModelAccount;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";

class ControllerCreateAcc extends Controller
{
    public function index(){
        $this->render('ViewInscription');
    }

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

    public function register(){
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $validation = $this->validation($login, $email, $password, $password_confirm);

        if ($validation != null){
            $account = new ModelAccountDAO();
            if ($account->findAccountByUsername($login) || $account->findAccountByEmail($email)){
                $validation = "Username ou email déjà existant";
            }
            if ($account->createAccount($login, $email, $password)){
                header('Location: index.php?page=login&action=index');
                exit;
            }

            $this->render('ViewInscription', ['login' => $login, 'email' => $email, 'validation' => $validation] );
        }




    }
}