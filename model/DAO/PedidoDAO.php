<?php

include_once 'database/database.php';
include_once 'model/Pedido.php';

class PedidoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getPedidos() {
        $result = $this->db->query("SELECT * FROM pedido");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}