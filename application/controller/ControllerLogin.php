<?php

namespace controller;
use model\ModelAccountDAO;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";
class ControllerLogin extends Controller
{
    public function index(): void {
        if (isset($_SESSION['login'])) {
            header('Location: index.php?page=home&action=index');
        }
        $this->render('ViewLogin');
    }

    public function auth(): void {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $dao = new ModelAccountDAO();
        $account = $dao->verifyConnection($login, $password);

        if (!$account == null) {
            session_regenerate_id(true);
            $_SESSION['login'] = $account->getLogin();
            $_SESSION['picture'] = $account->getPicture();
            header('Location: index.php?page=home&action=index');
            exit;
        }

        $this->render('ViewLogin', ['error' => "Username ou mot de passe incorrect", 'login' => $login,]);
    }

    public function logout(): void {
        $_SESSION[] = [];
        session_destroy();

        header('Location: index.php?page=home&action=index');
        exit;
    }
}
