<?php

namespace model;

class ModelCompte
{
    public function modelCompte() {
    $host = 'postgresql-bul.alwaysdata.net';
    $port = 5432; //5432 est le port par défaut sous postgreSQL
    $dbname = 'bul_bd';
    $user = 'bul_sae';
    $password = '0123';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $db = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
        echo "Connextion réussie.<br>";
}
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
}
}