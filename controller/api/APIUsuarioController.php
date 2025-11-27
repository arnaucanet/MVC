<?php
include_once 'model/DAO/UsuarioDAO.php';
include_once 'model/Usuario.php';

class APIUsuarioController {
    
    public function index(){
        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new UsuarioDAO();

        // Set headers if not already set by index.php
        header('Content-Type: application/json');

        if($method === 'GET'){
            if(isset($_GET['id'])){
                $user = $dao->getById($_GET['id']);
                if($user){
                    echo json_encode($this->userToArray($user));
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                }
            } else {
                $users = $dao->getAll();
                $data = [];
                foreach($users as $u){
                    $data[] = $this->userToArray($u);
                }
                echo json_encode($data);
            }
        } elseif ($method === 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            if(!$data) $data = $_POST;
            
            if(empty($data['nombre']) || empty($data['email']) || empty($data['password'])){
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            if($dao->getByEmail($data['email'])){
                http_response_code(409);
                echo json_encode(['error' => 'Email already exists']);
                return;
            }

            $u = new Usuario();
            $u->setNombre($data['nombre']);
            $u->setEmail($data['email']);
            $u->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            $u->setDireccion($data['direccion'] ?? '');
            $u->setTelefono($data['telefono'] ?? '');
            $u->setRol($data['rol'] ?? 'cliente');
            
            $id = $dao->create($u);
            if($id){
                http_response_code(201);
                echo json_encode(['id' => $id, 'message' => 'User created']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create user']);
            }

        } elseif ($method === 'PUT') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if(empty($data['id_usuario'])){
                http_response_code(400);
                echo json_encode(['error' => 'ID required']);
                return;
            }

            $u = $dao->getById($data['id_usuario']);
            if(!$u){
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
                return;
            }

            if(isset($data['nombre'])) $u->setNombre($data['nombre']);
            if(isset($data['email'])) $u->setEmail($data['email']);
            if(isset($data['direccion'])) $u->setDireccion($data['direccion']);
            if(isset($data['telefono'])) $u->setTelefono($data['telefono']);
            if(isset($data['rol'])) $u->setRol($data['rol']);
            
            if(isset($data['password']) && !empty($data['password'])){
                $u->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            }
            
            if($dao->update($u)){
                echo json_encode(['message' => 'User updated']);
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
                echo json_encode(['message' => 'User deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    private function userToArray($u){
        return [
            'id_usuario' => $u->getId_usuario(),
            'nombre' => $u->getNombre(),
            'email' => $u->getEmail(),
            'direccion' => $u->getDireccion(),
            'telefono' => $u->getTelefono(),
            'rol' => $u->getRol(),
            'fecha_registro' => $u->getFecha_registro()
        ];
    }
}
