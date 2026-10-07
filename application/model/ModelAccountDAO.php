<?php
namespace model;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelAccount.php';

/**
 * DAO (Data Access Object) des comptes utilisateurs.
 *
 * Regroupe toutes les requêtes SQL portant sur les tables `users` et
 * `password_resets`. Toutes les requêtes sont préparées (protection contre
 * l'injection SQL).
*/

class ModelAccountDAO
{
    /**
     * Vérifie un couple pseudo / mot de passe.
     *
     * @param string $login    Pseudo saisi.
     * @param string $password Mot de passe en clair saisi.
     *
     * @return ModelAccount|null Le compte si les identifiants sont corrects, null sinon.
     */

    public function verifyConnection(string $email, string $password): ?ModelAccount
    {
        $db = Database::getConnection();

        $stmt = $db->prepare('SELECT username, userpassword, email, picture FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['userpassword'])) {
            return new ModelAccount($row['username'], $row['userpassword'], $row['email'], $row['picture']);
        }
        return null;
    }

    /**
     * Crée un compte. Le mot de passe est haché avant l'insertion.
     *
     * @param string $login    Pseudo.
     * @param string $email    Adresse e-mail.
     * @param string $password Mot de passe en clair.
     *
     * @return bool true si l'insertion a réussi.
     */

    public function createAccount(string $login, string $email, string $password): bool
    {
        $db = Database::getConnection();
        //On hache le mot de passe pour la sécurité
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (username, email, userpassword) VALUES (:username, :email, :password)');
        $result = $stmt->execute([
            'username' => $login,
            'email' => $email,
            'password' => $passwordHash
        ]);
        return $result;
    }


    /**
     * Met à jour l'image de profil d'un utilisateur.
     *
     * @param string $login   Pseudo de l'utilisateur concerné.
     * @param string $picture Nouvelle image de profil.
     *
     * @return bool true si la mise à jour a réussi.
     */
    public function modifyAvatar(string $login, string $picture): bool
    {
        $db = Database::getConnection();
        //On met à jour la colonne picture uniquement pour l'utilisateur concerné
        $stmt = $db->prepare('UPDATE users SET picture = :picture WHERE username = :username');
        $result = $stmt->execute([
            'picture' => $picture,
            'username' => $login
        ]);
        return $result;
    }


    /**
     * Supprime un compte (les jetons de réinitialisation associés sont
     * supprimés en cascade).
     *
     * @param string $login Pseudo du compte à supprimer.
     *
     * @return bool true si la suppression a réussi.
     */
    public function deleteAccount(string $login): bool
    {
        $db = Database::getConnection();
        //On supprime toute la ligne de l'utilisateur
        $stmt = $db->prepare('DELETE FROM users WHERE username = :username');
        $result = $stmt->execute([
            'username' => $login
        ]);
        return $result;
    }

    /**
     * Vérifie si une adresse e-mail est déjà utilisée (mot de passe oublié,
     * inscription).
     *
     * @param string $email Adresse e-mail à rechercher.
     *
     * @return bool true si un compte utilise cette adresse.
     */    
    
    public function findAccountByEmail(string $email): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        // Si fetch() trouve quelque chose ça renvoie true sinon false
        return $stmt->fetch() !== false;
    }


    /**
     * Change le mot de passe du compte associé à un e-mail. Le nouveau mot
     * de passe est haché avant l'enregistrement.
     *
     * @param string $email       Adresse e-mail du compte.
     * @param string $newPassword Nouveau mot de passe en clair.
     *
     * @return bool true si la mise à jour a réussi.
     */

    public function modifyPassword(string $email, string $newPassword): bool
    {
        $db = Database::getConnection();
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE users SET userpassword = :password WHERE email = :email');
        $result = $stmt->execute([
            'password' => $passwordHash,
            'email' => $email
        ]);
        return $result;
    }

    /**
     * Vérifie si un pseudo est déjà utilisé.
     *
     * @param string $login Pseudo à rechercher.
     *
     * @return bool true si le pseudo existe.
     */    

    public function findAccountByUsername(string $login): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT username FROM users WHERE username = :login');
        $stmt->execute(['login' => $login]);
        // Si fetch() trouve quelque chose ça renvoie true sinon false
        return $stmt->fetch() !== false;
    }

    /**
     * Crée un jeton de réinitialisation de mot de passe valable 1 heure.
     *
     * Supprime d'abord les anciens jetons de cet e-mail, puis génère un
     * jeton aléatoire. Seul son hash SHA-256 est stocké en base ; le jeton
     * en clair est retourné pour être inséré dans le lien envoyé par mail.
     *
     * @param string $email Adresse e-mail du compte concerné.
     *
     * @return string Le jeton en clair (64 caractères hexadécimaux).
     */

    public function createResetToken(string $email): string {
        $db = Database::getConnection();
        $db->prepare('DELETE FROM password_resets WHERE email = :email')
            ->execute(['email' => $email]);

        $token = bin2hex(random_bytes(32));
        $stmt = $db->prepare(
            "INSERT INTO password_resets (token_hash, email, expires_at)
            VALUES (:hash, :email, NOW() + INTERVAL '1 hour')"
        );
        $stmt->execute([
            'hash'  => hash('sha256', $token),
            'email' => $email,
        ]);

        return $token; 
    }

    /**
     * Trouve l'adresse e-mail associée à un jeton de réinitialisation si celui-ci existe et n'a pas expiré.
     *
     * @param string $token Jeton de réinitialisation.
     *
     * @return string|null L'adresse e-mail si le jeton est valide, null sinon.
     */
    public function findEmailByToken(string $token): ?string {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT email FROM password_resets WHERE token_hash = :hash AND expires_at > NOW()'
        );
        $stmt->execute(['hash' => hash('sha256', $token)]);
        $row = $stmt->fetch();

        return $row ? $row['email'] : null;
    }

    
    /**
     * Supprime un jeton de la table `password_resets` pour qu'il ne soit
     * plus utilisable.
     *
     * @param string $token Jeton en clair à invalider.
     */

    public function deleteResetToken(string $token): void
    {
        $db = Database::getConnection();
        $db->prepare('DELETE FROM password_resets WHERE token_hash = :hash')
            ->execute(['hash' => hash('sha256', $token)]);
    }
}
?>
