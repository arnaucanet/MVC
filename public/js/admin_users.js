const API_USER_URL = 'index.php?controller=api/APIUsuario';
let currentUsers = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();

    document.getElementById('user-form').addEventListener('submit', handleFormSubmit);
});

function fetchUsers() {
    fetch(API_USER_URL)
        .then(response => response.json())
        .then(users => {currentUsers = users; 
            renderTable(users);})
        .catch(error => {
            console.error('Error fetching users:', error);
            alert('Error al cargar usuarios');
        });
}

function renderTable(users) {
    const tbody = document.querySelector('#users-table tbody');
    tbody.innerHTML = '';
    
    if(users.length === 0){
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No hay usuarios</td></tr>';
        return;
    }

    users.forEach(user => {
        const tr = document.createElement('tr');
        const roleClass = user.rol === 'administrador' ? 'badge-admin' : 'badge-client';
        const roleLabel = user.rol.charAt(0).toUpperCase() + user.rol.slice(1);
        
        tr.innerHTML = `
            <td>#${user.id_usuario}</td>
            <td>
                <div style="font-weight: 500; color: #111827;">${escapeHtml(user.nombre)}</div>
            </td>
            <td>${escapeHtml(user.email)}</td>
            <td><span class="badge ${roleClass}">${roleLabel}</span></td>
            <td>
                <button class="btn btn-edit" onclick="editUser(${user.id_usuario})">Editar</button>
                <button class="btn btn-delete" onclick="deleteUser(${user.id_usuario})">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function editUser(id) {
    const user = currentUsers.find(u => u.id_usuario == id);
    if(user) openUserModal(user);
}

function openUserModal(user = null) {
    const modal = document.getElementById('user-modal');
    const title = document.getElementById('modal-title');
    const form = document.getElementById('user-form');

    modal.classList.add('open');
    
    if (user) {
        title.textContent = 'Editar Usuario';
        document.getElementById('user-id').value = user.id_usuario;
        document.getElementById('user-nombre').value = user.nombre;
        document.getElementById('user-email').value = user.email;
        document.getElementById('user-password').value = ''; // Don't show password
        document.getElementById('user-rol').value = user.rol;
    } else {
        title.textContent = 'Nuevo Usuario';
        form.reset();
        document.getElementById('user-id').value = '';
        document.getElementById('user-rol').value = 'cliente';
    }
}

function closeUserModal() {
    document.getElementById('user-modal').classList.remove('open');
}

async function handleFormSubmit(e) {
    e.preventDefault();
    
    const id = document.getElementById('user-id').value;
    const nombre = document.getElementById('user-nombre').value;
    const email = document.getElementById('user-email').value;
    const password = document.getElementById('user-password').value;
    const rol = document.getElementById('user-rol').value;

    const data = { nombre, email, rol };
    if (password) data.password = password;
    
    let method = 'POST';
    
    if (id) {
        method = 'PUT';
        data.id_usuario = id;
    } else {
        if(!password) {
            alert('La contraseña es obligatoria para nuevos usuarios');
            return;
        }
        data.password = password;
    }

    try {
        const response = await fetch(API_USER_URL, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            closeUserModal();
            fetchUsers();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error saving user:', error);
        alert('Error de conexión');
    }
}

async function deleteUser(id) {
    if (!confirm('¿Estás seguro de eliminar este usuario?')) return;

    try {
        const response = await fetch(`${API_USER_URL}&id=${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            fetchUsers();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'No se pudo eliminar'));
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        alert('Error de conexión');
    }
}
