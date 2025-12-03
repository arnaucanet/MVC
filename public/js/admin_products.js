const API_PRODUCT_URL = 'index.php?controller=api/APIProducto';
const API_CATEGORIA_URL = 'index.php?controller=api/APICategoria';

document.addEventListener('DOMContentLoaded', () => {
    fetchProducts();
    loadCategories(); // Cargar categorías al iniciar

    document.getElementById('product-form').addEventListener('submit', handleProductFormSubmit);
});

// Función simple para cargar categorías en el select
async function loadCategories() {
    try {
        const response = await fetch(API_CATEGORIA_URL);
        const categories = await response.json();
        const select = document.getElementById('product-categoriaId');
        
        select.innerHTML = '<option value="">Selecciona una categoría</option>';
        
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id_categoria;
            option.textContent = cat.nombre_categoria;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error cargando categorías:', error);
    }
}

async function fetchProducts() {
    try {
        const response = await fetch(API_PRODUCT_URL);
        const products = await response.json();
        currentProducts = products;
        renderProductTable(products);
    } catch (error) {
        console.error('Error fetching products:', error);
        alert('Error al cargar productos');
    }
}

function renderProductTable(products) {
    const tbody = document.querySelector('#products-table tbody');
    tbody.innerHTML = '';
    
    if(products.length === 0){
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No hay productos</td></tr>';
        return;
    }

    products.forEach(product => {
        const tr = document.createElement('tr');
        const activoClass = (product.activo == 1 || product.activo == '1') ? 'badge-success' : 'badge-danger';
        const activoLabel = (product.activo == 1 || product.activo == '1') ? 'Activo' : 'Inactivo';
        
        tr.innerHTML = `
            <td>#${product.id_producto}</td>
            <td>
                <div style="font-weight: 500; color: #111827;">${escapeHtml(product.nombre)}</div>
            </td>
            <td>${escapeHtml(product.descripcion).substring(0, 50)}...</td>
            <td>${product.precio}€</td>
            <td><img src="${escapeHtml(product.imagen)}" style="width:50px;height:50px;object-fit:cover;"></td>
            <td>${product.stock}</td>
            <td><span class="badge ${activoClass}">${activoLabel}</span></td>
            <td>${product.id_categoria}</td>
            <td>
                <button class="btn btn-edit" onclick="editProduct(${product.id_producto})">Editar</button><br><br>
                <button class="btn btn-delete" onclick="deleteProduct(${product.id_producto})">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// escapeHtml is already defined in admin_users.js if loaded first, but to be safe we can check or rename it.
// Since both scripts are loaded in the same page, we should avoid redefining global functions if they are identical.
// However, to avoid dependency order issues, let's rename it or check existence.
// For simplicity, let's assume admin_users.js loads first and defines escapeHtml. 
// If not, we define it locally with a different name or check window.

function editProduct(id) {
    const product = currentProducts.find(p => p.id_producto == id);
    if(product) openProductModal(product);
}

function openProductModal(product = null) {
    const modal = document.getElementById('product-modal');
    const title = document.getElementById('modal-title-product'); // We need to make sure IDs are unique in HTML
    const form = document.getElementById('product-form');

    modal.classList.add('open');
    
    if (product) {
        if(title) title.textContent = 'Editar Producto';
        document.getElementById('product-id').value = product.id_producto;
        document.getElementById('product-nombre').value = product.nombre;
        document.getElementById('product-descripcion').value = product.descripcion;
        document.getElementById('product-precio').value = product.precio;
        document.getElementById('product-imagen').value = product.imagen;
        document.getElementById('product-stock').value = product.stock;
        document.getElementById('product-activo').value = product.activo;
        document.getElementById('product-categoriaId').value = product.id_categoria;
    } else {
        if(title) title.textContent = 'Nuevo Producto';
        form.reset();
        document.getElementById('product-id').value = '';
        document.getElementById('product-activo').value = 0;
    }
}

function closeProductModal() {
    document.getElementById('product-modal').classList.remove('open');
}

async function handleProductFormSubmit(p) {
    p.preventDefault();
    
    const id = document.getElementById('product-id').value;
    const nombre = document.getElementById('product-nombre').value;
    const descripcion = document.getElementById('product-descripcion').value;
    const precio = document.getElementById('product-precio').value;
    const imagen = document.getElementById('product-imagen').value;
    const stock = document.getElementById('product-stock').value;
    const activo = document.getElementById('product-activo').value;
    const id_categoria = document.getElementById('product-categoriaId').value;

    const data = { nombre, descripcion, precio, imagen, stock, activo, id_categoria };
    
    let method = 'POST';
    
    if (id) {
        method = 'PUT';
        data.id_producto = id;
    } else {
        if(!imagen) {
            alert('La imagen es obligatoria para nuevos productos');
            return;
        }
    }

    try {
        const response = await fetch(API_PRODUCT_URL, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            closeProductModal();
            fetchProducts();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error saving product:', error);
        alert('Error de conexión');
    }
}

async function deleteProduct(id) {
    if (!confirm('¿Estás seguro de eliminar este producto?')) return;

    try {
        const response = await fetch(`${API_PRODUCT_URL}&id=${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            fetchProducts();
        } else {
            const error = await response.json();
            alert('Error: ' + (error.error || 'No se pudo eliminar'));
        }
    } catch (error) {
        console.error('Error deleting product:', error);
        alert('Error de conexión');
    }
}
