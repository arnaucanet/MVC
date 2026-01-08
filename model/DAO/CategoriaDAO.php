<?php

include_once 'database/database.php';
include_once 'model/Categoria.php';

class CategoriaDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::connect();
    }

    public function getCategorias()
    {
        $result = $this->db->query("SELECT * FROM categoria");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoriaById($id)
    {
        $id = (int)$id;
        $stmt = $this->db->prepare("SELECT * FROM categoria WHERE id_categoria = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if (!$row) return null;
        $cat = new Categoria();
        if (isset($row['id_categoria'])) $cat->setId_categoria($row['id_categoria']);
        if (isset($row['nombre_categoria'])) $cat->setNombre_categoria($row['nombre_categoria']);
        if (isset($row['descripcion'])) $cat->setDescripcion($row['descripcion']);
        if (isset($row['imagen_categoria'])) $cat->setImagen_categoria($row['imagen_categoria']);
        if (isset($row['activa'])) $cat->setActiva($row['activa']);
        return $cat;
    }
}
