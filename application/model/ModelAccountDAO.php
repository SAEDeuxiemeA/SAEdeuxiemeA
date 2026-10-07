<?php
namespace model;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelAccount.php';

class ModelAccountDAO
{
    public function verifyConnection(string $email, string $password): ?ModelAccount
    {
        $db = Database::getConnection();

        $stmt = $db->prepare('SELECT username, userpassword, email, picture FROM users WHERE username = :login');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['userpassword'])) {
            return new ModelAccount($row['username'], $row['userpassword'], $row['email'], $row['picture']);
        }
        return null;
    }

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

    //Vérifier si l'email existe (Mot de passe oublié)
    public function findAccountByEmail(string $email): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        // Si fetch() trouve quelque chose ça renvoie true sinon false
        return $stmt->fetch() !== false;
    }

    //Mettre à jour le mot de passe
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

//Vérifier si le pseudo existe
    public function findAccountByUsername(string $login): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT username FROM users WHERE username = :login');
        $stmt->execute(['login' => $login]);
        // Si fetch() trouve quelque chose ça renvoie true sinon false
        return $stmt->fetch() !== false;
    }

    //Creation de Token pour reset le mot de passe
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

    //Retrouver à  quel email le Token est associé
    public function findEmailByToken(string $token): ?string {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT email FROM password_resets WHERE token_hash = :hash AND expires_at > NOW()'
        );
        $stmt->execute(['hash' => hash('sha256', $token)]);
        $row = $stmt->fetch();

        return $row ? $row['email'] : null;
    }

    //Supprime la ligne de la table password_reset(pour qu'un token ne soit plus valide.)
    public function deleteResetToken(string $token): void
    {
        $db = Database::getConnection();
        $db->prepare('DELETE FROM password_resets WHERE token_hash = :hash')
            ->execute(['hash' => hash('sha256', $token)]);
    }
}
?>
