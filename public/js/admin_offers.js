const API_OFFER_URL = 'index.php?controller=api/APIOferta';
let currentOffers = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchOffers();

    const form = document.getElementById('offer-form');
    if (form) {
        form.addEventListener('submit', handleOfferFormSubmit);
    }
});

async function fetchOffers() {
    try {
        const response = await fetch(API_OFFER_URL);
        if (!response.ok) throw new Error('Network response was not ok');
        const offers = await response.json();
        currentOffers = offers;
        renderOffersTable(offers);
    } catch (error) {
        console.error('Error loading offers:', error);
    }
}

function renderOffersTable(offers) {
    const tbody = document.querySelector('#offers-table tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!Array.isArray(offers) || offers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;">No hay ofertas registradas</td></tr>';
        return;
    }

    offers.forEach(offer => {
        const tr = document.createElement('tr');
        const activeClass = offer.activa == 1 ? 'badge-success' : 'badge-secondary';
        const activeText = offer.activa == 1 ? 'Activa' : 'Inactiva';

        tr.innerHTML = `
            <td>#${offer.id_oferta}</td>
            <td><strong>${offer.codigo}</strong></td>
            <td>${offer.descripcion || '-'}</td>
            <td>${offer.descuento_porcentaje}%</td>
            <td>${offer.fecha_inicio}</td>
            <td>${offer.fecha_fin}</td>
            <td><span class="badge ${activeClass}">${activeText}</span></td>
            <td>
                <button class="btn btn-edit" onclick="editOffer(${offer.id_oferta})">Editar</button>
                <button class="btn btn-delete" onclick="deleteOffer(${offer.id_oferta})">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function openOfferModal(offer = null) {
    const modal = document.getElementById('offer-modal');
    const title = document.getElementById('modal-title-offer');
    
    // reset form
    document.getElementById('offer-form').reset();
    document.getElementById('offer-id').value = '';

    if (offer) {
        title.textContent = 'Editar Oferta';
        document.getElementById('offer-id').value = offer.id_oferta;
        document.getElementById('offer-codigo').value = offer.codigo;
        document.getElementById('offer-descripcion').value = offer.descripcion;
        document.getElementById('offer-descuento').value = offer.descuento_porcentaje;
        document.getElementById('offer-inicio').value = offer.fecha_inicio;
        document.getElementById('offer-fin').value = offer.fecha_fin;
        document.getElementById('offer-activa').value = offer.activa;
    } else {
        title.textContent = 'Nueva Oferta';
        document.getElementById('offer-activa').value = 1;
        // set default dates today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('offer-inicio').value = today;
        document.getElementById('offer-fin').value = today;
    }

    modal.classList.add('open');
}

function closeOfferModal() {
    document.getElementById('offer-modal').classList.remove('open');
}

function editOffer(id) {
    const offer = currentOffers.find(o => o.id_oferta == id);
    if (offer) openOfferModal(offer);
}

async function deleteOffer(id) {
    if (!confirm('¿Estás seguro de eliminar esta oferta?')) return;

    try {
        const response = await fetch(`${API_OFFER_URL}&id=${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            fetchOffers();
        } else {
            alert('Error al eliminar oferta');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function handleOfferFormSubmit(e) {
    e.preventDefault();

    const id = document.getElementById('offer-id').value;
    const codigo = document.getElementById('offer-codigo').value;
    const desc = document.getElementById('offer-descripcion').value;
    const descuento = document.getElementById('offer-descuento').value;
    const inicio = document.getElementById('offer-inicio').value;
    const fin = document.getElementById('offer-fin').value;
    const activa = document.getElementById('offer-activa').value;

    const data = {
        id_oferta: id,
        codigo: codigo,
        descripcion: desc,
        descuento_porcentaje: descuento,
        fecha_inicio: inicio,
        fecha_fin: fin,
        activa: activa
    };

    const method = id ? 'PUT' : 'POST';

    try {
        const response = await fetch(API_OFFER_URL, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            closeOfferModal();
            fetchOffers();
        } else {
            const res = await response.json();
            alert('Error: ' + (res.error || 'Algo salió mal'));
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
