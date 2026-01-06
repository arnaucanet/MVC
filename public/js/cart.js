const Carrito = {
    claveLocalStorage: 'mi_carrito_netflix',
    
    productos: [],

    iniciar() {
        const datosGuardados = localStorage.getItem(this.claveLocalStorage);
        
        if (datosGuardados) {
            // texto a array
            this.productos = JSON.parse(datosGuardados);
        }
        
        // actualizar vistas
        this.actualizarVista();
        this.actualizarContador();
    },

    anadirProducto(productoNuevo, cantidad = 1) {
        // buscar item
        const productoExistente = this.productos.find(item => item.id == productoNuevo.id);

        if (productoExistente) {
            // sumar
            productoExistente.cantidad += parseInt(cantidad);
        } else {
            // añadir
            this.productos.push({ 
                ...productoNuevo, 
                cantidad: parseInt(cantidad) 
            });
        }

        // guardar y actualizar
        this.guardarEnLocalStorage();
        this.actualizarVista();
        this.actualizarContador();
        
        const desplegable = document.getElementById('cartDropdown');
        if(desplegable) desplegable.classList.add('show');
    },

    eliminarProducto(idProducto) {
        // filtrar carrito sin el eliminado
        this.productos = this.productos.filter(item => item.id != idProducto);
        
        this.guardarEnLocalStorage();
        this.actualizarVista();
        this.actualizarContador();
    },

    cambiarCantidad(idProducto, cambio) {
        const producto = this.productos.find(item => item.id == idProducto);
        
        if (producto) {
            producto.cantidad += cambio;
        
            if (producto.cantidad <= 0) {
                this.eliminarProducto(idProducto);
            } else {
                this.guardarEnLocalStorage();
                this.actualizarVista();
                this.actualizarContador();
            }
        }
    },

    guardarEnLocalStorage() {
        //convertir en json
        localStorage.setItem(this.claveLocalStorage, JSON.stringify(this.productos));
    },

    actualizarContador() {
        // sumar cantidades productos
        let totalProductos = 0;
        for(let item of this.productos) {
            totalProductos += item.cantidad;
        }

        const etiquetaContador = document.getElementById('cartCount');
        if (etiquetaContador) {
            etiquetaContador.innerText = totalProductos;
            if (totalProductos > 0) {
                etiquetaContador.style.display = 'block';
            } else {
                etiquetaContador.style.display = 'none';
            }
        }
    },

    actualizarVista() {
        const contenedorItems = document.getElementById('cartItems');
        const elementoTotal = document.getElementById('cartTotal');
        
        if (!contenedorItems || !elementoTotal) return;

        if (this.productos.length === 0) {
            contenedorItems.innerHTML = '<div class="text-center text-white">Tu carrito está vacío</div>';
            elementoTotal.innerText = '0.00 €';
            return;
        }

        let html = '';
        let precioTotal = 0;

        // creamos html
        this.productos.forEach(item => {
            const totalProducto = item.price * item.cantidad;
            precioTotal += totalProducto;

            html += `
                <div class="cart-item d-flex align-items-center mb-3">
                    <img src="${item.image}" alt="${item.name}" class="rounded" width="50" height="50" style="object-fit: cover;">
                    
                    <div class="ms-3 flex-grow-1">
                        <div class="text-white small fw-bold" style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            ${item.name}
                        </div>
                        <div class="text-white small">${parseFloat(item.price).toFixed(2)} €</div>
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- el click que no cierre el carrito -->
                        <button class="btn btn-sm btn-outline-secondary text-white p-0 px-2" onclick="event.stopPropagation(); Carrito.cambiarCantidad(${item.id}, -1)">-</button>
                        <span class="mx-2 text-white small">${item.cantidad}</span>
                        <button class="btn btn-sm btn-outline-secondary text-white p-0 px-2" onclick="event.stopPropagation(); Carrito.cambiarCantidad(${item.id}, 1)">+</button>
                    </div>

                    <button class="btn btn-link text-danger ms-2 p-0" onclick="event.stopPropagation(); Carrito.eliminarProducto(${item.id})">
                        <img src="/MVC/public/icons/trash.svg" width="16" height="16" style="filter: invert(0.5) sepia(1) saturate(5) hue-rotate(-45deg);">
                    </button>
                </div>
            `;
        });

        contenedorItems.innerHTML = html;
        elementoTotal.innerText = precioTotal.toFixed(2) + ' €';
    },
    
    tramitarPedido() {
        if (this.productos.length === 0) return;
        
        const formulario = document.createElement('form');
        formulario.method = 'POST';
        formulario.action = 'index.php?controller=Pedido&action=checkout';
        
        const inputDatos = document.createElement('input');
        inputDatos.type = 'hidden';
        inputDatos.name = 'cart_data';
        inputDatos.value = JSON.stringify(this.productos);
        
        formulario.appendChild(inputDatos);
        document.body.appendChild(formulario);
        formulario.submit();
    }
};

// cuando la pagina cargue, iniciar todo
document.addEventListener('DOMContentLoaded', () => {
    Carrito.iniciar();

    // elementos html
    const botonCarrito = document.getElementById('cartToggle');
    const desplegable = document.getElementById('cartDropdown');
    const botonCerrar = document.getElementById('closeCart');
    const botonPagar = document.getElementById('checkoutBtn');

    // abrir y cerrar carrito
    if (botonCarrito && desplegable) {
        botonCarrito.addEventListener('click', (evento) => {
            evento.stopPropagation(); // Evita que el click se propague y cierre el menú inmediatamente
            desplegable.classList.toggle('show');
        });

        // cerrar si se hace click fuera
        document.addEventListener('click', (evento) => {
            if (!desplegable.contains(evento.target) && !botonCarrito.contains(evento.target)) {
                desplegable.classList.remove('show');
            }
        });
    }

    if (botonCerrar) {
        botonCerrar.addEventListener('click', () => {
            desplegable.classList.remove('show');
        });
    }
    
    if(botonPagar) {
        botonPagar.addEventListener('click', () => {
            Carrito.tramitarPedido();
        });
    }
});

// funcion global para añadir al carrito
function addToCartJS(id, nombre, precio, imagen, cantidad = 1) {
    Carrito.anadirProducto({ 
        id: id, 
        name: nombre, 
        price: precio, 
        image: imagen 
    }, cantidad);
}
