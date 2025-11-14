<?php include 'view/parcials/header.php'; ?>

<h1 class="text-danger mb-4">Mi Comida Favorita</h1>

<?php if (empty($mis_productos)): ?>
    <p>No tienes productos guardados todavía 🍽️</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($mis_productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white">
                    <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p><?= $producto['descripcion'] ?></p>
                        <p><strong><?= $producto['precio'] ?> €</strong></p>
                        <a href="index.php?controller=MiComida&action=eliminar&id=<?= $producto['id'] ?>" class="btn btn-outline-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'view/parcials/footer.php'; ?>