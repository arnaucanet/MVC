<?php

include_once 'database/database.php';
include_once 'model/Usuario.php';

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getByEmail($email){
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE email = ? LIMIT 1");
        if(!$stmt) return null;
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if(!$row) return null;
        $u = new Usuario();
        if(isset($row['id_usuario'])) $u->setId_usuario($row['id_usuario']);
        if(isset($row['nombre'])) $u->setNombre($row['nombre']);
        if(isset($row['email'])) $u->setEmail($row['email']);
        if(isset($row['password'])) $u->setPassword($row['password']);
        if(isset($row['direccion'])) $u->setDireccion($row['direccion']);
        if(isset($row['telefono'])) $u->setTelefono($row['telefono']);
        if(isset($row['rol'])) $u->setRol($row['rol']);
        if(isset($row['fecha_registro'])) $u->setFecha_registro($row['fecha_registro']);
        return $u;
    }

    public function getById($id){
        $id = (int)$id;
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario = ? LIMIT 1");
        if(!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if(!$row) return null;
        $u = new Usuario();
        if(isset($row['id_usuario'])) $u->setId_usuario($row['id_usuario']);
        if(isset($row['nombre'])) $u->setNombre($row['nombre']);
        if(isset($row['email'])) $u->setEmail($row['email']);
        if(isset($row['password'])) $u->setPassword($row['password']);
        if(isset($row['direccion'])) $u->setDireccion($row['direccion']);
        if(isset($row['telefono'])) $u->setTelefono($row['telefono']);
        if(isset($row['rol'])) $u->setRol($row['rol']);
        if(isset($row['fecha_registro'])) $u->setFecha_registro($row['fecha_registro']);
        return $u;
    }

    public function create(Usuario $u){
        $stmt = $this->db->prepare("INSERT INTO usuario (nombre, email, password, direccion, telefono, rol, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if(!$stmt) return false;
        $nombre = $u->getNombre();
        $email = $u->getEmail();
        $password = $u->getPassword();
        $direccion = $u->getDireccion();
        $telefono = $u->getTelefono();
        $rol = $u->getRol() ?: 'cliente';
        $stmt->bind_param('ssssss', $nombre, $email, $password, $direccion, $telefono, $rol);
        $ok = $stmt->execute();
        if($ok) return $this->db->insert_id;
        return false;
    }

    public function getAll(){
        $stmt = $this->db->prepare("SELECT * FROM usuario");
        if(!$stmt) return [];
        $stmt->execute();
        $res = $stmt->get_result();
        $usuarios = [];
        while($row = $res->fetch_assoc()){
            $u = new Usuario();
            if(isset($row['id_usuario'])) $u->setId_usuario($row['id_usuario']);
            if(isset($row['nombre'])) $u->setNombre($row['nombre']);
            if(isset($row['email'])) $u->setEmail($row['email']);
            if(isset($row['password'])) $u->setPassword($row['password']);
            if(isset($row['direccion'])) $u->setDireccion($row['direccion']);
            if(isset($row['telefono'])) $u->setTelefono($row['telefono']);
            if(isset($row['rol'])) $u->setRol($row['rol']);
            if(isset($row['fecha_registro'])) $u->setFecha_registro($row['fecha_registro']);
            $usuarios[] = $u;
        }
        return $usuarios;
    }

    public function update(Usuario $u){
        $stmt = $this->db->prepare("UPDATE usuario SET nombre=?, email=?, password=?, direccion=?, telefono=?, rol=? WHERE id_usuario=?");
        if(!$stmt) return false;
        $nombre = $u->getNombre();
        $email = $u->getEmail();
        $password = $u->getPassword();
        $direccion = $u->getDireccion();
        $telefono = $u->getTelefono();
        $rol = $u->getRol();
        $id = $u->getId_usuario();
        
        $stmt->bind_param('ssssssi', $nombre, $email, $password, $direccion, $telefono, $rol, $id);
        return $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        if(!$stmt) return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
