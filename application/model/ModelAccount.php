<?php

namespace model;

/**
 * Représente un compte utilisateur (une ligne de la table `users`).
*/

class ModelAccount{
    /** @var string Pseudo (clé primaire, 25 caractères maximum). */
    private string $login;

        /** @var string Mot de passe haché (`password_hash`). */
    private string $password;

    /** @var string Adresse e-mail (unique). */
    private string $email;

    /** @var string|null Chemin ou nom de l'image de profil, null si absente. */
    private ?string $picture; // ? c'est pour accepter les chaines vides.


    /**
     * @param string      $login    Pseudo de l'utilisateur.
     * @param string      $password Mot de passe haché.
     * @param string      $email    Adresse e-mail.
     * @param string|null $picture  Image de profil, ou null.
     */
    
    public function __construct(string $login, string $password, string $email, ?string $picture) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->picture = $picture;
    }
    /** @return string Le pseudo. */
    public function getLogin() : string {return $this->login;}
    
    /** @return string Le mot de passe haché. */
    public function getPassword() : string {return $this->password;}
    
    /** @return string L'adresse e-mail. */
    public function getEmail() : string {return $this->email;}
   
    /** @return string|null L'image de profil, ou null. */
    public function getPicture() : ?string {return $this->picture;}

    /**@param string $login Nouveau pseudo. */
    public function setLogin(string $login) : void {$this->login = $login;}
   
    /**@param string $password Nouveau mot de passe haché. */
    public function setPassword(string $password) : void {$this->password = $password;}
    
    public function setEmail(string $email) : void {$this->email = $email;}
   
    /**@param string|null $picture Nouvelle image de profil, ou null. */
    public function setPicture(?string $picture) : void {$this->picture = $picture;}
}
?>