<?php
include_once 'model/DAO/PedidoDAO.php';
include_once 'model/DAO/LogDAO.php';
include_once 'model/Pedido.php';

class APIPedidoController
{

    public function index()
    {
        // iniciar sesion si no esta iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // desactivar err visuales
        error_reporting(0);
        ini_set('display_errors', 0);

        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new PedidoDAO();
        $logDao = new LogDAO();

        header('Content-Type: application/json');

        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $pedido = $dao->getPedidoById($_GET['id']);
                if ($pedido) {
                    echo json_encode($this->pedidoToArray($pedido));
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Order not found']);
                }
            } else {
                // listar todos
                $pedidos = $dao->getPedidos();
                if ($pedidos === false) $pedidos = [];
                echo json_encode($pedidos);
            }
        } elseif ($method === 'PUT') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (empty($data['id_pedido'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID requerido']);
                return;
            }

            $pedido = $dao->getPedidoById($data['id_pedido']);
            if (!$pedido) {
                http_response_code(404);
                echo json_encode(['error' => 'Order not found']);
                return;
            }

            $cambios = [];
            $oldEstado = $pedido->getEstado();
            
            if (isset($data['estado'])) {
                $pedido->setEstado($data['estado']);
                if ($oldEstado != $data['estado']) {
                    $cambios[] = "estado ('$oldEstado' -> '{$data['estado']}')";
                }
            }

            if ($dao->update($pedido)) {
                
                // coger id del admin
                $adminId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                // si hay admin guardamos el log
                if ($adminId) {
                    $accion = "Actualizo pedido #" . $pedido->getId_pedido();
                    if (!empty($cambios)) {
                        $accion .= ". Campos: " . implode(", ", $cambios);
                    }
                    $logDao->insert($adminId, $accion);
                }

                echo json_encode(['message' => 'Order updated']);
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
                
                // coger id admin
                $adminId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                // guardar log de borrado
                if ($adminId) {
                    $logDao->insert($adminId, "Elimino pedido ID: " . $id);
                }

                echo json_encode(['message' => 'Order deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    private function pedidoToArray($pedido)
    {
        return [
            'id_pedido' => $pedido->getId_pedido(),
            'id_usuario' => $pedido->getId_usuario(),
            'id_oferta' => $pedido->getId_oferta(),
            'fecha_pedido' => $pedido->getFecha_pedido(),
            'estado' => $pedido->getEstado(),
            'total' => $pedido->getTotal(),
            'moneda' => $pedido->getMoneda(),
            'nombre_destinatario' => $pedido->getNombre_destinatario(),
            'direccion_envio' => $pedido->getDireccion_envio(),
            'cp' => $pedido->getCp(),
            'ciudad' => $pedido->getCiudad(),
            'telefono_contacto' => $pedido->getTelefono_contacto()
        ];
    }
}
