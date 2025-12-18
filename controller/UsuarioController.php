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

        // iniciar sesion
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id'] = $user->getId_usuario();

        // si marca remember
        if($remember){
            // 30 dias
            setcookie('id_usuario_guardado', $user->getId_usuario(), time() + (30*24*60*60), "/");
        }

        if($user->getRol() === 'administrador'){
            header('Location: index.php?controller=Admin');
            return;
        }

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
        $user->setRol('cliente');

        $newId = $dao->create($user);
        if(!$newId){
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Error al crear usuario';
            header('Location: index.php?controller=Usuario&action=register');
            return;
        }

        // Iniciamos sesión automáticamente
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id'] = $newId;

        // Creamos la cookie simple también al registrarse (por defecto 30 días)
        setcookie('id_usuario_guardado', $newId, time() + (30*24*60*60), "/");

        header('Location: index.php');
    }

    public function logout(){
        // Borramos la cookie simple (poniendo fecha en el pasado)
        setcookie('id_usuario_guardado', '', time() - 3600, '/');
        
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: index.php');
    }
}
