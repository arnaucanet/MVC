<?php
$currentController = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NetflixEats</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/MVC/public/css/netflixeats.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  <header class="site-header navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="brand navbar-brand" href="index.php">
        <img src="/MVC/public/icons/logo.svg" alt="NetflixEats" height="50">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mb-2 mb-lg-0 nav-links">
          <li class="nav-item">
            <a class="nav-link <?= ($currentController == 'home') ? 'active' : '' ?>" href="index.php?controller=Home&action=index">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($currentController == 'producto') ? 'active' : '' ?>" href="index.php?controller=Producto&action=index">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($currentController == 'micomida') ? 'active' : '' ?>" href="index.php?controller=MiComida&action=index">Mi Comida</a>
          </li>
        </ul>

        <?php include __DIR__ . '/search.php'; ?>

        <div class="d-flex align-items-center gap-3 right-panel">
          <!-- carrito -->
          <div class="cart-dropdown-wrapper position-relative">
            <button class="btn btn-link text-white position-relative p-0" id="cartToggle">
              <img src="/MVC/public/icons/shopping-cart.svg" alt="Cart" width="24" height="24" style="filter: invert(1);">
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="display: none;">
                0
              </span>
            </button>
            <div class="cart-dropdown" id="cartDropdown">
              <div class="cart-header d-flex justify-content-between align-items-center p-3 border-bottom border-secondary">
                <h5 class="m-0 text-white">Mi Carrito</h5>
                <button type="button" class="btn-close btn-close-white" id="closeCart"></button>
              </div>
              <div class="cart-items p-3" id="cartItems" style="max-height: 300px; overflow-y: auto;">
                <div class="text-center text-white">Tu carrito está vacío</div>
              </div>
              <div class="cart-footer p-3 border-top border-secondary">
                <div class="d-flex justify-content-between mb-3 text-white">
                  <span>Total:</span>
                  <span class="fw-bold" id="cartTotal">0.00 €</span>
                </div>
                <button id="checkoutBtn" class="btn btn-red w-100">Tramitar Pedido</button>
              </div>
            </div>
          </div>

          <div class="profile-menu">
            <?php
            $usuarioLogueado = null;
            $nombreUsuario = 'Invitado';

            // incluir modelo
            include_once 'model/DAO/UsuarioDAO.php';
            $usuarioDAO = new UsuarioDAO();

            // iniciar sesion
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            if (isset($_SESSION['user_id'])) {
              // buscar user
              $usuarioLogueado = $usuarioDAO->getById($_SESSION['user_id']);
            }
            // si no hay sesion mirar por cookies
            elseif (isset($_COOKIE['id_usuario_guardado'])) {
              // guardar id
              $idGuardado = $_COOKIE['id_usuario_guardado'];

              // buscar user
              $usuarioEncontrado = $usuarioDAO->getById($idGuardado);

              if ($usuarioEncontrado) {
                // iniciar sesion
                $_SESSION['user_id'] = $usuarioEncontrado->getId_usuario();
                $usuarioLogueado = $usuarioEncontrado;
              }
            }

            // guardar nombre
            if ($usuarioLogueado) {
              $nombreUsuario = $usuarioLogueado->getNombre();
            }
            ?>

            <?php if ($usuarioLogueado): ?>
              <div class="dropdown flex">
                <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= htmlspecialchars($nombreUsuario) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="profileMenu">
                  <li><span class="dropdown-item-text text-white" style="font-size:0.8rem">Hola, <?= htmlspecialchars($nombreUsuario) ?></span></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="index.php?controller=Usuario&action=perfil">Cuenta</a></li>
                  <li><a class="dropdown-item" href="index.php?controller=Pedido&action=mis_pedidos">Mis Pedidos</a></li>
                  <li><a class="dropdown-item" href="index.php?controller=Info&action=help">Centro de ayuda</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="index.php?controller=Usuario&action=logout">Cerrar sesión en NetflixEats</a></li>
                </ul>
              </div>
            <?php else: ?>
              <a class="btn btn-red btn-sm" href="index.php?controller=Usuario&action=login">Iniciar sesión</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </header>
  <main class="flex-grow-1">