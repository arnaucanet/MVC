<?php
require_once 'database/database.php';
require_once 'model/DAO/ProductoDAO.php';

class HomeController {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function index() {
        $productoDAO = new ProductoDAO();

        $producto_destacado      = $productoDAO->getProductoDestacado();
        $productos_recomendados  = $productoDAO->getProductosRecomendados();
        $productos_top10         = $productoDAO->getProductosTop10();
        $productos_extranjeros   = $productoDAO->getProductosExtranjeros();

        require "view/home/index.php";
    }
}