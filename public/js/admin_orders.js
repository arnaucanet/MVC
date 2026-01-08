const API_ORDER_URL = 'index.php?controller=api/APIPedido';
let currentOrders = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();

    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', handleOrderFormSubmit);
    }
});

async function fetchOrders() {
    try {
        const response = await fetch(API_ORDER_URL);
        const orders = await response.json();
        currentOrders = orders;
        renderOrdersTable(orders);
    } catch (error) {
        console.error('Error fetching orders:', error);
        alert('Error al cargar pedidos');
    }
}

function renderOrdersTable(orders) {
    const tbody = document.querySelector('#orders-table tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(orders) || orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No hay pedidos</td></tr>';
        return;
    }

    orders.forEach(order => {
        const tr = document.createElement('tr');
        const clase = getStatusClase(order.estado);

        tr.innerHTML = `
            <td>#${order.id_pedido}</td>
            <td>${order.id_usuario}</td>
            <td>${order.fecha_pedido}</td>
            <td>${order.nombre_destinatario}</td>
            <td>${order.total} ${order.moneda}</td>
            <td><span class="badge ${clase}">${order.estado}</span></td>
            <td>
                <button class="btn btn-edit" onclick="editOrder(${order.id_pedido})">Editar Estado</button>
                <button class="btn btn-delete" onclick="deleteOrder(${order.id_pedido})">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function getStatusClase(status) {
    const st = status.toLowerCase();
    if (st === 'entregado') return 'badge-success';
    if (st === 'en preparación') return 'badge-primary';
    if (st === 'enviado') return 'badge-primary';
    if (st === 'pendiente') return 'badge-warning';
    if (st === 'cancelado') return 'badge-danger';
    return 'badge-secondary';
}

function editOrder(id) {
    const order = currentOrders.find(o => o.id_pedido == id);
    if (order) openOrderModal(order);
}

function openOrderModal(order) {
    const modal = document.getElementById('order-modal');
    const title = document.getElementById('modal-title-order');

    if (title) title.textContent = 'Editar Estado del Pedido #' + order.id_pedido;

    document.getElementById('order-id').value = order.id_pedido;

    // asignar estado
    const select = document.getElementById('order-estado');
    select.value = order.estado;

    modal.classList.add('open');
}

function closeOrderModal() {
    document.getElementById('order-modal').classList.remove('open');
}

async function handleOrderFormSubmit(e) {
    e.preventDefault();

    const id = document.getElementById('order-id').value;
    const estado = document.getElementById('order-estado').value;

    const data = { id_pedido: id, estado: estado };

    try {
        const response = await fetch(API_ORDER_URL + '&id=' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            closeOrderModal();
            fetchOrders();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error saving product:', error);
        alert('Error de conexión');
    }
}

async function deleteOrder(id) {
    if (!confirm('¿Estás seguro de eliminar este pedido?')) return;

    try {
        const response = await fetch(`${API_ORDER_URL}&id=${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            fetchOrders();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'No se pudo eliminar'));
        }
    } catch (error) {
        console.error('Error deleting order:', error);
        alert('Error de conexión');
    }
}
