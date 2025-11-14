<?php include 'view/parcials/header.php'; ?>

<div class="text-center">
    <h1 class="mb-4 text-danger">Bienvenido a Netflix Eats</h1>
    <p>Tu comida favorita, servida al estilo cinematográfico 🎬🍕</p>
</div>

<div class="row mt-5">
    <?php foreach ($productos_destacados as $producto): ?>
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                    <p class="card-text"><?= $producto['descripcion'] ?></p>
                    <p><strong><?= $producto['precio'] ?> €</strong></p>
                    <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id'] ?>" class="btn btn-danger">Ver producto</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'view/parcials/footer.php'; ?>