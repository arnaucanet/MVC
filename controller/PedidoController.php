<?php

include_once 'model/Pedido.php';
include_once 'model/DetallePedido.php';
include_once 'model/DAO/PedidoDAO.php';
include_once 'model/DAO/DetallePedidoDAO.php';
include_once 'model/DAO/UsuarioDAO.php';
include_once 'model/DAO/OfertaDAO.php';

class PedidoController
{

    public function checkout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // si llegan datos los actualizamos
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
            $datosEnBruto = $_POST['cart_data'];
            $carrito = json_decode($datosEnBruto, true);
            $_SESSION['checkout_cart'] = $carrito;
        }

        // mostrar vista si tenemos datos en sesion
        if (isset($_SESSION['checkout_cart']) && !empty($_SESSION['checkout_cart'])) {
            $carrito = $_SESSION['checkout_cart'];
            include 'view/pedido/checkout.php';
        } else {
            // redirigir si no hay datos
            header("Location: index.php");
        }
    }

    public function confirm()
    {
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

        //gestionar descuento por sesion
        $id_oferta = null;
        if (isset($_SESSION['oferta_aplicada'])) {
            $id_oferta = $_SESSION['oferta_aplicada']['id'];
            $descuentoPorc = $_SESSION['oferta_aplicada']['descuento'];

            // aplicar el descuento
            $descuento = $total * ($descuentoPorc / 100);
            $total = $total - $descuento;

            // borrar descuento de sesion
            unset($_SESSION['oferta_aplicada']);
        }

        // crear Pedido
        $pedido = new Pedido();
        $pedido->setId_usuario($userId);
        $pedido->setId_oferta($id_oferta);
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

    public function mis_pedidos()
    {
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

    public function detalle()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        $id_pedido = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id_pedido <= 0) {
            header("Location: index.php?controller=Pedido&action=mis_pedidos");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $pedidoDAO = new PedidoDAO();
        $pedido = $pedidoDAO->getPedidoById($id_pedido);

        // comprobar que el pedido existe y es del usuario
        if (!$pedido || $pedido->getId_usuario() != $userId) {
            header("Location: index.php?controller=Pedido&action=mis_pedidos");
            exit();
        }

        $detalleDAO = new DetallePedidoDAO();
        $detalles = $detalleDAO->getDetallesByPedidoId($id_pedido);

        $oferta = null;
        if ($pedido->getId_oferta()) {
            include_once 'model/DAO/OfertaDAO.php';
            $ofertaDAO = new OfertaDAO();
            $oferta = $ofertaDAO->getOfertaById($pedido->getId_oferta());
        }

        include 'view/pedido/detalle.php';
    }

    public function aplicarDescuento()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['codigo'])) {
            $codigo = $_POST['codigo'];
            $ofertaDAO = new OfertaDAO();
            $oferta = $ofertaDAO->getOfertaByCodigo($codigo);

            if ($oferta) {
                $_SESSION['oferta_aplicada'] = [
                    'id' => $oferta->getId_oferta(),
                    'codigo' => $oferta->getCodigo(),
                    'descuento' => $oferta->getDescuento_porcentaje()
                ];
                unset($_SESSION['error_cupon']);
            } else {
                $_SESSION['error_cupon'] = 'El código no es válido.';
                unset($_SESSION['oferta_aplicada']);
            }
        }

        header('Location: index.php?controller=Pedido&action=checkout');
        exit();
    }
}
