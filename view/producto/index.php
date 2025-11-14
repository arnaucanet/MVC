<?php include 'view/parcials/header.php'; ?>

<h1 class="text-danger mb-4">Todos los productos</h1>

<div class="row">
    <?php foreach ($productos as $producto): ?>
        <div class="col-md-3 mb-4">
            <div class="card bg-dark text-white">
                <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                    <p><?= $producto['descripcion'] ?></p>
                    <p><strong><?= $producto['precio'] ?> €</strong></p>
                    <a href="index.php?controller=Producto&action=agregarCarrito&id=<?= $producto['id'] ?>" class="btn btn-danger">Añadir al carrito</a>
                    <a href="index.php?controller=MiComida&action=guardar&id=<?= $producto['id'] ?>" class="btn btn-outline-light">💾 Guardar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'view/parcials/footer.php'; ?>