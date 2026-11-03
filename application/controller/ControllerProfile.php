<?php

namespace controller;
use model\ModelAccountDAO;

class ControllerProfile extends Controller
{
    public function index(): void{
        if (isset($_SESSION['login'])){
            $account = (new ModelAccountDAO())->getAccountByUsername($_SESSION['login']);
            $this->render('ViewProfile', ['account' => $account]);
        }
        else{
            header('Location: index.php?page=login&action=index');
            exit;
        }
    }


}