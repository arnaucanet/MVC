<?php
include_once 'model/DAO/OfertaDAO.php';
include_once 'model/DAO/LogDAO.php';
include_once 'model/Oferta.php';

class APIOfertaController
{
    public function index()
    {
        // iniciar sesion para logs
        if (session_status() == PHP_SESSION_NONE) session_start();
        $adminId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        error_reporting(0);
        ini_set('display_errors', 0);

        $method = $_SERVER['REQUEST_METHOD'];
        $dao = new OfertaDAO();
        $logDao = new LogDAO();

        header('Content-Type: application/json');

        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $oferta = $dao->getOfertaById($_GET['id']);
                if ($oferta) echo json_encode($this->ofertaToArray($oferta));
                else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Not found']);
                }
            } else {
                $ofertas = $dao->getAll();
                $data = [];
                foreach ($ofertas as $o) $data[] = $this->ofertaToArray($o);
                echo json_encode($data);
            }
        } elseif ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) $input = $_POST;

            if (empty($input['codigo'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field']);
                return;
            }

            $oferta = new Oferta();
            $oferta->setCodigo($input['codigo']);
            $oferta->setDescripcion($input['descripcion']);
            $oferta->setDescuento_porcentaje($input['descuento_porcentaje']);
            $oferta->setFecha_inicio($input['fecha_inicio']);
            $oferta->setFecha_fin($input['fecha_fin']);
            $oferta->setActiva(isset($input['activa']));

            $id = $dao->create($oferta);
            if ($id) {
                if ($adminId) $logDao->insert($adminId, "Creo oferta: " . $oferta->getCodigo());
                http_response_code(201);
                echo json_encode(['id' => $id, 'message' => 'Created']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed']);
            }
        } elseif ($method === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['id_oferta'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID required']);
                return;
            }

            $oferta = $dao->getOfertaById($input['id_oferta']);
            if (!$oferta) {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
                return;
            }

            $cambios = [];
            if (isset($input['codigo']) && $input['codigo'] !== $oferta->getCodigo()) {
                $cambios[] = 'codigo';
                $oferta->setCodigo($input['codigo']);
            }
            if (isset($input['descripcion']) && $input['descripcion'] !== $oferta->getDescripcion()) {
                $cambios[] = 'descripcion';
                $oferta->setDescripcion($input['descripcion']);
            }
            if (isset($input['descuento_porcentaje']) && $input['descuento_porcentaje'] != $oferta->getDescuento_porcentaje()) {
                $cambios[] = 'descuento';
                $oferta->setDescuento_porcentaje($input['descuento_porcentaje']);
            }
            if (isset($input['fecha_inicio']) && $input['fecha_inicio'] !== $oferta->getFecha_inicio()) {
                $cambios[] = 'fecha_inicio';
                $oferta->setFecha_inicio($input['fecha_inicio']);
            }
            if (isset($input['fecha_fin']) && $input['fecha_fin'] !== $oferta->getFecha_fin()) {
                $cambios[] = 'fecha_fin';
                $oferta->setFecha_fin($input['fecha_fin']);
            }
            if (isset($input['activa']) && $input['activa'] != $oferta->getActiva()) {
                $cambios[] = 'activa';
                $oferta->setActiva($input['activa']);
            }

            if ($dao->update($oferta)) {
                if ($adminId) {
                    $msg = "Actualizo oferta ID: " . $oferta->getId_oferta();
                    if (!empty($cambios)) $msg .= ". Campos: " . implode(', ', $cambios);
                    $logDao->insert($adminId, $msg);
                }
                echo json_encode(['message' => 'Updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed']);
            }
        } elseif ($method === 'DELETE') {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                $input = json_decode(file_get_contents('php://input'), true);
                $id = $input['id'] ?? null;
            }

            if ($id && $dao->delete($id)) {
                if ($adminId) $logDao->insert($adminId, "Elimino oferta ID: " . $id);
                echo json_encode(['message' => 'Deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed']);
            }
        }
    }

    //leer datos privados
    private function ofertaToArray($o)
    {
        return [
            'id_oferta' => $o->getId_oferta(),
            'codigo' => $o->getCodigo(),
            'descripcion' => $o->getDescripcion(),
            'descuento_porcentaje' => $o->getDescuento_porcentaje(),
            'fecha_inicio' => $o->getFecha_inicio(),
            'fecha_fin' => $o->getFecha_fin(),
            'activa' => $o->getActiva()
        ];
    }

    public function validate()
    {
        // desactivar err visuales
        error_reporting(0);
        ini_set('display_errors', 0);
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $codigo = isset($input['codigo']) ? trim($input['codigo']) : '';

        if (empty($codigo)) {
            http_response_code(400);
            echo json_encode(['error' => 'Código vacío']);
            return;
        }

        $dao = new OfertaDAO();
        $oferta = $dao->getOfertaByCodigo($codigo);

        if ($oferta) {
            echo json_encode([
                'valid' => true,
                'oferta' => [
                    'id_oferta' => $oferta->getId_oferta(),
                    'codigo' => $oferta->getCodigo(),
                    'descuento' => $oferta->getDescuento_porcentaje()
                ]
            ]);
        } else {
            echo json_encode(['valid' => false, 'error' => 'Código inválido o expirado']);
        }
    }
}
