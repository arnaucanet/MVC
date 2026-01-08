<?php

include_once 'database/database.php';
include_once 'model/Oferta.php';

class OfertaDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::connect();
    }

    public function getOfertaByCodigo($codigo)
    {
        $stmt = $this->db->prepare("SELECT * FROM oferta WHERE codigo = ? AND activa = 1 AND fecha_fin >= CURDATE()");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_object('Oferta')) {
            return $row;
        }
        return null;
    }

    public function getOfertaById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM oferta WHERE id_oferta = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_object('Oferta')) {
            return $row;
        }
        return null;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM oferta ORDER BY fecha_fin DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $ofertas = [];
        while ($row = $result->fetch_object('Oferta')) {
            $ofertas[] = $row;
        }
        return $ofertas;
    }

    public function create($oferta)
    {
        $sql = "INSERT INTO oferta (codigo, descripcion, descuento_porcentaje, fecha_inicio, fecha_fin, activa) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $codigo = $oferta->getCodigo();
        $desc = $oferta->getDescripcion();
        $porcen = $oferta->getDescuento_porcentaje();
        $finicio = $oferta->getFecha_inicio();
        $ffin = $oferta->getFecha_fin();
        $activa = $oferta->getActiva();

        $stmt->bind_param("ssissi", $codigo, $desc, $porcen, $finicio, $ffin, $activa);
        $ok = $stmt->execute();
        if ($ok) return $this->db->insert_id;
        return false;
    }

    public function update($oferta)
    {
        $sql = "UPDATE oferta SET codigo=?, descripcion=?, descuento_porcentaje=?, fecha_inicio=?, fecha_fin=?, activa=? WHERE id_oferta=?";
        $stmt = $this->db->prepare($sql);

        $codigo = $oferta->getCodigo();
        $desc = $oferta->getDescripcion();
        $porcen = $oferta->getDescuento_porcentaje();
        $finicio = $oferta->getFecha_inicio();
        $ffin = $oferta->getFecha_fin();
        $activa = $oferta->getActiva();
        $id = $oferta->getId_oferta();

        $stmt->bind_param("ssissii", $codigo, $desc, $porcen, $finicio, $ffin, $activa, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM oferta WHERE id_oferta = ?");
        if (!$stmt) return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
