<?php
include_once 'model/DAO/PedidoDAO.php';
include_once 'model/Pedido.php';

class APIPedidoController
{

    public function index()
    {
        // desactivar err visuales
        error_reporting(0);
        ini_set('display_errors', 0);

        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new PedidoDAO();

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

            if (isset($data['estado'])) $pedido->setEstado($data['estado']);

            if ($dao->update($pedido)) {
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
