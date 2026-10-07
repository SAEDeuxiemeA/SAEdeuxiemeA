<?php

namespace model;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Gestion de la connexion à la base de données PostgreSQL.
 *
 * Utilise le patron singleton : une seule connexion PDO est créée
 * puis réutilisée pendant toute la requête.
 */

class Database{
        /** @var PDO|null Instance unique de la connexion, null tant qu'elle n'est pas créée. */
    private static ?PDO $instance = null;

    /**
     * Retourne la connexion PDO, en la créant au premier appel.
     *
     * La connexion est configurée pour lever des exceptions en cas d'erreur
     * SQL et pour retourner les résultats sous forme de tableaux associatifs.
     *
     * @return PDO Connexion à la base de données.
     *
     * @throws RuntimeException Si la connexion à la base échoue.
     */

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
