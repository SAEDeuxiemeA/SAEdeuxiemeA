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
}
?>