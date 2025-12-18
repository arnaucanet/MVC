<?php 
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
include 'view/parcials/header.php'; 
?>
<div class="container" style="padding-top:90px;">

<?php if(!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-grid">
            <div class="auth-visual">
                <div style="text-align:center">
                    <p class="auth-small">Bienvenido a <strong>NetflixEats</strong></p>
                </div>
            </div>
            <div class="auth-body">
                <h3 class="auth-title">Iniciar sesión</h3>
                <p class="auth-sub">Introduce tu cuenta para continuar</p>
                <form action="index.php?controller=Usuario&action=loginPost" method="post">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-red" type="submit">Entrar</button>
                        <a href="index.php?controller=Usuario&action=register" class="btn btn-outline-light">Registro</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="auth-footer">¿Aún no tienes cuenta? <a href="index.php?controller=Usuario&action=register" class="text-red">Regístrate</a></div>
    </div>
</div>

<link rel="stylesheet" href="public/css/login.css">

<?php include 'view/parcials/footer.php'; ?>
