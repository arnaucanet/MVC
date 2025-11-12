<?php

require_once 'DataBase.php';

class MiComidaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getMiComida() {
        $result = $this->db->query("SELECT * FROM mi_comida where");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}