<?php
session_start();

/*
  Front controller / safe product loader:
  - Primero intenta despachar si se pide un controlador vía ?controller=&action=
  - Si no, carga productos desde la BBDD (usa database/database.php) de forma segura
*/

if (isset($_GET['controller'])) {
    $rawController = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['controller']);
    $nombre_controller = ucfirst($rawController) . 'Controller';
    $controller_file = __DIR__ . '/controller/' . $nombre_controller . '.php';

    if (file_exists($controller_file)) {
        require_once $controller_file;
    }

    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();
        $action = $_GET['action'] ?? 'index';
        if (method_exists($controller, $action)) {
            // Ejecuta la acción y corta la ejecución para evitar render duplicado
            $controller->$action();
            exit;
        } else {
            header("Location: 404.php");
            exit;
        }
    } else {
        // Controlador no encontrado: mostrar mensaje simple o redirigir
        header("HTTP/1.1 404 Not Found");
        echo "Controlador no encontrado.";
        exit;
    }
}

// Si no se ha pedido ningún controlador, cargamos productos desde la BBDD
$productos = null;
try {
    require_once __DIR__ . '/database/database.php';
    $db = DataBase::connect();
    $sql = "SELECT id_producto, nombre, descripcion, precio, imagen FROM producto WHERE activo = 1 ORDER BY nombre ASC";
    $productos = $db->query($sql);
    if ($productos === false) {
        throw new Exception("Error al obtener productos: " . $db->error);
    }
} catch (Throwable $e) {
    // Si hay error, lo guardamos en una variable para mostrar un mensaje en la vista
    $productos_error = $e->getMessage();
}

/* ---------- Render de la vista ---------- */
require_once __DIR__ . '/header.php';
?>

<div class="container py-4">
    <h1 class="mb-4">Nuestros productos</h1>

    <?php if (!empty($productos_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($productos_error) ?>
        </div>
    <?php endif; ?>

    <?php if ($productos && $productos->num_rows > 0): ?>
        <div class="row">
            <?php while ($prod = $productos->fetch_assoc()): ?>
                <?php
                    $nombre = htmlspecialchars($prod['nombre']);
                    $descripcion = htmlspecialchars($prod['descripcion']);
                    $precio = number_format((float)$prod['precio'], 2, ',', '.');
                    $img = !empty($prod['imagen']) ? htmlspecialchars($prod['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+imagen';
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= $img ?>" class="card-img-top" alt="<?= $nombre ?>" style="object-fit:cover; height:160px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $nombre ?></h5>
                            <p class="card-text small text-muted mb-2"><?= $descripcion ?></p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <strong class="text-primary"><?= $precio ?> €</strong>
                                <a href="carrito.php?add=<?= urlencode($prod['id']) ?>" class="btn btn-sm btn-outline-primary">Añadir</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay productos disponibles en este momento.</div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<?php
include_once 'controller/EquipoController.php';

if(isset($_GET['controller'])){
    $nombre_controller = $_GET['controller'].'Controller';
    if(class_exists($nombre_controller)){
        $controller = new $nombre_controller();
        $action = $_GET['action'];
        if(isset($action) && method_exists($controller, $action)){
            $controller->$action();
        }else{
            header("Location:404.php");
        }
    }else{
        echo'No existe el controlador';
    }
}else{
    
}

?>