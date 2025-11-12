<?php

require_once 'DataBase.php';

class DetallePedidoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getDetallePedidos() {
        $result = $this->db->query("SELECT * FROM detalle_pedido");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}