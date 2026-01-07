<?php include 'view/parcials/header.php'; ?>

<div class="container" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-header border-secondary">
                    <h3 class="mb-0">Mi Perfil</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error'] ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'] ?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=Usuario&action=update" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control bg-dark text-white border-secondary" id="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario->getTelefono()) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario->getDireccion()) ?>">
                            </div>
                        </div>

                        <hr class="border-secondary my-4">
                        <h5 class="mb-3">Seguridad</h5>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña (dejar en blanco para mantener la actual)</label>
                            <input type="password" class="form-control bg-dark text-white border-secondary" id="new_password" name="new_password">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="index.php" class="btn btn-outline-light ">Cancelar</a>
                            <button type="submit" class="btn btn-red">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-white small">
                 Miembro desde: <?= date('d/m/Y', strtotime($usuario->getFecha_registro())) ?>
            </div>
        </div>
    </div>
</div>

<?php include 'view/parcials/footer.php'; ?>