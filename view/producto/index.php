<?php include 'view/parcials/header.php'; ?>
<div class="container" style="padding-top:90px;">

    <!-- Filter Bar -->
    <div class="filter-bar mb-4 p-3 rounded" style="background-color: #181818;">
        <form action="index.php" method="GET" class="row g-3 align-items-center">
            <input type="hidden" name="controller" value="Producto">
            <input type="hidden" name="action" value="index">
            
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-white">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="q" class="form-control bg-dark border-secondary text-white" 
                           placeholder="Buscar productos..." value="<?= htmlspecialchars($query ?? '') ?>">
                </div>
            </div>
            
            <div class="col-md-4">
                <select name="categoria" class="form-select bg-dark border-secondary text-white">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>" <?= (isset($categoriaId) && $categoriaId == $cat['id_categoria']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nombre_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-danger w-100">Filtrar</button>
            </div>
            
            <?php if (!empty($query) || !empty($categoriaId)): ?>
            <div class="col-md-2">
                <a href="index.php?controller=Producto&action=index" class="btn btn-outline-secondary w-100">Limpiar</a>
            </div>
            <?php endif; ?>
        </form>
    </div>

<?php
// Helper functions for category grouping (kept for compatibility if needed, though we are now filtering in DB)
function getCategoryId($p){
    if(is_array($p) && isset($p['id_categoria'])) return (int)$p['id_categoria'];
    return 0;
}

// Group products by category for display
$groups = [];
$foreignCats = [5,6,7,9,10,11,13];

// If we are filtering, we might just want to show a flat list or still grouped. 
// Let's stick to the grouped view unless it's a specific search which usually implies a flat list result.
// But the user asked for filters.

// If there is a search query or category filter, we display results directly.
// If not, we display the categorized view as before.

$isFiltered = !empty($query) || !empty($categoriaId);

if ($isFiltered) {
    // Flat list for search results
    $groups['Resultados'] = ['name' => 'Resultados de búsqueda', 'items' => $productos];
} else {
    // Group by category logic
    include_once 'model/DAO/CategoriaDAO.php';
    $categoriaDao = new CategoriaDAO();
    $categoryNameCache = [];

    foreach($productos as $prod){
        // Assuming $prod is array from DAO
        $catId = $prod['id_categoria'];
        
        // Skip specific categories if needed or handle foreign food logic
        if($catId === 12) continue; 

        if(in_array($catId, $foreignCats, true)){
            $groupKey = 'extranjeras';
            $groupName = 'Comidas extranjeras';
        } else {
            $groupKey = $catId;
            if(isset($categoryNameCache[$catId])){
                $groupName = $categoryNameCache[$catId];
            } else {
                // We can optimize this by fetching all categories once, but for now:
                $catObj = $categoriaDao->getCategoriaById($catId);
                $groupName = $catObj ? $catObj->getNombre_categoria() : 'Otras';
                $categoryNameCache[$catId] = $groupName;
            }
        }

        if(!isset($groups[$groupKey])) $groups[$groupKey] = ['name'=>$groupName, 'items'=>[]];
        $groups[$groupKey]['items'][] = $prod;
    }
}
?>

<?php if(empty($productos)): ?>
    <div class="alert alert-dark text-center mt-5" role="alert">
        <h3>No se encontraron productos</h3>
        <p>Intenta con otros términos de búsqueda o filtros.</p>
        <a href="index.php?controller=Producto&action=index" class="btn btn-outline-light mt-3">Ver todos los productos</a>
    </div>
<?php else: ?>

    <?php foreach($groups as $key => $group): ?>
        <?php if(empty($group['items'])) continue; ?>
        <section class="mb-5">
            <h3 class="carousel-category"><?= htmlspecialchars($group['name']) ?></h3>
            <div class="row">
                <?php foreach($group['items'] as $producto): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card-product-grid">
                            <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id_producto'] ?? '' ?>">
                                <img src="<?= $producto['imagen'] ?? '' ?>" alt="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
                            </a>
                            <div class="card-body">
                                <div class="card-title"><?= htmlspecialchars($producto['nombre'] ?? '') ?></div>
                                <div class="price"><?= isset($producto['precio']) ? '€'.htmlspecialchars($producto['precio']) : '' ?></div>
                                <p class="card-text"><?= htmlspecialchars(substr($producto['descripcion'] ?? '',0,100)) ?>...</p>
                                <div class="actions">
                                    <a href="index.php?controller=Pedido&action=add&id=<?= $producto['id_producto'] ?? '' ?>" class="btn btn-danger btn-sm flex-grow-1">Añadir</a>
                                    <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id_producto'] ?? '' ?>" class="btn btn-outline-light btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

<?php endif; ?>

</div>
<?php include 'view/parcials/footer.php'; ?>