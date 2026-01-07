<?php include 'view/parcials/header.php'; ?>

<div class="product-detail-container">
    <div class="product-backdrop" style="background-image: url('<?= $producto['imagen'] ?>');">
        <div class="backdrop-overlay"></div>
    </div>

    <div class="product-content">
        <a href="javascript:history.back()" class="btn-back mb-4 d-inline-flex align-items-center text-white text-decoration-none">
            <img src="/MVC/public/icons/arrow-left-white.svg" alt="icon" width="24" height="24" class="me-2">
            Volver atrás
        </a>
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="<?= $producto['imagen'] ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="img-fluid product-poster shadow-lg">
            </div>
            <div class="col-md-6 product-info">
                <h1 class="display-4 fw-bold text-white mb-3"><?= htmlspecialchars($producto['nombre']) ?></h1>

                <?php
                $stock = (int)$producto['stock'];
                $isAvailable = $stock > 0;
                if ($stock > 10) {
                    $stockBadge = '<span class="badge bg-success mb-3">Disponible</span>';
                } elseif ($stock > 0) {
                    $stockBadge = '<span class="badge bg-warning text-dark mb-3">¡Últimas unidades! (' . $stock . ')</span>';
                } else {
                    $stockBadge = '<span class="badge bg-danger mb-3">Agotado</span>';
                }
                ?>
                <div><?= $stockBadge ?></div>

                <p class="lead text-white-50 mb-4"><?= htmlspecialchars($producto['descripcion']) ?></p>

                <div class="price-tag mb-4">
                    <span class="h2 text-white"><?= isset($producto['precio']) ? number_format($producto['precio'], 2) . ' €' : 'Consultar precio' ?></span>
                </div>

                <?php if ($isAvailable): ?>
                <div class="quantity-selector mb-4 d-flex align-items-center">
                    <label for="cantidad" class="text-white me-3 fw-bold">Cantidad:</label>
                    <div class="input-group" style="width: 140px;">
                        <button class="btn btn-outline-secondary text-white" type="button" onclick="cambiarCantidad(-1)">-</button>
                        <input type="number" id="cantidad" class="form-control bg-dark text-white text-center border-secondary" value="1" min="1" max="<?= min($stock, 10) ?>" readonly>
                        <button class="btn btn-outline-secondary text-white" type="button" onclick="cambiarCantidad(1)">+</button>
                    </div>
                    <span class="text-white ms-3 small">Máx. <?= min($stock, 10) ?></span>
                </div>
                <?php endif; ?>

                <div class="action-buttons d-flex gap-3 flex-wrap">
                    <?php if ($isAvailable): ?>
                    <a href="#" onclick="anadirAlCarrito(event, <?= $producto['id_producto'] ?>, '<?= addslashes($producto['nombre']) ?>', <?= $producto['precio'] ?>, '<?= $producto['imagen'] ?>')" class="btn btn-netflix-white btn-lg flex-grow-1">
                        <img src="/MVC/public/icons/cart-black.svg" alt="icon" width="24" height="24" class="me-2">
                        Añadir al Carrito
                    </a>
                    <?php else: ?>
                    <button class="btn btn-secondary btn-lg flex-grow-1" disabled>
                        No disponible
                    </button>
                    <?php endif; ?>

                    <a href="index.php?controller=MiComida&action=guardar&id=<?= $producto['id_producto'] ?>" class="btn btn-netflix-transparent btn-lg flex-grow-1">
                        <img src="/MVC/public/icons/heart-white.svg" alt="icon" width="24" height="24" class="me-2">
                        Añadir a Mi Comida
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/detalle.css">

<script>
function cambiarCantidad(cambio) {
    const input = document.getElementById('cantidad');
    
    let nuevoValor = parseInt(input.value) + cambio;
    
    const maximo = parseInt(input.getAttribute('max'));
    const minimo = parseInt(input.getAttribute('min'));
    
    if (nuevoValor >= minimo && nuevoValor <= maximo) {
        input.value = nuevoValor;
    }
}

function anadirAlCarrito(evento, id, nombre, precio, imagen) {
    evento.preventDefault();
    
    const input = document.getElementById('cantidad');
    const cantidad = input ? input.value : 1;
    
    addToCartJS(id, nombre, precio, imagen, cantidad);
}
</script>

<?php include 'view/parcials/footer.php'; ?>