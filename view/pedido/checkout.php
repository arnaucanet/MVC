<?php include "view/parcials/header.php"; ?>
<link href="/MVC/public/css/checkout.css" rel="stylesheet">

<div class="checkout-container" style="padding-top: 100px;">
    <h1 class="page-title">Pasar por caja</h1>

    <div class="row">
        <!-- formulario-->
        <div class="col-lg-7">
            <form action="index.php?controller=Pedido&action=confirm" method="POST" id="checkoutForm">
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
            </form>
        </div>

        <!-- resumen-->
        <div class="col-lg-5">
            <div class="summary-container">
                <!-- cupon -->
                <div class="summary-coupon mb-4 coupon-section">
                    <form action="index.php?controller=Pedido&action=aplicarDescuento" method="POST">
                        <label class="coupon-label">
                            <img src="public/icons/tag.svg" alt="icon" width="14" class="coupon-icon" style="filter: invert(1);">
                            Código de descuento
                        </label>
                        <div class="input-group">
                            <input type="text" name="codigo" class="form-control coupon-input" placeholder="Código" required>
                            <button class="btn btn-coupon" type="submit">Aplicar</button>
                        </div>
                    </form>

                    <?php if (isset($_SESSION['error_cupon'])): ?>
                        <div class="d-flex align-items-center mt-2 text-danger small">
                            <img src="public/icons/exclamation-circle.svg" alt="error" width="14" class="me-1">
                            <?= $_SESSION['error_cupon'] ?>
                        </div>
                        <?php unset($_SESSION['error_cupon']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['oferta_aplicada'])): ?>
                        <div class="d-flex align-items-center mt-2 text-success small">
                            <img src="public/icons/check-circle.svg" alt="success" width="14" class="me-1">
                            <span>Cupón <b><?= htmlspecialchars($_SESSION['oferta_aplicada']['codigo']) ?></b> aplicado (-<?= $_SESSION['oferta_aplicada']['descuento'] ?>%)</span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                $total = 0;
                if (!empty($carrito)) {
                    foreach ($carrito as $producto) {
                        $total += ($producto['price'] * ($producto['cantidad']));
                    }
                }

                // calculo visual
                $descuentoInfo = 0;
                if (isset($_SESSION['oferta_aplicada'])) {
                    $descuentoInfo = $total * ($_SESSION['oferta_aplicada']['descuento'] / 100);
                }
                $totalFinal = $total - $descuentoInfo;
                ?>

                <div class="summary-row">
                    <span>Subtotal: </span>
                    <span><?= $total ?> €</span>
                </div>

                <?php if ($descuentoInfo > 0): ?>
                    <div class="summary-row text-success">
                        <span>Descuento (<?= $_SESSION['oferta_aplicada']['descuento'] ?>%)</span>
                        <span>-<?= $descuentoInfo ?> €</span>
                    </div>
                <?php endif; ?>

                <div class="summary-row">
                    <span>Envío gratuito</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span><?= $totalFinal ?> €</span>
                </div>

                <div class="mt-4 pt-3 border-top border-secondary">
                    <p class="fw-bold mb-3">Llega en 1 hora</p>

                    <?php if (!empty($carrito)): ?>
                        <?php foreach ($carrito as $item): ?>
                            <div class="cart-item-preview">
                                <img src="<?= $item['image'] ?>" class="cart-item-img" alt="Prod">
                                <div class="cart-item-details">
                                    <h6 class="fw-bold"><?= number_format($item['price'], 2) ?> €</h6>
                                    <p class="text-white fw-bold"><?= htmlspecialchars($item['name']) ?></p>
                                    <p>Cant.: <?= $item['cantidad'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById("checkoutForm").addEventListener("submit", function() {
        localStorage.removeItem("netflixEatsCart");
        localStorage.removeItem("mi_carrito_netflix");
    });
</script>

<?php include "view/parcials/footer.php"; ?>