<?php include 'view/parcials/header.php'; ?>

<?php if (!empty($producto_destacado)): ?>
<div class="banner" style="background-image: url('/MVC<?= $producto_destacado['imagen'] ?>');">
    <div class="banner-inner">
        <h1><?= $producto_destacado['nombre'] ?></h1>
        <p><?= $producto_destacado['descripcion'] ?></p>

        <div class="cta">
            <a href="index.php?controller=Pedido&action=crear&id=<?= $producto_destacado['id_producto'] ?>" 
               class="btn-netflix-white">Pedir ahora</a>
            <a href="index.php?controller=Producto&action=detalle&id=<?= $producto_destacado['id_producto'] ?>" 
               class="btn-netflix-transparent">Mas informacion</a>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container mt-4">

<?php if (!empty($productos_recomendados)): ?>
<div class="carousel-category">Para comer a continuacion</div>
<div class="row-carousel">
    <button class="carousel-btn left" data-target="tray-recomendados">◀</button>
    <div class="tray" id="tray-recomendados">
        <?php foreach ($productos_recomendados as $prod): ?>
        <div class="card card-netflix">
            <img src="/MVC<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
            <div class="card-overlay">
                <div class="card-title"><?= htmlspecialchars($prod['nombre']) ?></div>
                <div class="card-sub"><?= isset($prod['precio']) ? '€'.$prod['precio'] : '' ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-btn right" data-target="tray-recomendados">▶</button>
</div>
<?php endif; ?>

<?php if (!empty($productos_top10)): ?>
<div class="carousel-category mt-5">Los 10 platos mas populares hoy en España</div>
<div class="row-carousel">
    <button class="carousel-btn left" data-target="tray-top10">◀</button>
    <div class="tray" id="tray-top10">
        <?php $ranking = 1; foreach ($productos_top10 as $prod): ?>
        <div class="top10-card">
            <div class="top10-number"><?= $ranking ?></div>
            <div class="card card-netflix">
                <img src="/MVC<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
                <div class="card-overlay">
                    <div class="card-title"><?= htmlspecialchars($prod['nombre']) ?></div>
                </div>
            </div>
        </div>
        <?php $ranking++; endforeach; ?>
    </div>
    <button class="carousel-btn right" data-target="tray-top10">▶</button>
</div>
<?php endif; ?>

<?php if (!empty($productos_extranjeros)): ?>
<div class="carousel-category mt-5">Comidas extranjeras</div>
<div class="row-carousel">
    <button class="carousel-btn left" data-target="tray-extranjeros">◀</button>
    <div class="tray" id="tray-extranjeros">
        <?php foreach ($productos_extranjeros as $prod): ?>
        <div class="card card-netflix">
            <img src="/MVC<?= $prod['imagen'] ?>" alt="<?= $prod['nombre'] ?>">
            <div class="card-overlay">
                <div class="card-title"><?= htmlspecialchars($prod['nombre']) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-btn right" data-target="tray-extranjeros">▶</button>
</div>
<?php endif; ?>

</div>

<?php include 'view/parcials/footer.php'; ?>
