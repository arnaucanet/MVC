<?php

include_once 'database/database.php';
include_once 'model/Pedido.php';

class PedidoDAO {
    private $db;

    public function __construct() {
        $this->db = DataBase::connect();
    }

    public function getPedidos() {
        $result = $this->db->query("SELECT * FROM pedido");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($pedido) {
        $stmt = $this->db->prepare("INSERT INTO pedido (id_usuario, id_oferta, fecha_pedido, estado, total, moneda, nombre_destinatario, direccion_envio, cp, ciudad, telefono_contacto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $id_usuario = $pedido->getId_usuario();
        $id_oferta = $pedido->getId_oferta();
        $fecha_pedido = $pedido->getFecha_pedido();
        $estado = $pedido->getEstado();
        $total = $pedido->getTotal();
        $moneda = $pedido->getMoneda();
        
        $nombre = $pedido->getNombre_destinatario();
        $direccion = $pedido->getDireccion_envio();
        $cp = $pedido->getCp();
        $ciudad = $pedido->getCiudad();
        $tlf = $pedido->getTelefono_contacto();
        
        $stmt->bind_param("iissdssssss", $id_usuario, $id_oferta, $fecha_pedido, $estado, $total, $moneda, $nombre, $direccion, $cp, $ciudad, $tlf);

        return $stmt->execute();
    }

    public function getPedidosByUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM pedido WHERE id_usuario = ? ORDER BY fecha_pedido DESC");
        
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedido = new Pedido();
            $pedido->setId_pedido($row['id_pedido']);
            $pedido->setId_usuario($row['id_usuario']);
            $pedido->setId_oferta($row['id_oferta']);
            $pedido->setFecha_pedido($row['fecha_pedido']);
            $pedido->setEstado($row['estado']);
            $pedido->setTotal($row['total']);
            $pedido->setMoneda($row['moneda']);
            $pedido->setNombre_destinatario($row['nombre_destinatario']);
            $pedido->setDireccion_envio($row['direccion_envio']);
            $pedido->setCp($row['cp']);
            $pedido->setCiudad($row['ciudad']);
            $pedido->setTelefono_contacto($row['telefono_contacto']);
            
            $pedidos[] = $pedido;
        }
        return $pedidos;
    }
}