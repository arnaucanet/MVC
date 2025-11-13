<?php

include_once 'database/database.php';
include_once 'model/Usuario.php';

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

}