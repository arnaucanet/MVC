<?php include 'view/parcials/header.php'; ?>

<div class="product-detail-container">
    <div class="product-backdrop" style="background-image: url('<?= $producto['imagen'] ?>');">
        <div class="backdrop-overlay"></div>
    </div>
    
    <div class="product-content">
        <a href="javascript:history.back()" class="btn-back mb-4 d-inline-flex align-items-center text-white text-decoration-none">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                            <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Añadir al Carrito
                    </a>
                    
                    <a href="index.php?controller=MiComida&action=guardar&id=<?= $producto['id_producto'] ?>" class="btn btn-netflix-transparent btn-lg">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Añadir a Mi Comida
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/detalle.css">

<?php include 'view/parcials/footer.php'; ?>
