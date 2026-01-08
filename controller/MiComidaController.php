<?php
require_once 'database/database.php';
require_once 'model/DAO/MiComidaDAO.php';
require_once 'model/DAO/ProductoDAO.php';

class MiComidaController
{
    private $miComidaDAO;
    private $productoDAO;

    public function __construct()
    {
        $this->miComidaDAO = new MiComidaDAO();
        $this->productoDAO = new ProductoDAO();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $is_logged_in = isset($_SESSION['user_id']);
        if (!$is_logged_in) {
            $mis_productos = [];
        } else {
            $mis_productos = $this->miComidaDAO->getMiComida($_SESSION['user_id']);
        }
        include 'view/micomida/index.php';
    }

    public function guardar()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Usuario&action=login');
            return;
        }

        $id_producto = $_GET['id'] ?? null;
        if ($id_producto) {
            $this->miComidaDAO->guardarProducto($_SESSION['user_id'], $id_producto);
        }
        header('Location: index.php?controller=MiComida&action=index');
    }

    public function eliminar()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Usuario&action=login');
            return;
        }

        $id_producto = $_GET['id'] ?? null;
        if ($id_producto) {
            $this->miComidaDAO->eliminarProducto($_SESSION['user_id'], $id_producto);
        }
        header('Location: index.php?controller=MiComida&action=index');
    }
}
