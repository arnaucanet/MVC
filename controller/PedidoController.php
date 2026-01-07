<?php

include_once 'model/Pedido.php';
include_once 'model/DetallePedido.php';
include_once 'model/DAO/PedidoDAO.php';
include_once 'model/DAO/DetallePedidoDAO.php';
include_once 'model/DAO/UsuarioDAO.php';

class PedidoController {
    
    public function checkout() {
        
        // verificamos que recibimos datos por tramitar pedido
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
            
            //datos del carrito
            $datosEnBruto = $_POST['cart_data'];
            
            //convertir texto en array asociativo y no en objeto
            $carrito = json_decode($datosEnBruto, true);
            

            // no olvidar que productos se estan comprando
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['checkout_cart'] = $carrito;
            
            // cargamos la vista y le pasamos la variable $carrito
            include 'view/pedido/checkout.php';
            
        } else {
            // redireciconar a index si alguien accede sin datos
            header("Location: index.php");
        }
    }

    public function confirm() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // verificar usuario logueado
        if (!isset($_SESSION['user_id'])) {
            // redirigir al login para que inicie sesion
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }
        
        $userId = $_SESSION['user_id'];

        // verificar carrito en sesion
        if (!isset($_SESSION['checkout_cart']) || empty($_SESSION['checkout_cart'])) {
            header("Location: index.php");
            exit();
        }

        $carrito = $_SESSION['checkout_cart'];
        
        // guardar datos
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $cp = $_POST['cp'];
        $ciudad = $_POST['ciudad'];
        $telefono = $_POST['telefono'];
        
        $nombreCompleto = trim($nombre . ' ' . $apellidos);


        // calcular total euros
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['price'] * $item['cantidad'];
        }

        // crear Pedido
        $pedido = new Pedido();
        $pedido->setId_usuario($userId);
        $pedido->setId_oferta(null); // Explicit null
        $pedido->setFecha_pedido(date('Y-m-d H:i:s'));
        $pedido->setEstado('pendiente');
        $pedido->setTotal($total);
        $pedido->setMoneda('EUR');
        
        // establecer datos de envio
        $pedido->setNombre_destinatario($nombreCompleto);
        $pedido->setDireccion_envio($direccion);
        $pedido->setCp($cp);
        $pedido->setCiudad($ciudad);
        $pedido->setTelefono_contacto($telefono);
        
        $pedidoDAO = new PedidoDAO();
        // insertar primero el pedido
        $pedidoId = $pedidoDAO->create($pedido);

        if ($pedidoId) {
            // crear detalle_pedido en base al id del pedido
            $detalleDAO = new DetallePedidoDAO();
            
            foreach ($carrito as $item) {
                $detalle = new DetallePedido();
                $detalle->setId_pedido($pedidoId);
                $detalle->setId_producto($item['id']);
                $detalle->setCantidad($item['cantidad']);
                $detalle->setPrecio_unitario($item['price']);
                $detalle->setSubtotal($item['price'] * $item['cantidad']);
                
                $detalleDAO->create($detalle);
            }
            
            // limpiar carrito
            unset($_SESSION['checkout_cart']);
            
            // mostrar confirmacion de pedido
            include 'view/pedido/confirm.php';
        } else {
            // fallo
            echo "Error al crear el pedido. Por favor intente nuevamente.";
        }
    }

    public function mis_pedidos() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $pedidoDAO = new PedidoDAO();
        $pedidos = $pedidoDAO->getPedidosByUsuario($userId);

        include 'view/pedido/mis_pedidos.php';
    }

    public function detalle() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        $id_pedido = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if($id_pedido <= 0){
             header("Location: index.php?controller=Pedido&action=mis_pedidos");
             exit();
        }

        $userId = $_SESSION['user_id'];
        $pedidoDAO = new PedidoDAO();
        $pedido = $pedidoDAO->getPedidoById($id_pedido);

        // comprobar que el pedido existe y es del usuario
        if(!$pedido || $pedido->getId_usuario() != $userId){
             header("Location: index.php?controller=Pedido&action=mis_pedidos");
             exit();
        }

        $detalleDAO = new DetallePedidoDAO();
        $detalles = $detalleDAO->getDetallesByPedidoId($id_pedido);

        include 'view/pedido/detalle.php';
    }
}
