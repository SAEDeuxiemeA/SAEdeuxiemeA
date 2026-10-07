<?php

namespace controller;
use model\ModelAccountDAO;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";

/**
 * Contrôleur de l'authentification (connexion et déconnexion).
 *
 * Les informations de l'utilisateur connecté sont stockées en session :
 * `$_SESSION['login']` (pseudo) et `$_SESSION['picture']` (image de profil).
 */

class ControllerLogin extends Controller
{

 /**
     * Affiche le formulaire de connexion.
     *
     * Redirige vers l'accueil
     * si un utilisateur est déjà connecté.
     */

    public function index(): void {
        if (isset($_SESSION['login'])) {
            header('Location: index.php?page=home&action=index');
            exit;
        }
        $this->render('ViewLogin');
    }

 /**
     * Traite le formulaire de connexion.
     *
     * Lit `$_POST['login']` et `$_POST['password']`, puis vérifie les
     * identifiants via {@see ModelAccountDAO::verifyConnection()}.
     * En cas de succès : régénère l'identifiant de session, enregistre le
     * pseudo et l'image en session, puis redirige vers l'accueil.
     * En cas d'échec : réaffiche le formulaire avec un message d'erreur.
     */

    public function auth(): void {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dao = new ModelAccountDAO();
        $account = $dao->verifyConnection($email, $password);

        if (!$account == null) {
            session_regenerate_id(true);
            $_SESSION['login'] = $account->getLogin();
            $_SESSION['picture'] = $account->getPicture();
            header('Location: index.php?page=home&action=index');
            exit;
        }

        $this->render('ViewLogin', ['error' => "Username ou mot de passe incorrect", 'login' => $login,]);
    }

   /**
     * Déconnecte l'utilisateur : détruit la session et redirige vers l'accueil.
     */

    public function logout(): void {
        $_SESSION = [];
        session_destroy();

        header('Location: index.php?page=home&action=index');
        exit;
    }
}
