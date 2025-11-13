<?php
require_once 'database/database.php';
require_once 'model/DAO/MiComidaDAO.php';
require_once 'model/DAO/ProductoDAO.php';

class MiComidaController {
    private $miComidaDAO;
    private $productoDAO;
    private $userId = 1; // Temporal, simula un usuario logueado

    public function __construct() {
        $this->miComidaDAO = new MiComidaDAO();
        $this->productoDAO = new ProductoDAO();
    }

    public function index() {
        $mis_productos = $this->miComidaDAO->getMiComida($this->userId);
        include 'view/micomida/index.php';
    }

    public function guardar() {
        $id_producto = $_GET['id'] ?? null;
        if($id_producto) {
            $this->miComidaDAO->guardarProducto($this->userId, $id_producto);
        }
        header('Location: index.php?controller=MiComida&action=index');
    }

    public function eliminar() {
        $id_producto = $_GET['id'] ?? null;
        if($id_producto) {
            $this->miComidaDAO->eliminarProducto($this->userId, $id_producto);
        }
        header('Location: index.php?controller=MiComida&action=index');
    }
}
?>