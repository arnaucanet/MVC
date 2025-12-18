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
                    <p class="auth-small">Únete a la mejor experiencia gastronómica</p>
                </div>
            </div>
            <div class="auth-body">
                <h3 class="auth-title">Crear cuenta</h3>
                <p class="auth-sub">Regístrate para pedir y guardar tus platos favoritos</p>
                <form action="index.php?controller=Usuario&action=registerPost" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" />
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-red" type="submit">Crear cuenta</button>
                        <a href="index.php?controller=Usuario&action=login" class="btn btn-outline-light">Volver a login</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="auth-footer">Al registrarte aceptas nuestras condiciones.</div>
    </div>
</div>

</div>

<?php include 'view/parcials/footer.php'; ?>
