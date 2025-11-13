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

    // Ejemplo de método para agregar al carrito
    public function agregarCarrito() {
        $id_producto = $_GET['id'] ?? null;
        if($id_producto) {
            // Aquí deberías implementar lógica real de carrito
            // Por ejemplo: $_SESSION['carrito'][] = $id_producto;
            header('Location: index.php?controller=Producto&action=index');
        }
    }
}
?>
