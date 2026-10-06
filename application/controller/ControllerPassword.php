<?php

namespace controller;
use model\ModelAccountDAO;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../model/ModelAccountDAO.php";

class ControllerPassword extends Controller
{
    public function index(): void{
        $this->render('ViewMDP');
    }

    public function send(): void{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header("Location: index.php?page=password&action=index");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $dao = new ModelAccountDAO();

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

    public function reset(): void{
        $token = $_GET['token'] ?? '';
        $dao = new ModelAccountDAO();

        if ($token === '' || $dao->findEmailByToken($token) === null) {
            $this->render('ViewMDP', [
                'error' => 'Ce lien esst invalide ou a expiré'
            ]);
            return;
        }

        $this->render('ViewReset', ['token' => $token]);
    }

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

        if ($email === null) {
            $this->render('ViewMDP', [
                'error' => 'Ce lien est invalide'
            ]);
            return;
        }

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
        $dao->deleteResetToken($token); // the link works only once

        header('Location: index.php?page=login&action=index');
        exit;

    }

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

