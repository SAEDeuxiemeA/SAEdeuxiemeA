<?php
namespace model;

class ModelAccountDAO {
    public function verifierConnexion(string $login, string $password): ?ModelAccount{
        $db = Database::getConnexion();

        $stmt = $db->prepare('SELECT username, userpassword FROM user WHERE username = :login');
        $stmt->execute(['username' => $login]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['userpassword'])) {
            return new ModelAccount($row['username'], $row['userpassword']);
        }
        return null;
    }
    public function creerCompte(string $username, string $email, string $password): bool {
        $db = Database::getConnexion();
        //On hache le mot de passe pour la sécurité
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO user (username, email, userpassword) VALUES (:username, :email, :password)');
        $resultat = $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash
        ]);
        return $resultat;
    }
    public function modifierAvatar(string $username, string $picture): bool {
        $db = Database::getConnexion();
        //On met à jour la colonne picture uniquement pour l'utilisateur concerné
        $stmt = $db->prepare('UPDATE user SET picture = :picture WHERE username = :username');
        $resultat = $stmt->execute([
            'picture' => $picture,
            'username' => $username
        ]);
        return $resultat;
    }
    public function supprimerCompte(string $username): bool {
        $db = Database::getConnexion();
        //On supprime toute la ligne de l'utilisateur
        $stmt = $db->prepare('DELETE FROM user WHERE username = :username');
        $resultat = $stmt->execute([
            'username' => $username
        ]);
        return $resultat;
    }
}
?>