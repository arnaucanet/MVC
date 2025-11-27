<?php
include_once 'model/DAO/UsuarioDAO.php';

class AdminController {
    public function index(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        
        if(!isset($_SESSION['user_id'])){
            header('Location: index.php?controller=Usuario&action=login');
            return;
        }

        $dao = new UsuarioDAO();
        $user = $dao->getById($_SESSION['user_id']);

        if(!$user || $user->getRol() !== 'administrador'){
            header('Location: index.php');
            return;
        }

        require 'view/admin/index.php';
    }
}
