<?php

require_once 'DataBase.php';

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

}