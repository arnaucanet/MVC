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
        <a class="brand navbar-brand" href="index.php">NETFLIXEATS</a>

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
            <div class="profile-menu">
              <?php
              $profileLabel = 'ME';
              $profileMenu = '';
              if (!empty($_COOKIE['mvc_user'])) {
                $raw = base64_decode($_COOKIE['mvc_user']);
                $data = json_decode($raw, true);
                if (!empty($data['id']) && !empty($data['sig'])) {
                  include_once 'model/DAO/UsuarioDAO.php';
                  $udao = new UsuarioDAO();
                  $u = $udao->getById((int)$data['id']);
                  if ($u) {
                    $expected = sha1($u->getPassword() . ($_SERVER['HTTP_USER_AGENT'] ?? ''));
                    if (hash_equals($expected, $data['sig'])) {
                      $profileLabel = htmlspecialchars($u->getNombre() ?: ($u->getEmail() ?? 'ME'));
                      $profileMenu = $u;
                    }
                  }
                }
              }
              ?>

              <?php if ($profileMenu): ?>
                <div class="dropdown flex">
                  <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $profileLabel ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="profileMenu">
                    <li><span class="dropdown-item-text text-white" style="font-size:0.8rem">Hola, <?= $profileLabel ?></span></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="index.php?controller=Usuario&action=perfil">Cuenta</a></li>
                    <li><a class="dropdown-item" href="index.php?controller=Info&action=help">Centro de ayuda</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="index.php?controller=Usuario&action=logout">Cerrar sesión en NetflixEats</a></li>
                  </ul>
                </div>
                <div class="flex">Carrito</div>
              <?php else: ?>
                <a class="btn btn-danger btn-sm" href="index.php?controller=Usuario&action=login">Iniciar sesión</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main class="flex-grow-1">
