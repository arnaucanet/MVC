<?php
include_once 'model/DAO/CategoriaDAO.php';

class APICategoriaController
{

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new CategoriaDAO();

        header('Content-Type: application/json');

        if ($method === 'GET') {
            $categorias = $dao->getCategorias();
            echo json_encode($categorias);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
