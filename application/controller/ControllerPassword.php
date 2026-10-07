<?php

namespace controller;
use model\ModelAccountDAO;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";

/**
 * Contrôleur du parcours « mot de passe oublié ».
 *
 * Étapes : saisie de l'email ({@see self::index()}), envoi du lien
 * ({@see self::send()}), ouverture du lien ({@see self::reset()}),
 * enregistrement du nouveau mot de passe ({@see self::updatePassword()}).
 */

class ControllerPassword extends Controller
{
    /**
     * Affiche le formulaire « mot de passe oublié ».
     */
    public function index(): void{
        $this->render('ViewMDP');
    }
    /**
     * Envoie un lien de réinitialisation par e-mail.
     *
     * Le message affiché est identique que l'adresse existe ou non, afin de
     * ne pas révéler quels comptes existent. Le lien contient un jeton valable
     * 1 heure.
     */
    //charger la vue oublie de mot de passe
    public function index(): void{
        $this->render('ViewMDP');
    }

    //envoie de mail pour changer le mot de passe
    public function send(): void{
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?page=password&action=index");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $dao = new ModelAccountDAO();

        //si mail est valide et c'est utiliser dans la base de donnée, cela créer un token et envoi le mail.
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $dao->findAccountByEmail($email)) {
            $token = $dao->createResetToken($email);
            $config = require __DIR__ . "/../../config.php";
            $link = $config['baseUrl'] . "/index.php?page=password&action=reset&token=" . $token;
            $this->sendMail($email, $link, $config['mailFrom']);
        }

        $this->render('ViewMDP', [
            'message' => 'Si cette adresse existe, un lien de réinitialisation du mot de passe vient d\'être envoyé.',
        ]);
    }


     /**
     * Vérifie le jeton du lien (`$_GET['token']`) et affiche le formulaire
     * de nouveau mot de passe s'il est valide ; sinon affiche une erreur.
     */
    //fonction pour renvoyer l'utilisateur vers la page reset
    public function reset(): void{
        $token = $_GET['token'] ?? '';
        $dao = new ModelAccountDAO();

        if ($token === '' || $dao->findEmailByToken($token) === null) {
            $this->render('ViewMDP', [
                'error' => 'Ce lien est invalide ou a expiré'
            ]);
            return;
        }

        $this->render('ViewReset', ['token' => $token]);
    }

    /**
     * Enregistre le nouveau mot de passe.
     *
     * Vérifie le jeton, la longueur (8 caractères minimum) et la
     * confirmation du mot de passe. En cas de succès, met à jour le mot de
     * passe, supprime le jeton (usage unique) et redirige vers la connexion.
     */
    
    //fonction pour modifier le mot de passe
    public function updatePassword(): void{
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: index.php?page=password&action=index");
            exit;
        }
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $dao = new ModelAccountDAO();
        $email = $dao->findEmailByToken($token);

        //si le mail n'a pas de token dans la base de donnée, cela renvoie un erreur
        if ($email === null) {
            $this->render('ViewMDP', [
                'error' => 'Ce lien est invalide'
            ]);
            return;
        }

        //verification de mot de passe
        $error = null;
        if (strlen($password) < 8) {
            $error = 'Le mot de passe doit contenir au moins 8 caractères.';
        } elseif ($password !== $password_confirm) {
            $error = 'Les mots de passe ne correspondent pas.';
        }
        if ($error !== null) {
            $this->render('ViewReset', ['title' => 'Nouveau mot de passe', 'token' => $token, 'error' => $error]);
            return;
        }
        $dao->modifyPassword($email, $password);
        $dao->deleteResetToken($token);

        header('Location: index.php?page=login&action=index');
        exit;

    }


    /**
     * Envoie le mail contenant le lien de réinitialisation.
     *
     * Si `mail()` échoue, le lien est écrit dans le
     * journal d'erreurs PHP pour pouvoir tester le parcours.
     *
     * @param string $email Adresse du destinataire.
     * @param string $link  Lien de réinitialisation à insérer dans le mail.
     * @param string $from  Adresse de l'expéditeur (clé `mailFrom` de la config).
     *
     * @return bool true si le mail a été accepté pour envoi, false sinon.
     */
    //fonction qui permet à renvoyé le mail
    private function sendMail(string $email, string $link, string $from): bool
    {
        $subject = 'Réinitialisation de votre mot de passe';
        $body = "Pour choisir un nouveau mot de passe, ouvrez ce lien (valable 1 heure) :\n\n"
            . $link . "\n\n"
            . "Si vous n'avez rien demandé, ignorez ce message.";

        $headers = [
            'From' => $from,
            'Content-Type' => 'text/plain; charset=UTF-8',
        ];

        $sent = @mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

        if (!$sent) {
            // No mail program available (typical on a local machine): log the link to test the flow
            error_log("mail() failed, reset link for $email: $link");
        }

        return $sent;
    }
}

