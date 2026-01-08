<?php

$controllerParam = $_GET['controller'] ?? 'Home';
$action = $_GET['action'] ?? 'index';

$controllerName = $controllerParam . 'Controller';
$controllerPath = "controller/$controllerName.php";

// comprobar si es api
if (strpos($controllerParam, 'api/') === 0) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    // sacar el nombre del controlador
    $parts = explode('/', $controllerName);
    $className = end($parts);
} else {

    // aqui ya viene correcto
    $className = $controllerName;
}

//comprobar si existe el controlador
if (file_exists($controllerPath)) {
    require_once $controllerPath;
} else {
    if (file_exists("controller/$className.php")) {
        require_once "controller/$className.php";
    }
}

//comprobar si la clase existe
if (class_exists($className)) {
    $controllerObj = new $className();

    //comprobar si el metodo existe
    if (method_exists($controllerObj, $action)) {
        $controllerObj->$action();
    } else {

        // accion no encontrada
        if (strpos($controllerParam, 'api/') === 0) {
            http_response_code(404);
            echo json_encode(['error' => 'Action not found']);
        } else {
            echo "Action not found";
        }
    }
} else {
    echo "Controller class $className not found";
}
