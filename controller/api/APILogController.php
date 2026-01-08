<?php
include_once 'model/DAO/LogDAO.php';

class APILogController
{
    public function index()
    {
        // desactivar err visuales
        error_reporting(0);
        ini_set('display_errors', 0);

        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new LogDAO();

        header('Content-Type: application/json');

        if ($method === 'GET') {
            $logs = $dao->getLogs();
            if ($logs === false) $logs = [];
            echo json_encode($logs);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
