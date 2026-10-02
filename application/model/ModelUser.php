<?php

class ModelUtilisateur
{
    public function getUtilisateur($username)
    {
        // à adapter selon ce que font Mélissa et Ombeline 
        // pour la connexion à la base de données
        $requete = $this->connexion->prepare(
            'SELECT * FROM "user" WHERE username = :username'
        );

        $requete->execute([
            'username' => $username
        ]);

        return $requete->fetch(PDO::FETCH_ASSOC);
    }
}