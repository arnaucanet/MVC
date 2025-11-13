<?php

include_once 'database/database.php';
include_once 'model/Oferta.php';

class OfertaDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

}