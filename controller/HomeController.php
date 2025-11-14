<?php
require_once 'database/database.php';
require_once 'model/DAO/ProductoDAO.php';

class HomeController {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function index() {
        $productoDAO = new ProductoDAO($this->db);
        $productos_destacados = $productoDAO->getProductos();
        include 'view/home/index.php';
    }
}