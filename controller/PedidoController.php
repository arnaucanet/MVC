<?php
class PedidoController {
    
    public function checkout() {
        
        // verificamos que recibimos datos por tramitar pedido
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
            
            //datos del carrito
            $datosEnBruto = $_POST['cart_data'];
            
            //convertir texto en array asociativo y no en objeto
            $carrito = json_decode($datosEnBruto, true);
            
            // cargamos la vista y le pasamos la variable $carrito
            include 'view/pedido/checkout.php';
            
        } else {
            // redireciconar a index si alguien accede sin datos
            header("Location: index.php");
        }
    }
}
