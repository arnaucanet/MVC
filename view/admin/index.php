<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Netflix Eats</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/admin.css">
</head>

<body>

    <div class="sidebar">
        <h2>Netflix Eats</h2>
        <nav>
            <a href="#" onclick="showSection('users')" id="nav-users" class="active">
                Usuarios
            </a>
            <a href="#" onclick="showSection('products')" id="nav-products">
                Productos
            </a>
            <a href="#" onclick="showSection('orders')" id="nav-orders">
                Pedidos
            </a>
            <a href="#" onclick="showSection('offers')" id="nav-offers">
                Ofertas
            </a>
            <a href="#" onclick="showSection('logs')" id="nav-logs">
                Logs
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="index.php?controller=Usuario&action=logout">← Cerrar Sesión</a>
        </div>
    </div>

    <div class="main-content">
        <!-- users -->
        <div id="users-section" class="section active">
            <div class="header-bar">
                <h1>Gestión de Usuarios</h1>
                <button class="btn btn-primary" onclick="openUserModal()">+ Nuevo Usuario</button>
            </div>

            <div class="card">
                <div class="table-container">
                    <table id="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- carga de datos con js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- products -->
        <div id="products-section" class="section">
            <div class="header-bar">
                <h1>Gestión de Productos</h1>
                <button class="btn btn-primary" onclick="openProductModal()">+ Nuevo Producto</button>
            </div>

            <div class="card">
                <div class="table-container">
                    <table id="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Imagen</th>
                                <th>Stock</th>
                                <th>Activo</th>
                                <th>ID Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- carga de datos con js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- orders -->
        <div id="orders-section" class="section">
            <div class="header-bar">
                <h1>Gestión de Pedidos</h1>
            </div>

            <!-- control de filtros -->
            <div class="card" style="margin-bottom: 20px; padding: 15px;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
                    <!-- filtros -->
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Usuario ID</label>
                        <input type="number" id="filter-user-id" placeholder="ID" style="padding: 5px; width: 80px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Desde Fecha</label>
                        <input type="date" id="filter-date-start" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Hasta Fecha</label>
                        <input type="date" id="filter-date-end" style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Precio</label>
                        <div style="display: flex; gap: 5px;">
                             <input type="number" id="filter-price-min" placeholder="Min" style="padding: 5px; width: 60px; border: 1px solid #ccc; border-radius: 4px;">
                             <input type="number" id="filter-price-max" placeholder="Max" style="padding: 5px; width: 60px; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <!-- clasificar -->
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Ordenar</label>
                        <div style="display: flex; gap: 5px;">
                            <select id="sort-by" style="padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="fecha_pedido">Fecha</option>
                                <option value="total">Precio</option>
                                <option value="id_usuario">Usuario</option>
                            </select>
                            <select id="sort-order" style="padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="desc">Desc</option>
                                <option value="asc">Asc</option>
                            </select>
                        </div>
                    </div>

                    <!-- moneda -->
                    <div>
                        <label style="font-size: 12px; display:block; margin-bottom:4px;">Moneda</label>
                        <select id="currency-select" style="padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="EUR">EUR (€)</option>
                            <option value="USD">USD ($)</option>
                            <option value="GBP">GBP (£)</option>
                            <option value="JPY">JPY (¥)</option>
                        </select>
                    </div>
                    
                    <div style="padding-bottom: 1px;">
                         <button id="apply-filters" class="btn btn-primary" style="padding: 6px 12px;">Aplicar</button>
                         <button id="clear-filters" class="btn btn-secondary" style="padding: 6px 12px; background: #666;">Limpiar</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="table-container">
                    <table id="orders-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario ID</th>
                                <th>Fecha</th>
                                <th>Destinatario</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- carga de datos con js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- offers -->
        <div id="offers-section" class="section">
            <div class="header-bar">
                <h1>Ofertas</h1>
            </div>
            <div class="card">
                <p>...</p>
            </div>
        </div>

        <!-- logs -->
        <div id="logs-section" class="section">
            <div class="header-bar">
                <h1>Historial de Acciones (Logs)</h1>
            </div>
            <div class="card">
                <div class="table-container">
                    <table id="logs-table">
                        <thead>
                            <tr>
                                <th>ID Log</th>
                                <th>Acción</th>
                                <th>Usuario ID</th>
                                <th>Fecha</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- carga de datos con js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- crear usuario -->
    <div id="user-modal" class="modal">
        <div class="modal-content">
            <h3 id="modal-title" style="margin-top:0; margin-bottom: 20px; font-size: 20px;">Usuario</h3>
            <form id="user-form">
                <input type="hidden" id="user-id">

                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" id="user-nombre" required placeholder="Ej: David Herrra">
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" id="user-email" required placeholder="ejemplo@gmail.com">
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" id="user-password" placeholder="••••••••">
                    <small style="color: #6b7280; font-size: 12px;">Nueva contraseña</small>
                </div>

                <div class="form-group">
                    <label>Rol de Usuario</label>
                    <select id="user-rol">
                        <option value="cliente">Cliente</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeUserModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <!-- crear producto -->
    <div id="product-modal" class="modal">
        <div class="modal-content">
            <h3 id="modal-title-product" style="margin-top:0; margin-bottom: 20px; font-size: 20px;">Producto</h3>
            <form id="product-form">
                <input type="hidden" id="product-id">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" id="product-nombre" required>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea id="product-descripcion" required></textarea>
                </div>

                <div class="form-group">
                    <label>Precio</label>
                    <input type="number" step="0.01" id="product-precio" required>
                </div>

                <div class="form-group">
                    <label>URL Imagen</label>
                    <input type="text" id="product-imagen" required>
                </div>

                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" id="product-stock" required>
                </div>

                <div class="form-group">
                    <label>Activo</label>
                    <select id="product-activo">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <select id="product-categoriaId" required>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeProductModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <!-- modal pedidos -->
    <div id="order-modal" class="modal">
        <div class="modal-content">
            <h3 id="modal-title-order" style="margin-top:0; margin-bottom: 20px; font-size: 20px;">Editar Pedido</h3>
            <form id="order-form">
                <input type="hidden" id="order-id">

                <div class="form-group">
                    <label>Estado del Pedido</label>
                    <select id="order-estado">
                        <option value="pendiente">pendiente</option>
                        <option value="en preparación">en preparación</option>
                        <option value="enviado">enviado</option>
                        <option value="entregado">entregado</option>
                        <option value="cancelado">cancelado</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeOrderModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="public/js/admin_users.js"></script>
    <script src="public/js/admin_products.js"></script>
    <script src="public/js/admin_orders.js"></script>
    <script src="public/js/admin_logs.js"></script>
    <script>
        //poder cambiar de seccion
        function showSection(id) {
            // quitar no seleccioandas
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.sidebar nav a').forEach(a => a.classList.remove('active'));

            // seccion seleccionada
            document.getElementById(id + '-section').classList.add('active');
            document.getElementById('nav-' + id).classList.add('active');
        }
    </script>
</body>

</html>