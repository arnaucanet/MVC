<?php
include_once 'model/DAO/OfertaDAO.php';

class APIOfertaController {
    
    public function validate() {
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
