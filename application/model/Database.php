<?php

namespace model;

use PDO;
use PDOException;
use RuntimeException;

class Database{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $host = 'postgresql-bul.alwaysdata.net';
            $port = 5432; //5432 est le port par défaut sous postgreSQL
            $dbname = 'bul_bd';
            $user = 'bul_sae';
            $password = 'amkt0123';
        
            try {
                $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,]);
            } catch (PDOException $e) {
                throw new RuntimeException("Erreur de connexion : " . $e->getMessage());
            }
    }
    return self::$instance;
    }
}
?>
