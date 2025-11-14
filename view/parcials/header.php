<?php
// Detectar controlador actual (para resaltar el menú activo)
$currentController = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NetflixEats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #141414; color: #fff; font-family: Arial, sans-serif; }
        .navbar { background-color: #e50914; }
        .nav-link.active { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">🍔 NetflixEats</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= ($currentController == 'home') ? 'active' : '' ?>" 
             href="index.php?controller=Home&action=index">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($currentController == 'producto') ? 'active' : '' ?>" 
             href="index.php?controller=Producto&action=index">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($currentController == 'micomida') ? 'active' : '' ?>" 
             href="index.php?controller=MiComida&action=index">Mi Comida</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">