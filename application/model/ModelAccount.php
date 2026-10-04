<?php

namespace model;

class ModelAccount{
    private string $login;
    private string $password;
    private string $email;
    private ?string $picture; // ? c'est pour accepter les chaines vides.

    public function __construct(string $login, string $password, string $email, ?string $picture) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->picture = $picture;
    }
    public function getLogin() : string {return $this->login;}
    public function getPassword() : string {return $this->password;}
    public function getEmail() : string {return $this->email;}
    public function getPicture() : ?string {return $this->picture;}

    public function setLogin(string $login) : void {$this->login = $login;}
    public function setPassword(string $password) : void {$this->password = $password;}
    public function setEmail(string $email) : void {$this->email = $email;}
    public function setPicture(?string $picture) : void {$this->picture = $picture;}
}
?>