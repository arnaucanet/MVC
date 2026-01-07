<?php include 'view/parcials/header.php'; ?>
<div class="container" style="padding-top:100px; padding-bottom: 50px; color: #fff;">
    <h1 class="mb-4">Centro de Ayuda</h1>
    <p class="lead text-white-50 mb-5">¿En qué podemos ayudarte hoy?</p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="p-4 border border-secondary rounded bg-dark h-100">
                <h3>Problemas con un pedido</h3>
                <p class="text-white-50">Reporta artículos faltantes, comida fría o retrasos en la entrega.</p>
                <a class="p-2 text-white border border-secondary rounded bg-dark h-100">netflixeats.help@gmail.com</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border border-secondary rounded bg-dark h-100">
                <h3>Cuenta y Pagos</h3>
                <p class="text-white-50">Gestiona tus métodos de pago, cambia tu contraseña o actualiza tu dirección.</p>
                <a href="index.php?controller=Usuario&action=login" class="btn btn-outline-light btn-sm">Ir a mi cuenta</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border border-secondary rounded bg-dark h-100">
                <h3>Guía de NetflixEats</h3>
                <p class="text-white-50">Aprende a usar nuestra plataforma, cómo funcionan las recompensas y más.</p>
                <a href="index.php?controller=Info&action=faq" class="btn btn-outline-light btn-sm">Ver tutoriales</a>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 text-white rounded text-center"  style="background-color: #e50914">
        <h3>¿Necesitas ayuda urgente?</h3>
        <p>Llámanos al 900 123 456.</p>
    </div>
</div>
<?php include 'view/parcials/footer.php'; ?>
