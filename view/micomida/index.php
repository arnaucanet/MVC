<?php include 'view/parcials/header.php'; ?>
<div class="container" style="padding-top:90px;">

<h1 class="text-danger mb-4">Mi Comida Favorita</h1>

<?php if (!isset($is_logged_in) || !$is_logged_in): ?>
    <div class="bg-dark alert alert-dark text-white" role="alert">
        Debes <a href="index.php?controller=Usuario&action=login" class="alert-link text-danger">iniciar sesión</a> para ver tu lista de comida favorita.
    </div>
<?php elseif (empty($mis_productos)): ?>
    <p>No tienes productos guardados todavia</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($mis_productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white">
                    <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id_producto'] ?>">
                        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p><?= $producto['descripcion'] ?></p>
                        <p><strong><?= $producto['precio'] ?> €</strong></p>
                        <a href="index.php?controller=MiComida&action=eliminar&id=<?= $producto['id_producto'] ?>" class="btn btn-outline-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</div>
<?php include 'view/parcials/footer.php'; ?>