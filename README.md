# Netflix Eats

[English](#english) | [Español](#español)

<a name="english"></a>
## Description
**Netflix Eats** is a robust food delivery platform built with a custom PHP MVC (Model-View-Controller) architecture. It is designed to simulate a full-featured e-commerce environment, separating business logic, data management, and user interface presentation. The project features a customer-facing storefront for ordering food and a comprehensive Admin Dashboard for managing the entire platform.

## Key Features

### Architecture & Technology
- **MVC Architecture**: Strict separation of concerns:
  - **Model**: Entity classes and DAOs (Data Access Objects) for database interactions.
  - **View**: Dynamic HTML rendering for Client and Admin interfaces.
  - **Controller**: Handles user requests and business logic.
- **RESTful API**: Located in `controller/api/`, these endpoints allow for dynamic, asynchronous data fetching (AJAX) for a smoother user experience without page reloads.
- **Security**: Implements password hashing and secure session management.

### Admin Dashboard
A powerful control panel for platform administrators:
- **Comprehensive Management**: CRUD operations for **Users**, **Products**, **Orders**, and **Offers**.
- **Advanced Logging System**: 
  - Tracks admin actions (Insert, Update, Delete).
  - Captures detailed "Before" (`old_value`) and "After" (`new_value`) states for auditing changes.
- **Order System**:
  - Filter orders by **date**, **price**, or **user**.
  - **Currency Conversion**: Integrated capability to view financial data in multiple currencies (EUR, USD, etc.).

### User View
- **Product Catalog**: Categorized food listings (Mi Comida, Offers, etc.).
- **Cart & Checkout**: Full shopping cart functionality with a checkout flow.
- **User Profile**: Order history (`mis_pedidos.php`) and account management.

## Project Structure

```text
netflix-eats/
├── controller/         # Application Controllers
│   ├── api/            # API Controllers (AJAX endpoints)
│   └── ...             # Main Controllers (Admin, User, Product)
├── model/              # Data Layer
│   ├── DAO/            # Database Access Objects (SQL queries)
│   └── ...             # Entity Classes (Log, Pedido, Producto)
├── view/               # Presentation Layer
│   ├── admin/          # Admin Dashboard pages
│   ├── pedido/         # Orders & Checkout views
│   └── ...             # Other public views
├── public/             # Static Assets
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript (Admin logic, Cart, Carousel)
│   └── img/            # Images, Icons
├── database/           # Database Configuration
│   ├── create.sql      # Database schema setup
│   └── database.php    # DB Connection file
└── index.php           # Entry point
```

## Requirements

- **PHP**: 7.4 or higher
- **MySQL** / **MariaDB**
- **Web Server**: Apache (recommended via **XAMPP** or **WAMP**)

## Installation

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/your-repo/netflix-eats.git
    ```

2.  **Database Setup**
    - Open your database management tool (e.g., phpMyAdmin).
    - Create a new database (e.g., `netflixeats`).
    - Import the script `database/create.sql` to generate tables and initial data.

3.  **Configure Connection**
    - Open `database/database.php`.
    - Edit the connection parameters to match your local environment:
      ```php
      $host = "localhost";
      $user = "root";
      $pass = "";
      $db_name = "netflixeats";
      ```

4.  **Run the Application**
    - Ensure your Apache and MySQL servers are running.
    - Place the project folder in your web server's root directory (e.g., `htdocs`).
    - Navigate to `http://localhost/MVC` in your browser.

## Authors
- **Netflix Eats Team**

---

<br>

<a name="español"></a>
# Netflix Eats (Español)

## Descripción
**Netflix Eats** es una robusta plataforma de entrega de comida construida con una arquitectura PHP MVC (Modelo-Vista-Controlador) personalizada. Está diseñada para simular un entorno de comercio electrónico completo, separando la lógica de negocio, la gestión de datos y la presentación de la interfaz de usuario. El proyecto cuenta con una tienda para el cliente final y un completo Panel de Administración para gestionar toda la plataforma.

## Características Clave

### Arquitectura y Tecnología
- **Arquitectura MVC**: Separación estricta de responsabilidades:
  - **Modelo**: Clases de Entidad y DAOs (Objetos de Acceso a Datos) para interacciones con la base de datos.
  - **Vista**: Renderizado dinámico de HTML para interfaces de Cliente y Administración.
  - **Controlador**: Maneja las peticiones del usuario y la lógica de negocio.
- **API REST**: Ubicada en `controller/api/`, estos endpoints permiten la obtención dinámica y asíncrona de datos (AJAX) para una experiencia de usuario más fluida sin recargas de página.
- **Seguridad**: Implementa hash de contraseñas y gestión segura de sesiones.

### Panel de Administración
Un potente panel de control para los administradores de la plataforma:
- **Gestión Integral**: Operaciones CRUD para **Usuarios**, **Productos**, **Pedidos** y **Ofertas**.
- **Sistema de Logs Avanzado**: 
  - Rastrea acciones administrativas (Insertar, Actualizar, Eliminar).
  - Captura estados detallados "Antes" y "Después" para auditar cambios campo por campo.
- **Sistema de Pedidos**:
  - Filtrar pedidos por **fecha**, **precio** o **usuario**.
  - **Conversión de Moneda**: Capacidad integrada para ver datos financieros en múltiples monedas (EUR, USD, exportadas via API).

### Vista de Usuario
- **Catálogo de Productos**: Listados de comida categorizados.
- **Carrito y Checkout**: Funcionalidad completa de carrito de compras con flujo de pago.
- **Perfil de Usuario**: Historial de pedidos (`mis_pedidos.php`) y gestión de cuenta.

## Estructura del Proyecto

```text
netflix-eats/
├── controller/         # Controladores de la Aplicación
│   ├── api/            # Controladores API (endpoints AJAX)
│   └── ...             # Controladores Principales (Admin, Usuario, Producto)
├── model/              # Capa de Datos
│   ├── DAO/            # Objetos de Acceso a Datos (consultas SQL)
│   └── ...             # Clases de Entidad (Log, Pedido, Producto)
├── view/               # Capa de Presentación
│   ├── admin/          # Páginas del Dashboard de Admin
│   ├── pedido/         # Vistas de Pedidos y Checkout
│   └── ...             # Otras vistas públicas
├── public/             # Recursos Estáticos
│   ├── css/            # Hojas de estilo
│   ├── js/             # JavaScript (Lógica Admin, Carrito, Carrusel)
│   └── img/            # Imágenes, Iconos
├── database/           # Configuración de Base de Datos
│   ├── create.sql      # Script de esquema de BD
│   └── database.php    # Archivo de conexión a BD
└── index.php           # Punto de entrada
```

## Requisitos

- **PHP**: 7.4 o superior
- **MySQL** / **MariaDB**
- **Servidor Web**: Apache (recomendado vía **XAMPP** o **WAMP**)

## Instalación

1.  **Clonar el Repositorio**
    ```bash
    git clone https://github.com/tu-repo/netflix-eats.git
    ```

2.  **Configuración de Base de Datos**
    - Abre tu herramienta de gestión de base de datos (ej. phpMyAdmin).
    - Crea una nueva base de datos (ej. `netflixeats`).
    - Importa el script `database/create.sql` para generar las tablas y datos iniciales.

3.  **Configurar Conexión**
    - Abre `database/database.php`.
    - Edita los parámetros de conexión para que coincidan con tu entorno local:
      ```php
      $host = "localhost";
      $user = "root";
      $pass = "";
      $db_name = "netflixeats";
      ```

4.  **Ejecutar la Aplicación**
    - Asegúrate de que tus servidores Apache y MySQL estén corriendo.
    - Coloca la carpeta del proyecto en el directorio raíz de tu servidor web (ej. `htdocs`).
    - Navega a `http://localhost/MVC` en tu navegador.

## 👥 Autores
- **Equipo Netflix Eats**

---
*Desarrollado con fines educativos demostrando patrones MVC en PHP.*
