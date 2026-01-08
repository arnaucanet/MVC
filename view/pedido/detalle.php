<?php include 'view/parcials/header.php'; ?>

<div class="container" style="padding-top: 100px; padding-bottom: 50px;">
    
    <div class="mb-4">
        <a href="index.php?controller=Pedido&action=mis_pedidos" class="text-decoration-none text-white d-inline-flex align-items-center">
            <img src="public/icons/arrow-left-white.svg" alt="Back" width="20" height="20" class="me-2">
            Volver a mis pedidos
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-dark border-secondary mb-4">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-white">Pedido #<?= $pedido->getId_pedido() ?></h4>
                    <?php 
                        $estado = $pedido->getEstado();
                        $clase = 'bg-secondary';
                        if($estado === 'entregado') $clase = 'bg-success';
                        elseif($estado === 'en proceso') $clase = 'bg-primary';
                        elseif($estado === 'pendiente') $clase = 'bg-warning text-dark';
                        elseif($estado === 'cancelado') $clase = 'bg-danger';
                    ?>
                    <span class="badge <?= $clase ?>"><?= $estado ?></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle mb-0">
                            <thead class="border-bottom border-secondary">
                                <tr>
                                    <th style="min-width: 300px;">Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $detalle): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if(!empty($detalle['imagen'])): ?>
                                                <img src="<?= $detalle['imagen'] ?>" alt="<?= $detalle['nombre_producto'] ?>" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <div class="fw-bold"><?= $detalle['nombre_producto'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">x<?= $detalle['cantidad'] ?></td>
                                    <td class="text-end"><?= $detalle['precio_unitario'] ?> €</td>
                                    <td class="text-end"><?= $detalle['subtotal'] ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark border-secondary mb-4">
                <div class="card-header border-secondary">
                    <h5 class="mb-0 text-white">Resumen</h5>
                </div>
                <div class="card-body">
                    <?php 
                        $subtotal_real = 0;
                        foreach($detalles as $d) {
                            $subtotal_real += $d['subtotal'];
                        }
                    ?>
                    <div class="d-flex justify-content-between mb-2 text-white-50">
                        <span>Subtotal</span>
                        <span><?= number_format($subtotal_real, 2) ?> €</span>
                    </div>
                    <?php if(isset($oferta) && $oferta): ?>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Descuento (<?= $oferta->getCodigo() ?>)</span>
                        <span>-<?= number_format($subtotal_real - $pedido->getTotal(), 2) ?> €</span>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mb-2 text-white-50">
                        <span>Envío</span>
                        <span>0.00 €</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between mb-0 fs-5 text-white fw-bold">
                        <span>Total</span>
                        <span><?= $pedido->getTotal() ?> <?= $pedido->getMoneda() ?></span>
                    </div>
                </div>
            </div>

            <div class="card bg-dark border-secondary">
                <div class="card-header border-secondary">
                    <h5 class="mb-0 text-white">Detalles de Envío</h5>
                </div>
                <div class="card-body text-white-50">
                    <p class="mb-1 fw-bold text-white"><?= $pedido->getNombre_destinatario() ?></p>
                    <p class="mb-1"><?= $pedido->getDireccion_envio() ?></p>
                    <p class="mb-1"><?= $pedido->getCp() ?>, <?= $pedido->getCiudad() ?></p>
                    <?php if($pedido->getTelefono_contacto()): ?>
                        <p class="mb-0 mt-2"><small>Tel: <?= $pedido->getTelefono_contacto() ?></small></p>
                    <?php endif; ?>
                    <p class="mb-0 mt-3"><small>Fecha: <?= date('d/m/Y H:i', strtotime($pedido->getFecha_pedido())) ?></small></p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'view/parcials/footer.php'; ?>