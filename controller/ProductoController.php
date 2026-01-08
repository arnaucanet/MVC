<?php
require_once 'database/database.php';
require_once 'model/DAO/ProductoDAO.php';

class ProductoController
{
    private $db;
    private $productoDAO;

    public function __construct()
    {
        $this->db = DataBase::connect();
        $this->productoDAO = new ProductoDAO($this->db);
    }

    public function index()
    {
        $query = $_GET['q'] ?? '';
        $categoriaId = $_GET['categoria'] ?? null;

        if (!empty($query) || !empty($categoriaId)) {
            $productos = $this->productoDAO->searchProductos($query, $categoriaId);
        } else {
            $productos = $this->productoDAO->getProductos();
        }

        // categorias filtro
        require_once 'model/DAO/CategoriaDAO.php';
        $categoriaDAO = new CategoriaDAO();
        $categorias = $categoriaDAO->getCategorias();

        include 'view/producto/index.php';
    }

    public function detalle()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = $this->productoDAO->getProductoById($id);
            include 'view/producto/detalle.php';
        } else {
            header("Location: index.php");
        }
    }
}
