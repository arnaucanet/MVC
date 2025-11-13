<?php



$controller = isset($_GET['controller']) ? $_GET['controller'].'Controller' : 'HomeController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';


if($controller === 'api'){

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST,PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        http_response_code(204);
        exit;
    }

    $resource = $_GET['resource'];
    $httpAction = $_SERVER['REQUEST_METHOD'];
    $id = $_GET['id'] ?? null;
}

require_once "controller/$controller.php";

$controllerObj = new $controller();
$controllerObj->$action();