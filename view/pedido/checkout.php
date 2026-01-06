<?php include 'view/parcials/header.php'; ?>
<div class="container mt-5 pt-5">
    <h2 class="text-white mb-4">Finalizar Compra</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card bg-dark text-white mb-3 border-secondary">
                <div class="card-header border-secondary">Resumen del Pedido</div>
                <div class="card-body">
                    <?php if (!empty($carrito)): ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;"></th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($carrito as $item): 
                                        $subtotal = $item['price'] * $item['cantidad'];
                                        $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td><img src="<?= htmlspecialchars($item['image']) ?>" width="40" height="40" class="rounded" style="object-fit: cover;"></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= number_format($item['price'], 2) ?> €</td>
                                        <td><?= $item['cantidad'] ?></td>
                                        <td><?= number_format($subtotal, 2) ?> €</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total:</td>
                                        <td class="fw-bold text-success"><?= number_format($total, 2) ?> €</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No hay productos en el carrito.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-body">
                    <h5 class="card-title mb-3">Datos de Envío</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-muted">Dirección</label>
                            <input type="text" class="form-control bg-secondary text-white border-0" placeholder="Calle, número...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Tarjeta</label>
                            <input type="text" class="form-control bg-secondary text-white border-0" placeholder="**** **** **** ****">
                        </div>
                        <button type="button" class="btn btn-red w-100 mt-2">Pagar Ahora</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'view/parcials/footer.php'; ?>
