<?php include 'view/parcials/header.php'; ?>

<div class="container" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Mis Pedidos</h1>
        <a href="index.php?controller=Producto&action=index" class="btn btn-outline-light">Seguir comprando</a>
    </div>

    <?php if (empty($pedidos)): ?>
        <div class="text-center py-5">
            <img src="public/icons/shopping-cart.svg" alt="Empty" width="64" height="64" style="filter: invert(1);" class="mb-3">
            <h3 class="text-white">Aún no has realizado ningún pedido</h3>
            <p class="text-white mb-4">¡Es hora de pedir tu comida favorita!</p>
            <a href="index.php?controller=Producto&action=index" class="btn btn-red btn-lg">Ver productos</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID Pedido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Total</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?= $pedido->getId_pedido() ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido->getFecha_pedido())) ?></td>
                            <td>
                                <?php
                                $estado = $pedido->getEstado();

                                $clase = 'badge-secondary';
                                if ($estado === 'entregado') $clase = 'badge-success';
                                elseif ($estado === 'en preparación') $clase = 'badge-primary';
                                elseif ($estado === 'en proceso') $clase = 'badge-primary';
                                elseif ($estado === 'enviado') $clase = 'badge-primary';
                                elseif ($estado === 'pendiente') $clase = 'badge-warning';
                                elseif ($estado === 'cancelado') $clase = 'badge-danger';
                                ?>
                                <span class="badge <?= $clase ?>"><?= htmlspecialchars($estado) ?></span>
                            </td>
                            <td class="fw-bold"><?= number_format($pedido->getTotal(), 2) ?> <?= htmlspecialchars($pedido->getMoneda()) ?></td>
                            <td class="text-end">
                                <a href="index.php?controller=Pedido&action=detalle&id=<?= $pedido->getId_pedido() ?>" class="btn btn-sm btn-outline-light">Ver detalles</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'view/parcials/footer.php'; ?>