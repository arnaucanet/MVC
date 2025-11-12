<?php

require_once 'DataBase.php';

class ProductoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getProductos() {
        $result = $this->db->query("SELECT * FROM producto");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}