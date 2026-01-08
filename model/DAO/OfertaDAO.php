<?php

include_once 'database/database.php';
include_once 'model/Oferta.php';

class OfertaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getOfertaByCodigo($codigo) {
        $stmt = $this->db->prepare("SELECT * FROM oferta WHERE codigo = ? AND activa = 1 AND fecha_fin >= CURDATE()");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_object('Oferta')) {
            return $row;
        }
        return null;
    }

    public function getOfertaById($id) {
        $stmt = $this->db->prepare("SELECT * FROM oferta WHERE id_oferta = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_object('Oferta')) {
            return $row;
        }
        return null;
    }
}