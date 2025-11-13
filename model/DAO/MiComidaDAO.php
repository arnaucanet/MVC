<?php
include_once 'database/database.php';
include_once 'model/MiComida.php';

class MiComidaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getMiComida($id_usuario) {
        $stmt = $this->db->prepare(
            "SELECT p.* 
             FROM mi_comida m
             JOIN producto p ON m.id_producto = p.id_producto
             WHERE m.id_usuario = ?"
        );

        if(!$stmt) {
            die("Error en prepare: " . $this->db->error);
        }

        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function guardarProducto($id_usuario, $id_producto) {
        $stmt = $this->db->prepare(
            "INSERT INTO mi_comida (id_usuario, id_producto, fecha_agregado) VALUES (?, ?, NOW())"
        );
        if(!$stmt) die("Error en prepare: " . $this->db->error);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
    }

    public function eliminarProducto($id_usuario, $id_producto) {
        $stmt = $this->db->prepare(
            "DELETE FROM mi_comida WHERE id_usuario = ? AND id_producto = ?"
        );
        if(!$stmt) die("Error en prepare: " . $this->db->error);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
    }
}
?>