<?php
include_once 'model/DAO/UsuarioDAO.php';
include_once 'model/Usuario.php';

class APIUsuarioController
{

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new UsuarioDAO();

        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $user = $dao->getById($_GET['id']);
                if ($user) {
                    echo json_encode($this->userToArray($user));
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                }
            } else {
                $users = $dao->getAll();
                $data = [];
                foreach ($users as $user) {
                    $data[] = $this->userToArray($user);
                }
                echo json_encode($data);
            }
        } elseif ($method === 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            if (!$data) $data = $_POST;

            if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            if ($dao->getByEmail($data['email'])) {
                http_response_code(409);
                echo json_encode(['error' => 'Email already exists']);
                return;
            }

            $user = new Usuario();
            $user->setNombre($data['nombre']);
            $user->setEmail($data['email']);
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            $user->setDireccion($data['direccion'] ?? '');
            $user->setTelefono($data['telefono'] ?? '');
            $user->setRol($data['rol'] ?? 'cliente');

            $id = $dao->create($user);
            if ($id) {
                http_response_code(201);
                echo json_encode(['id' => $id, 'message' => 'User created']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create user']);
            }
        } elseif ($method === 'PUT') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (empty($data['id_usuario'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID required']);
                return;
            }

            $user = $dao->getById($data['id_usuario']);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
                return;
            }

            if (isset($data['nombre'])) $user->setNombre($data['nombre']);
            if (isset($data['email'])) $user->setEmail($data['email']);
            if (isset($data['direccion'])) $user->setDireccion($data['direccion']);
            if (isset($data['telefono'])) $user->setTelefono($data['telefono']);
            if (isset($data['rol'])) $user->setRol($data['rol']);

            if (isset($data['password']) && !empty($data['password'])) {
                $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            }

            if ($dao->update($user)) {
                echo json_encode(['message' => 'User updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update']);
            }
        } elseif ($method === 'DELETE') {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
                $id = $data['id'] ?? null;
            }

            if ($id && $dao->delete($id)) {
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

    private function userToArray($user)
    {
        return [
            'id_usuario' => $user->getId_usuario(),
            'nombre' => $user->getNombre(),
            'email' => $user->getEmail(),
            'direccion' => $user->getDireccion(),
            'telefono' => $user->getTelefono(),
            'rol' => $user->getRol(),
            'fecha_registro' => $user->getFecha_registro()
        ];
    }
}
