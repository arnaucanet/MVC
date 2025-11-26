<?php
include_once 'database/database.php';
include_once 'model/Producto.php';

class ProductoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getProductos() {
        $result = $this->db->query("SELECT * FROM producto");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductoDestacado() {
        $sqlCat = "SELECT id_categoria FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 1";
        $resCat = $this->db->query($sqlCat);
        if ($resCat && $row = $resCat->fetch_assoc()) {
            $catId = $row['id_categoria'];
            $sql = "SELECT * FROM producto WHERE activo = 1 AND id_categoria = $catId ORDER BY RAND() LIMIT 1";
            return $this->db->query($sql)->fetch_assoc();
        }
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 1";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function getProductosRecomendados($limit = 12) {
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY RAND() LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductosTop10() {
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY stock DESC LIMIT 10";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductosExtranjeros($limit = 12) {
        $sql = "
            SELECT p.*
            FROM producto p
            INNER JOIN categoria c ON p.id_categoria = c.id_categoria
            WHERE c.nombre_categoria NOT LIKE '%Española%'
            ORDER BY RAND()
            LIMIT ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
