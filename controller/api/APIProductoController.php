<?php
include_once 'model/DAO/ProductoDAO.php';
include_once 'model/Producto.php';

class APIProductoController {
    
    public function index(){
        error_reporting(0);
        ini_set('display_errors', 0);

        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new ProductoDAO();

        header('Content-Type: application/json');

        if($method === 'GET'){
            if(isset($_GET['id'])){
                $product = $dao->getProductoById($_GET['id']);
                if($product){
                    echo json_encode($product);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Product not found']);
                }
            } else {
                $products = $dao->getProductos();
                if($products === false) $products = [];
                echo json_encode($products);
            }
        } elseif ($method === 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            if(!$data) $data = $_POST;
            
            if(empty($data['nombre']) || empty($data['descripcion']) || empty($data['precio']) || empty($data['imagen']) || empty($data['stock']) || empty($data['activo']) || empty($data['id_categoria'])){
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            $product = new Producto();
            $product->setNombre($data['nombre']);
            $product->setDescripcion($data['descripcion']);
            $product->setPrecio($data['precio']);
            $product->setImagen($data['imagen']);
            $product->setStock($data['stock']);
            $product->setActivo($data['activo'] ?? 0);
            $product->setId_categoria($data['id_categoria'] ?? 0);
            
            $id = $dao->create($product);
            if($id){
                http_response_code(201);
                echo json_encode(['id' => $id, 'message' => 'Product created']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create product']);
            }

        } elseif ($method === 'PUT') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if(empty($data['id_producto'])){
                http_response_code(400);
                echo json_encode(['error' => 'ID required']);
                return;
            }

            $productData = $dao->getProductoById($data['id_producto']);
            if(!$productData){
                http_response_code(404);
                echo json_encode(['error' => 'Product not found']);
                return;
            }

            $product = new Producto();
            $product->setId_producto($data['id_producto']);
            $product->setNombre($data['nombre'] ?? $productData['nombre']);
            $product->setDescripcion($data['descripcion'] ?? $productData['descripcion']);
            $product->setPrecio($data['precio'] ?? $productData['precio']);
            $product->setImagen($data['imagen'] ?? $productData['imagen']);
            $product->setStock($data['stock'] ?? $productData['stock']);
            $product->setActivo($data['activo'] ?? $productData['activo']);
            $product->setId_categoria($data['id_categoria'] ?? $productData['id_categoria']);
            
            if($dao->update($product)){
                echo json_encode(['message' => 'Product updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update']);
            }

        } elseif ($method === 'DELETE') {
            $id = $_GET['id'] ?? null;
            if(!$id){
                 $input = file_get_contents('php://input');
                 $data = json_decode($input, true);
                 $id = $data['id'] ?? null;
            }
            
            if($id && $dao->delete($id)){
                echo json_encode(['message' => 'Product deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
