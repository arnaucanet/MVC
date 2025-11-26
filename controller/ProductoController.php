<?php
require_once 'database/database.php';
require_once 'model/DAO/ProductoDAO.php';

class ProductoController {
    private $db;
    private $productoDAO;

    public function __construct() {
        $this->db = DataBase::connect();
        $this->productoDAO = new ProductoDAO($this->db);
    }

    public function index() {
        $productos = $this->productoDAO->getProductos();
        include 'view/producto/index.php';
    }
}