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
}