<?php include 'view/parcials/header.php'; ?>
<div class="container" style="padding-top:90px;">

<?php
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

function getCategoryId($p){
    if(is_object($p)){
        $methods = ['getId_categoria','getIdCategoria','getCategoriaId','getCategoria_id','getCategoryId','getId'];
        foreach($methods as $m){
            if(method_exists($p, $m)){
                $val = $p->$m();
                if(is_numeric($val)) return (int)$val;
            }
        }

        if(method_exists($p, 'getCategoria')){
            $cat = $p->getCategoria();
            if(is_numeric($cat)) return (int)$cat;
            if(is_object($cat)){
                $cmethods = ['getId','getId_categoria','getIdCategoria','getCategoriaId'];
                foreach($cmethods as $cm){
                    if(method_exists($cat, $cm)){
                        $v = $cat->$cm();
                        if(is_numeric($v)) return (int)$v;
                    }
                }
            }
        }
    }

    if(is_array($p)){
        if(isset($p['id_categoria'])) return (int)$p['id_categoria'];
        if(isset($p['categoria_id'])) return (int)$p['categoria_id'];
        if(isset($p['categoria'])) return is_numeric($p['categoria']) ? (int)$p['categoria'] : 0;
    }
    return 0;
}
function getCategoryName($p){
    if(is_object($p)){
        $methods = ['getCategoria_nombre','getCategoriaNombre','getNombre_categoria','getNombreCategoria','getCategoryName','getNombre','getName'];
        foreach($methods as $m){
            if(method_exists($p, $m)){
                $val = $p->$m();
                if(is_string($val) && $val !== '') return $val;
            }
        }

        if(method_exists($p, 'getCategoria')){
            $cat = $p->getCategoria();
            if(is_string($cat) && $cat !== '') return $cat;
            if(is_object($cat)){
                $cmethods = ['getNombre','getName','getCategoria_nombre','getCategoriaNombre','getNombre_categoria','getNombreCategoria'];
                foreach($cmethods as $cm){
                    if(method_exists($cat, $cm)){
                        $v = $cat->$cm();
                        if(is_string($v) && $v !== '') return $v;
                    }
                }
            }
        }
    }

    if(is_array($p)){
        if(isset($p['categoria_nombre'])) return $p['categoria_nombre'];
        if(isset($p['nombre_categoria'])) return $p['nombre_categoria'];
        if(isset($p['categoria']) && is_string($p['categoria'])) return $p['categoria'];
    }
    return 'Sin categoria';
}

function isActive($p){
    if(is_object($p) && method_exists($p, 'getActivo')){
        $val = $p->getActivo();
        if($val === null) return true;
        return ((int)$val) === 1 || $val === true || $val === '1' || $val === 'true';
    }

    $keys = ['activo','activo_producto','estado','status','is_active','active','enabled'];
    if(is_array($p)){
        foreach($keys as $k){
            if(array_key_exists($k, $p)){
                $v = $p[$k];
                if($v === null) return true;
                $vs = strtolower(trim((string)$v));
                if(in_array($vs, ['1','true','yes','on'], true)) return true;
                if(in_array($vs, ['0','false','no','off'], true)) return false;
                if(is_numeric($vs)) return ((int)$vs) !== 0;
            }
        }
    }

    return true;
}

$results = [];
if($q !== ''){
    foreach($productos as $prod){
        $hay = false;
        if(!empty($prod['nombre']) && stripos($prod['nombre'], $q) !== false) $hay = true;
        if(!$hay && !empty($prod['descripcion']) && stripos($prod['descripcion'], $q) !== false) $hay = true;
        if($hay) $results[] = $prod;
    }
}

include_once 'model/DAO/CategoriaDAO.php';
$categoriaDao = new CategoriaDAO();
$categoryNameCache = [];

$groups = [];
$foreignCats = [5,6,7,9,10,11,13];
foreach($productos as $prod){
    if(!isActive($prod)) continue;

    $catId = getCategoryId($prod);
    if($catId === 12) continue; 

    if(in_array($catId, $foreignCats, true)){
        $groupKey = 'extranjeras';
        $groupName = 'Comidas extranjeras';
    } else {
        $groupKey = $catId;
        if(isset($categoryNameCache[$catId])){
            $groupName = $categoryNameCache[$catId];
        } else {
            $catObj = $categoriaDao->getCategoriaById($catId);
            if($catObj && method_exists($catObj, 'getNombre_categoria')){
                $groupName = $catObj->getNombre_categoria();
            } else {
                $groupName = getCategoryName($prod);
            }
            $categoryNameCache[$catId] = $groupName;
        }
    }

    if(!isset($groups[$groupKey])) $groups[$groupKey] = ['name'=>$groupName, 'items'=>[]];
    $groups[$groupKey]['items'][] = $prod;
}

?>

<?php if($q !== ''): ?>
    <h2 class="carousel-category">Resultados para "<?= htmlspecialchars($q) ?>"</h2>
    <?php if(count($results) > 0): ?>
        <div class="row">
            <?php foreach($results as $producto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card-product-grid">
                        <img src="/MVC<?= $producto['imagen'] ?? '' ?>" alt="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
                        <div class="card-body">
                            <div class="card-title"><?= htmlspecialchars($producto['nombre'] ?? '') ?></div>
                            <div class="price"><?= isset($producto['precio']) ? '€'.htmlspecialchars($producto['precio']) : '' ?></div>
                            <p class="card-text"><?= htmlspecialchars(substr($producto['descripcion'] ?? '',0,100)) ?>...</p>
                            <div class="actions">
                                <a href="index.php?controller=Producto&action=agregarCarrito&id=<?= $producto['id'] ?? '' ?>" class="btn btn-danger btn-sm flex-grow-1">Añadir</a>
                                <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id'] ?? '' ?>" class="btn btn-outline-light btn-sm">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No se encontraron resultados para "<?= htmlspecialchars($q) ?>". Mostrando productos por categoria.</div>
        <?php ?>
    <?php endif; ?>
<?php endif; ?>

<?php  ?>
<?php foreach($groups as $catId => $group): ?>
    <?php if(empty($group['items'])) continue; ?>
    <section class="mb-5">
        <h3 class="carousel-category"><?= htmlspecialchars($group['name']) ?></h3>
        <div class="row">
            <?php foreach($group['items'] as $producto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card-product-grid">
                        <img src="/MVC<?= $producto['imagen'] ?? '' ?>" alt="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
                        <div class="card-body">
                            <div class="card-title"><?= htmlspecialchars($producto['nombre'] ?? '') ?></div>
                            <div class="price"><?= isset($producto['precio']) ? '€'.htmlspecialchars($producto['precio']) : '' ?></div>
                            <p class="card-text"><?= htmlspecialchars(substr($producto['descripcion'] ?? '',0,100)) ?>...</p>
                            <div class="actions">
                                <a href="index.php?controller=Producto&action=agregarCarrito&id=<?= $producto['id'] ?? '' ?>" class="btn btn-danger btn-sm flex-grow-1">Añadir</a>
                                <a href="index.php?controller=Producto&action=detalle&id=<?= $producto['id'] ?? '' ?>" class="btn btn-outline-light btn-sm">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endforeach; ?>

</div>
<?php include 'view/parcials/footer.php'; ?>