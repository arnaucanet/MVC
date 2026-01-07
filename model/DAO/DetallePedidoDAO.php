<?php

include_once 'database/database.php';
include_once 'model/DetallePedido.php';

class DetallePedidoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getDetallePedidos() {
        $result = $this->db->query("SELECT * FROM detalle_pedido");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($detalle) {
        $stmt = $this->db->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");

        $id_pedido = $detalle->getId_pedido();
        $id_producto = $detalle->getId_producto();
        $cantidad = $detalle->getCantidad();
        $precio_unitario = $detalle->getPrecio_unitario();
        $subtotal = $detalle->getSubtotal();

        $stmt->bind_param("iiidd", $id_pedido, $id_producto, $cantidad, $precio_unitario, $subtotal);

        return $stmt->execute();
    }

    public function getDetallesByPedidoId($id_pedido) {
        // hacemos join con productos para obtener las imagenes
        $sql = "SELECT dp.*, p.nombre as nombre_producto, p.imagen 
                FROM detalle_pedido dp 
                JOIN producto p ON dp.id_producto = p.id_producto 
                WHERE dp.id_pedido = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}