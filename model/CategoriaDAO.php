<?php

require_once 'DataBase.php';

class CategoriaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getCategorias() {
        $result = $this->db->query("SELECT * FROM categoria");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}