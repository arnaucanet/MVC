
(function () {
    function updateButtons(tray) {
        var wrapper = tray.closest('.row-carousel, .carousel-container');
        if (!wrapper) return;
        var btnLeft = wrapper.querySelector('.carousel-btn.left');
        var btnRight = wrapper.querySelector('.carousel-btn.right');

        // Margen de error pequeño para comparaciones de float/scroll
        var tolerance = 2;

        if (btnLeft) {
            if (tray.scrollLeft <= tolerance) {
                btnLeft.classList.add('hidden');
            } else {
                btnLeft.classList.remove('hidden');
            }
        }

        if (btnRight) {
            // Si el scroll + ancho visible >= ancho total, estamos al final
            if (tray.scrollLeft + tray.clientWidth >= tray.scrollWidth - tolerance) {
                btnRight.classList.add('hidden');
            } else {
                btnRight.classList.remove('hidden');
            }
        }
    }

    function scrollTray(trayId, direction) {
        var tray = document.getElementById(trayId);
        if (!tray) return;

        var width = tray.clientWidth;
        // Scroll casi una página entera (92%) para dejar ver un poco del siguiente
        var scrollAmount = Math.floor(width * 0.92);

        var targetScroll = tray.scrollLeft + (direction * scrollAmount);

        tray.scrollTo({
            left: targetScroll,
            behavior: 'smooth'
        });

        // Actualizar botones después de un tiempo prudencial para la animación
        setTimeout(function () { updateButtons(tray); }, 400);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var carousels = document.querySelectorAll('.row-carousel .tray, .carousel-track');
        carousels.forEach(function (tray) {
            updateButtons(tray);

            tray.addEventListener('scroll', function () {
                updateButtons(tray);
            });
        });

        document.querySelectorAll('.carousel-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-target');
                if (!target) return;

                if (btn.classList.contains('left')) scrollTray(target, -1);
                else scrollTray(target, 1);
            });
        });

        carousels.forEach(function (tray) {
            tray.addEventListener('wheel', function (e) {
                if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                    e.preventDefault();
                    tray.scrollLeft += e.deltaY;
                }
            }, { passive: false });

            var isDown = false; var startX; var scrollLeft;
            tray.addEventListener('mousedown', function (e) { isDown = true; tray.classList.add('active'); startX = e.pageX - tray.offsetLeft; scrollLeft = tray.scrollLeft; });
            tray.addEventListener('mouseleave', function () { isDown = false; tray.classList.remove('active'); });
            tray.addEventListener('mouseup', function () { isDown = false; tray.classList.remove('active'); });
            tray.addEventListener('mousemove', function (e) { if (!isDown) return; e.preventDefault(); var x = e.pageX - tray.offsetLeft; var walk = (x - startX) * 1.2; tray.scrollLeft = scrollLeft - walk; });
        });
    });
})();
