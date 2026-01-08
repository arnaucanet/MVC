<?php

include_once 'database/database.php';
include_once 'model/Log.php';

class LogDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::connect();
    }

    public function getLogs()
    {
        $result = $this->db->query("SELECT * FROM log");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($id_usuario, $accion)
    {
        // fecha actual
        $fecha = date('Y-m-d H:i:s');
        // ip del usuario
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // preparar consulta para insertar log
        $stmt = $this->db->prepare("INSERT INTO log (id_usuario, accion, fecha, ip_usuario) VALUES (?, ?, ?, ?)");
        
        // vicular parametros
        $stmt->bind_param("isss", $id_usuario, $accion, $fecha, $ip);
        
        // ejecutar
        return $stmt->execute();
    }
}
