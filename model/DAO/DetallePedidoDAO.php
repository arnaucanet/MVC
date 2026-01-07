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
}