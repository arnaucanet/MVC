const API_ORDER_URL = 'index.php?controller=api/APIPedido';
let currentOrders = [];
let exchangeRates = { EUR: 1, USD: 1.05, GBP: 0.85, JPY: 157 }; 
// backup de datos
let baseCurrency = 'EUR';
let selectedCurrency = 'EUR';

document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();
    fetchRates();

    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', handleOrderFormSubmit);
    }

    // listeners para filtros
    const applyBtn = document.getElementById('apply-filters');
    if(applyBtn) applyBtn.addEventListener('click', applyFilters);
    
    const clearBtn = document.getElementById('clear-filters');
    if(clearBtn) clearBtn.addEventListener('click', clearFilters);
    
    const currSelect = document.getElementById('currency-select');
    if(currSelect) currSelect.addEventListener('change', updateCurrency);
});

async function fetchRates() {
    const API_KEY = 'fca_live_AdNbkObiCoIcGden3ywZJVBGhvHGEDdpjhhqKLzk';
    const url = `https://api.freecurrencyapi.com/v1/latest?apikey=${API_KEY}&base_currency=EUR`;

    try {
        const response = await fetch(url);
        if (response.ok) {
            const data = await response.json();
            if(data.data) {
                exchangeRates = { ...exchangeRates, ...data.data };
                exchangeRates['EUR'] = 1;
            }
        } else {
            console.log('Using default exchange rates (API key required).');
        }
    } catch (e) {
        console.log('Could not fetch rates, using defaults.');
    }
}

async function fetchOrders() {
    try {
        const response = await fetch(API_ORDER_URL);
        const orders = await response.json();
        currentOrders = orders;
        // renderizado inicial
        applyFilters();
    } catch (error) {
        console.error('Error fetching orders:', error);
        alert('Error al cargar pedidos');
    }
}

function clearFilters() {
    if(document.getElementById('filter-user-id')) document.getElementById('filter-user-id').value = '';
    if(document.getElementById('filter-date-start')) document.getElementById('filter-date-start').value = '';
    if(document.getElementById('filter-date-end')) document.getElementById('filter-date-end').value = '';
    if(document.getElementById('filter-price-min')) document.getElementById('filter-price-min').value = '';
    if(document.getElementById('filter-price-max')) document.getElementById('filter-price-max').value = '';
    if(document.getElementById('sort-by')) document.getElementById('sort-by').value = 'fecha_pedido';
    if(document.getElementById('sort-order')) document.getElementById('sort-order').value = 'desc';
    applyFilters();
}

function updateCurrency() {
    const el = document.getElementById('currency-select');
    if(el) selectedCurrency = el.value;
    renderOrdersTable(getLastFilteredOrders());
}

let lastFiltered = [];
function getLastFilteredOrders() { return lastFiltered.length ? lastFiltered : currentOrders; }

function applyFilters() {
    if(!document.getElementById('filter-user-id')) {
        renderOrdersTable(currentOrders);
        return;
    }

    const userId = document.getElementById('filter-user-id').value;
    const dateStart = document.getElementById('filter-date-start').value;
    const dateEnd = document.getElementById('filter-date-end').value;
    const priceMin = parseFloat(document.getElementById('filter-price-min').value);
    const priceMax = parseFloat(document.getElementById('filter-price-max').value);
    
    const sortBy = document.getElementById('sort-by').value;
    const sortOrder = document.getElementById('sort-order').value;

    // usamos funcion filter
    let result = currentOrders.filter(order => {
        let pass = true;
        if (userId && order.id_usuario != userId) pass = false;
        if (dateStart && new Date(order.fecha_pedido) < new Date(dateStart)) pass = false;
        if (dateEnd && new Date(order.fecha_pedido) > new Date(dateEnd + 'T23:59:59')) pass = false;
        
        // comparar precios en la moneda base eur
        let price = parseFloat(order.total);
        if (!isNaN(priceMin) && price < priceMin) pass = false;
        if (!isNaN(priceMax) && price > priceMax) pass = false;

        return pass;
    });

    // usamos funcion sort
    result.sort((a, b) => {
        let valA = a[sortBy];
        let valB = b[sortBy];

        if (sortBy === 'total') {
            valA = parseFloat(valA);
            valB = parseFloat(valB);
        } else if (sortBy === 'fecha_pedido') {
            valA = new Date(valA);
            valB = new Date(valB);
        }

        if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
        if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
        return 0;
    });

    lastFiltered = result;
    renderOrdersTable(result);
}

function renderOrdersTable(orders) {
    const tbody = document.querySelector('#orders-table tbody');
    if(!tbody) return;
    tbody.innerHTML = '';

    if (!Array.isArray(orders) || orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No hay pedidos</td></tr>';
        return;
    }

    // usamos funcion forEach
    orders.forEach(order => {
        const tr = document.createElement('tr');
        const clase = getStatusClase(order.estado);
        
        // conversion de moneda
        let originalPrice = parseFloat(order.total);
        let rate = exchangeRates[selectedCurrency] || 1;
        let convertedPrice = (originalPrice * rate).toFixed(2);
        let symbol = getCurrencySymbol(selectedCurrency);

        tr.innerHTML = `
            <td>#${order.id_pedido}</td>
            <td>${order.id_usuario}</td>
            <td>${order.fecha_pedido}</td>
            <td>${order.nombre_destinatario}</td>
            <td>${convertedPrice} ${symbol}</td>
            <td><span class="badge ${clase}">${order.estado}</span></td>
            <td>
                <button class="btn btn-edit" onclick="editOrder(${order.id_pedido})">Editar Estado</button>
                <button class="btn btn-delete" onclick="deleteOrder(${order.id_pedido})">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function getCurrencySymbol(curr) {
    switch(curr) {
        case 'EUR': return '€';
        case 'USD': return '$';
        case 'GBP': return '£';
        case 'JPY': return '¥';
        default: return curr;
    }
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
        const response = await fetch(API_ORDER_URL, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            closeOrderModal();
            fetchOrders(); // recargar pedidos
        } else {
            alert('Error al actualizar');
        }
    } catch (error) {
        console.error('Error:', error);
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
