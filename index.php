<?php



$controllerParam = $_GET['controller'] ?? 'Home';
$action = $_GET['action'] ?? 'index';

$controllerName = $controllerParam . 'Controller';
$controllerPath = "controller/$controllerName.php";

// Check if it's an API controller (e.g. controller=api/APIUsuario)
if (strpos($controllerParam, 'api/') === 0) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        http_response_code(204);
        exit;
    }
    
    // Extract class name from path (e.g. api/APIUsuarioController -> APIUsuarioController)
    $parts = explode('/', $controllerName);
    $className = end($parts);
} else {
    $className = $controllerName;
}

if(file_exists($controllerPath)){
    require_once $controllerPath;
} else {
    // Fallback or 404
    if(file_exists("controller/$className.php")){
         require_once "controller/$className.php";
    }
}

if(class_exists($className)){
    $controllerObj = new $className();
    if(method_exists($controllerObj, $action)){
        $controllerObj->$action();
    } else {
        // Action not found
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
