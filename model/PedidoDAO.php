<?php

require_once 'DataBase.php';

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