(function(){
    function scrollTray(trayId, delta){
        var tray = document.getElementById(trayId);
        if(!tray) return;
        tray.scrollBy({left: delta, behavior: 'smooth'});
    }

    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.carousel-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                var target = btn.getAttribute('data-target');
                if(!target) return;
                var tray = document.getElementById(target);
                if(!tray) return;
                var width = tray.clientWidth;
                if(btn.classList.contains('left')) scrollTray(target, -Math.round(width * 0.7));
                else scrollTray(target, Math.round(width * 0.7));
            });
        });

        document.querySelectorAll('.row-carousel .tray').forEach(function(tray){
            tray.addEventListener('wheel', function(e){
                if(Math.abs(e.deltaY) > Math.abs(e.deltaX)){
                    e.preventDefault();
                    tray.scrollLeft += e.deltaY;
                }
            }, {passive:false});

            var isDown = false; var startX; var scrollLeft;
            tray.addEventListener('mousedown', function(e){ isDown=true; tray.classList.add('active'); startX = e.pageX - tray.offsetLeft; scrollLeft = tray.scrollLeft; });
            tray.addEventListener('mouseleave', function(){ isDown=false; tray.classList.remove('active'); });
            tray.addEventListener('mouseup', function(){ isDown=false; tray.classList.remove('active'); });
            tray.addEventListener('mousemove', function(e){ if(!isDown) return; e.preventDefault(); var x = e.pageX - tray.offsetLeft; var walk = (x - startX) * 1.2; tray.scrollLeft = scrollLeft - walk; });
        });
    });
})();
