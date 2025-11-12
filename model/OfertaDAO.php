<?php

require_once 'DataBase.php';

class OfertaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

}