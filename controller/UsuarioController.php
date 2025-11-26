<?php
include_once 'model/DAO/UsuarioDAO.php';
include_once 'model/Usuario.php';

class UsuarioController {

    public function login(){
        require 'view/usuario/login.php';
    }

    public function loginPost(){
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $dao = new UsuarioDAO();
        $user = $dao->getByEmail($email);
        if(!$user){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            header('Location: index.php?controller=Usuario&action=login');
            return;
        }

        if(!password_verify($password, $user->getPassword())){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            header('Location: index.php?controller=Usuario&action=login');
            return;
        }

        $uid = $user->getId_usuario();
        $sig = sha1($user->getPassword() . ($_SERVER['HTTP_USER_AGENT'] ?? ''));
        $cookieVal = base64_encode(json_encode(['id'=>$uid,'sig'=>$sig]));
        $expire = $remember ? time() + (30*24*3600) : 0;
        setcookie('mvc_user', $cookieVal, $expire, '/', '', false, true);

        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id'] = $uid;

        header('Location: index.php');
    }

    public function register(){
        require 'view/usuario/register.php';
    }

    public function registerPost(){
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $direccion = trim($_POST['direccion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');

        if($nombre === '' || $email === '' || $password === ''){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Nombre, email y contraseña son requeridos';
            header('Location: index.php?controller=Usuario&action=register');
            return;
        }

        $dao = new UsuarioDAO();
        if($dao->getByEmail($email)){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Ya existe un usuario con ese email';
            header('Location: index.php?controller=Usuario&action=register');
            return;
        }

        $user = new Usuario();
        $user->setNombre($nombre);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setDireccion($direccion);
        $user->setTelefono($telefono);
        $user->setRol('user');

        $newId = $dao->create($user);
        if(!$newId){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Error al crear usuario';
            header('Location: index.php?controller=Usuario&action=register');
            return;
        }

        $sig = sha1($user->getPassword() . ($_SERVER['HTTP_USER_AGENT'] ?? ''));
        $cookieVal = base64_encode(json_encode(['id'=>$newId,'sig'=>$sig]));
        setcookie('mvc_user', $cookieVal, time() + (30*24*3600), '/', '', false, true);
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id'] = $newId;

        header('Location: index.php');
    }

    public function logout(){
        setcookie('mvc_user', '', time() - 3600, '/', '', false, true);
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: index.php');
    }
}
