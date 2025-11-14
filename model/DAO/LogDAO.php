<?php

include_once 'database/database.php';
include_once 'model/Log.php';

class LogDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getLogs() {
        $result = $this->db->query("SELECT * FROM log");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}