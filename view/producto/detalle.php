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
        <div class="row">
            <div class="col-md-5">
                <img src="<?= $producto['imagen'] ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="img-fluid product-poster shadow-lg">
            </div>
            <div class="col-md-7 product-info">
                <h1 class="display-4 fw-bold text-white mb-3"><?= htmlspecialchars($producto['nombre']) ?></h1>

                <p class="lead text-white-50 mb-4"><?= htmlspecialchars($producto['descripcion']) ?></p>

                <div class="price-tag mb-4">
                    <span class="h2 text-white"><?= isset($producto['precio']) ? number_format($producto['precio'], 2) . ' €' : 'Consultar precio' ?></span>
                </div>

                <div class="action-buttons d-flex gap-3">
                    <a href="index.php?controller=Pedido&action=add&id=<?= $producto['id_producto'] ?>" class="btn btn-netflix-white btn-lg">
                        <img src="/MVC/public/icons/cart-black.svg" alt="icon" width="24" height="24" class="me-2">
                        Añadir al Carrito
                    </a>

                    <a href="index.php?controller=MiComida&action=guardar&id=<?= $producto['id_producto'] ?>" class="btn btn-netflix-transparent btn-lg">
                        <img src="/MVC/public/icons/heart-white.svg" alt="icon" width="24" height="24" class="me-2">
                        Añadir a Mi Comida
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/detalle.css">

<?php include 'view/parcials/footer.php'; ?>