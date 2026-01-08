<?php include 'view/parcials/header.php'; ?>
<div class="container" style="padding-top:100px; padding-bottom: 50px; color: #fff;">
    <h1 class="mb-5">Preguntas Frecuentes</h1>

    <div class="accordion accordion-flush" id="faqAccordion">
        <div class="accordion-item bg-dark text-white border-secondary">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                    ¿Cómo funciona NetflixEats?
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white-50">
                    NetflixEats es un servicio de entrega de comida a domicilio inspirado en tus series y películas favoritas. Simplemente regístrate, elige tus platos y recíbelos en la comodidad de tu hogar.
                </div>
            </div>
        </div>
        <div class="accordion-item bg-dark text-white border-secondary">
            <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                    ¿Cuáles son los métodos de pago?
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white-50">
                    Aceptamos tarjetas de crédito y débito (Visa, Mastercard, American Express) y PayPal.
                </div>
            </div>
        </div>
        <div class="accordion-item bg-dark text-white border-secondary">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed bg-dark text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree">
                    ¿Puedo cancelar mi pedido?
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white-50">
                    Puedes cancelar tu pedido dentro de los primeros 5 minutos de haberlo realizado desde la sección "Mis Pedidos". Pasado ese tiempo, el restaurante ya habrá comenzado a prepararlo.
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br>
</div>
<?php include 'view/parcials/footer.php'; ?>