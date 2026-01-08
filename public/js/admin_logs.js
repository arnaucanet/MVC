var API_LOGS = 'index.php?controller=api/APILog';

// cargar la pagina
document.addEventListener('DOMContentLoaded', function() {
    cargarLogs();
});

// descargar los logs
async function cargarLogs() {
    try {
        var respuesta = await fetch(API_LOGS);
        
        // comprobamos si la respuesta es correcta
        if (respuesta.ok) {
            var logs = await respuesta.json();
            pintarLogsEnTabla(logs);
        } else {
            console.log('Error al cargar logs');
        }
    } catch (error) {
        console.log('Fallo de red: ' + error);
        
        // poner mensaje de error en la tabla
        var tbody = document.querySelector('#logs-table tbody');
        if(tbody) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Error al cargar logs</td></tr>';
        }
    }
}

function pintarLogsEnTabla(listaLogs) {
    var tbody = document.querySelector('#logs-table tbody');
    // si no existe la tabla en esta pagina, no hacemos nada
    if (!tbody) return;
    
    // limpiamos lo que haya
    tbody.innerHTML = '';

    // si no hay logs
    if (listaLogs.length == 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No hay logs registrados</td></tr>';
        return;
    }

    // ordenarlogs: los mas nuevos primero
    // sort modifica el array original
    listaLogs.sort(function(a, b) {
        var fechaA = new Date(a.fecha);
        var fechaB = new Date(b.fecha);
        // restar fechas para ordenar descendente
        return fechaB - fechaA;
    });

    // recorrer los logs
    listaLogs.forEach(function(log) {
        var tr = document.createElement('tr');

        tr.innerHTML = `
            <td>${log.id_log}</td>
            <td>${log.accion}</td>
            <td>${log.id_usuario}</td>
            <td>${log.fecha}</td>
            <td>${log.ip_usuario}</td>
        `;
        
        tbody.appendChild(tr);
    });
}
