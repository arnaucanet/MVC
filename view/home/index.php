<?php include 'view/parcials/header.php'; ?>

<?php if (!empty($producto_destacado)): ?>
<div class="banner" style="background-image: url('<?= $producto_destacado['imagen'] ?>');">
    <div class="banner-inner">
        <h1><?= $producto_destacado['nombre'] ?></h1>
        <p><?= $producto_destacado['descripcion'] ?></p>

        <div class="cta">
            <a href="index.php?controller=Pedido&action=add&id=<?= $producto_destacado['id_producto'] ?>" 
               class="btn-netflix-white text-decoration-none">Pedir ahora</a>
            <a href="index.php?controller=Producto&action=detalle&id=<?= $producto_destacado['id_producto'] ?>" 
               class="btn-netflix-transparent text-decoration-none">Mas informacion</a>
        </div>
    </div>
</div>

    <?php endif; ?>

<div class="home-container">

    <?php if (!empty($productos_recomendados)): ?>
<div class="carousel-category">Tendencias ahora</div>
<div class="row-carousel">
    <button class="carousel-btn left" data-target="tray-recomendados">
        <img src="/MVC/public/icons/chevron-left-white.svg" alt="icon" width="24" height="24" class="me-2">
    </button>
    <div class="tray" id="tray-recomendados">
        <?php foreach ($productos_recomendados as $prod): ?>
        <a href="index.php?controller=Producto&action=detalle&id=<?= $prod['id_producto'] ?>" class="text-decoration-none">
            <div class="card card-netflix portrait">
                <img src="<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
                <div class="card-overlay">
                    <div class="card-title text-white"><?= htmlspecialchars($prod['nombre']) ?></div>
                    <div class="card-sub"><?= isset($prod['precio']) ? '€'.$prod['precio'] : '' ?></div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <button class="carousel-btn right" data-target="tray-recomendados">
        <img src="/MVC/public/icons/chevron-right-white.svg" alt="icon" width="24" height="24" class="me-2">
    </button>
</div>
<?php endif; ?>

<?php if (!empty($productos_top10)): ?>
<div class="carousel-category mt-5">Los 10 platos más populares hoy en este país: España</div>
<div id="top10Carousel" class="carousel slide netflix-top10-carousel" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php $ranking = 1; $slides = array_chunk($productos_top10, 4); foreach ($slides as $index => $grupo): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
            <div class="row g-4 justify-content-center">
                <?php foreach ($grupo as $prod): ?>
                <div class="col-6 col-md-3 text-center top10-slide-card">
                    <div class="ranking-badge"><?= $ranking ?></div>
                    <a href="index.php?controller=Producto&action=detalle&id=<?= $prod['id_producto'] ?>" class="text-decoration-none">
                        <div class="card card-netflix portrait">
                            <img src="<?= $prod['imagen'] ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" loading="lazy">
                            <div class="card-overlay">
                                <div class="card-title text-white text-uppercase"><?= htmlspecialchars($prod['nombre']) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php $ranking++; endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#top10Carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#top10Carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>
<?php endif; ?>


<?php if (!empty($productos_extranjeros)): ?>
<div class="carousel-category mt-5">Comidas extranjeras</div>
<div class="row-carousel">
    <button class="carousel-btn left" data-target="tray-extranjeros">
        <img src="/MVC/public/icons/chevron-left-white.svg" alt="icon" width="24" height="24" class="me-2">
    </button>
    <div class="tray" id="tray-extranjeros">
        <?php foreach ($productos_extranjeros as $prod): ?>
        <a href="index.php?controller=Producto&action=detalle&id=<?= $prod['id_producto'] ?>" class="text-decoration-none">
            <div class="card card-netflix portrait">
                <img src="<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
                <div class="card-overlay">
                    <div class="card-title text-white"><?= htmlspecialchars($prod['nombre']) ?></div>
                    <div class="card-sub">Nuevo</div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <button class="carousel-btn right" data-target="tray-extranjeros">
        <img src="/MVC/public/icons/chevron-right-white.svg" alt="icon" width="24" height="24" class="me-2">
    </button>
</div>
<?php endif; ?>

<div class="promo-strip">
                <div class="promo-icon" aria-hidden="true">
                <img src="public/icons/popcorn.svg" alt="Popcorn" width="64" height="64">
            </div>
    <div class="promo-copy">
        <p class="promo-title">Disfruta de nuestra comida por tan solo 8,99 €</p>
        <p class="promo-sub">Todo lo que te encanta de Netflix… ahora para comer.</p>
    </div>
    <a class="promo-btn" href="index.php?controller=Producto&action=index" role="button">Más información</a>
</div>

</div>

<?php include 'view/parcials/footer.php'; ?>
