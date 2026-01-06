<?php include "view/parcials/header.php"; ?>
<link href="/MVC/public/css/checkout.css" rel="stylesheet">

<div class="checkout-container" style="padding-top: 100px;">
    <h1 class="page-title">Pasar por caja</h1>

    <form action="index.php?controller=Pedido&action=confirm" method="POST" id="checkoutForm">
        <div class="row">
            <!-- formulario-->
            <div class="col-lg-7">
                <h4 class="mb-4">Opciones de entrega</h4>
                
                <!-- tipo de pedido-->
                <div class="delivery-options">
                    <div class="delivery-option active" id="opt-enviar" style="cursor: default;">
                        <!-- camion -->
                        <img src="public/icons/delivery-truck.svg" alt="Delivery" width="20" height="20" class="me-2">
                        Envío a domicilio
                    </div>
                </div>

                <!-- datos envio-->
                 <div class="form-group">
                    <label class="form-label">Correo electrónico*</label>
                    <input type="email" name="email" class="form-control-custom" required>
                    <div class="form-text">Introduce una dirección de correo electrónico válida.</div>
                 </div>

                 <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label">Nombre*</label>
                        <input type="text" name="nombre" class="form-control-custom" required>
                        <div class="form-text">Introduce tu nombre.</div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Apellidos*</label>
                        <input type="text" name="apellidos" class="form-control-custom" required>
                        <div class="form-text">Introduce tus apellidos.</div>
                    </div>
                 </div>

                 <div class="form-group">
                    <label class="form-label">Calle y número*</label>
                    <input type="text" name="direccion" class="form-control-custom" required>
                    <div class="form-text">Escribe una dirección válida.</div>
                 </div>

                 <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label">Código postal*</label>
                        <input type="text" name="cp" class="form-control-custom" required>
                        <div class="form-text">Introduce tu código postal.</div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Ciudad*</label>
                        <input type="text" name="ciudad" class="form-control-custom" required>
                        <div class="form-text">Escribe una ciudad válida.</div>
                    </div>
                 </div>

                 <div class="form-group">
                    <label class="form-label">Número de teléfono*</label>
                    <input type="tel" name="telefono" class="form-control-custom" required>
                    <div class="form-text">Este campo es obligatorio.</div>
                 </div>
                
                 <div class="text-center">
                    <button type="submit" class="btn-save-continue">
                        Guardar y continuar
                    </button>
                 </div>

            </div>

            <!-- resumen-->
            <div class="col-lg-5">
                <div class="summary-container">
                    <div class="summary-header">
                        <h4 class="m-0">En tu cesta</h4>
                    </div>
                    
                    <?php 
                    $total = 0;
                    if (!empty($carrito)) {
                        foreach ($carrito as $producto) {
                            $total += ($producto['price'] * ($producto['cantidad'] ?? 1));
                        }
                    }
                    ?>

                    <div class="summary-row">
                        <span>Subtotal: </span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                    <div class="summary-row">
                        <span>Envío gratuito</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary">
                        <p class="fw-bold mb-3">Llega en 1 hora</p>
                        
                        <?php if (!empty($carrito)): ?>
                            <?php foreach($carrito as $item): ?>
                            <div class="cart-item-preview">
                                <img src="<?= $item['img'] ?? $item['image'] ?? '' ?>" class="cart-item-img" alt="Prod">
                                <div class="cart-item-details">
                                    <h6 class="fw-bold"><?= number_format($item['price'], 2) ?> €</h6>
                                    <p class="text-white fw-bold"><?= htmlspecialchars($item['name']) ?></p>
                                    <p>Cant.: <?= $item['cantidad']?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById("checkoutForm").addEventListener("submit", function() {
        localStorage.removeItem("netflixEatsCart");
        localStorage.removeItem("mi_carrito_netflix");
    });
</script>

<?php include "view/parcials/footer.php"; ?>
