-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 09-01-2026 a les 17:01:15
-- Versió del servidor: 10.4.32-MariaDB
-- Versió de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `netflixeats`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_categoria` varchar(255) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `descripcion`, `imagen_categoria`, `activa`) VALUES
(1, 'Pizzas', 'Categoría de pizzas de diferentes estilos y sabores', '/public/img/categorias/pizzas.png', 1),
(2, 'Burgers', 'Hamburguesas y platos estilo americano', '/public/img/categorias/burgers.png', 1),
(3, 'Mariscos', 'Platos elaborados con frutos del mar', '/public/img/categorias/mariscos.png', 1),
(4, 'Postres', 'Dulces, repostería y postres clásicos', '/public/img/categorias/postres.png', 1),
(5, 'Japonesa', 'Gastronomía tradicional japonesa', '/public/img/categorias/japonesa.png', 1),
(6, 'China', 'Platos tradicionales de la cocina china', '/public/img/categorias/china.png', 1),
(7, 'Mexicana', 'Comida auténtica mexicana llena de sabor', '/public/img/categorias/mexicana.png', 1),
(8, 'Española', 'Recetas típicas de España', '/public/img/categorias/espanola.png', 1),
(9, 'Italiana', 'Platos clásicos italianos como pasta y más', '/public/img/categorias/italiana.png', 1),
(10, 'Inglesa', 'Platos típicos del Reino Unido', '/public/img/categorias/inglesa.png', 1),
(11, 'Húngara', 'Cocina tradicional de Hungría', '/public/img/categorias/hungara.png', 1),
(12, 'General', 'Productos varios que no entran en otras categorías', '/public/img/categorias/general.png', 1),
(13, 'Peruana', 'Platos tradicionales de la gastronomía peruana', '/public/img/categorias/peruana.png', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `ip_usuario` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `log`
--

INSERT INTO `log` (`id_log`, `id_usuario`, `accion`, `fecha`, `ip_usuario`) VALUES
(1, 7, 'Actualizo pedido #11 a estado: en preparación', '2026-01-08 10:30:09', '::1'),
(2, 7, 'Elimino usuario ID: 5', '2026-01-08 10:32:49', '::1'),
(3, 7, 'Creo usuario nuevo: test22@test.com', '2026-01-08 10:33:02', '::1'),
(4, 7, 'Actualizo producto ID: 7', '2026-01-08 11:41:55', '::1'),
(5, 7, 'Actualizo usuario ID: 8', '2026-01-08 11:42:02', '::1'),
(6, 7, 'Actualizo pedido #14 a estado: entregado', '2026-01-08 11:42:09', '::1'),
(7, 7, 'Creo oferta: TEST123', '2026-01-08 11:52:31', '::1'),
(8, 7, 'Actualizo oferta ID: 4. Campos: fecha_inicio, fecha_fin', '2026-01-08 11:52:42', '::1'),
(9, 7, 'Actualizo oferta ID: 4. Campos: fecha_inicio, fecha_fin', '2026-01-08 11:54:19', '::1'),
(10, 7, 'Elimino oferta ID: 4', '2026-01-08 12:01:05', '::1'),
(11, 7, 'Actualizo pedido #8. Campos: estado (\'en preparación\' -> \'enviado\')', '2026-01-08 12:01:44', '::1'),
(12, 7, 'Actualizo producto ID: 8', '2026-01-08 12:02:03', '::1'),
(13, 7, 'Actualizo producto ID: 7', '2026-01-08 12:02:08', '::1'),
(14, 7, 'Actualizo usuario ID: 1. Campos modificados: password', '2026-01-08 12:02:19', '::1'),
(15, 7, 'Actualizo usuario ID: 10. Campos modificados: nombre, email, password', '2026-01-08 12:02:34', '::1'),
(16, 7, 'Creo oferta: test', '2026-01-08 12:48:37', '::1'),
(17, 7, 'Actualizo oferta ID: 5. Campos: descripcion', '2026-01-08 12:48:41', '::1'),
(18, 7, 'Elimino oferta ID: 5', '2026-01-08 12:48:43', '::1');

-- --------------------------------------------------------

--
-- Estructura de la taula `mi_comida`
--

CREATE TABLE `mi_comida` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_agregado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento_porcentaje` decimal(5,2) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `codigo`, `descripcion`, `descuento_porcentaje`, `fecha_inicio`, `fecha_fin`, `activa`) VALUES
(1, 'WELCOME10', 'Descuento de bienvenida para nuevos usuarios', 10.00, '2026-01-01', '2026-12-31', 1),
(2, 'NETFLIXEATS20', 'Promoción especial NetflixEats', 20.00, '2026-02-01', '3000-02-01', 1),
(3, 'FREESHIP15', 'Descuento por tiempo limitado', 15.00, '2026-03-01', '2026-03-15', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre_destinatario` varchar(255) DEFAULT NULL,
  `direccion_envio` varchar(255) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','en preparación','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  `moneda` varchar(10) DEFAULT 'EUR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `nombre_destinatario`, `direccion_envio`, `cp`, `ciudad`, `telefono_contacto`, `id_oferta`, `fecha_pedido`, `estado`, `total`, `moneda`) VALUES
(7, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', '123123123', NULL, '2026-01-07 18:48:25', 'entregado', 210.00, 'EUR'),
(8, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', '123123123', NULL, '2026-01-07 18:48:58', 'enviado', 296.67, 'EUR'),
(9, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', NULL, '2026-01-07 21:49:50', 'enviado', 26.97, 'EUR'),
(10, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', NULL, '2026-01-07 21:49:59', 'entregado', 17.98, 'EUR'),
(11, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', NULL, '2026-01-07 21:50:06', 'en preparación', 9.99, 'EUR'),
(12, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', NULL, '2026-01-07 22:48:31', 'pendiente', 21.00, 'EUR'),
(13, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', 2, '2026-01-07 22:57:23', 'pendiente', 72.58, 'EUR'),
(14, 7, 'Arnau Canet', 'Lleida 16', '08754', 'El Papiol', 'da', 2, '2026-01-07 23:32:59', 'entregado', 87.10, 'EUR');

-- --------------------------------------------------------

--
-- Estructura de la taula `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`, `activo`, `id_categoria`) VALUES
(1, 'American Burger', 'Una hamburguesa clásica americana, jugosa y contundente, perfecta para los amantes del sabor auténtico.', 9.90, '/MVC/public/img/american_burguer.webp', 100, 1, 2),
(3, 'Bloody Pizza calvo', 'Una pizza intensa y atrevida, pensada para quienes quieren experimentar sabores fuera de lo común.', 12.50, '/MVC/public/img/bloody_pizza.webp', 100, 1, 1),
(4, 'Brownie', 'Un brownie de chocolate intenso, suave por dentro y crujiente por fuera. El postre perfecto para cerrar cualquier maratón culinario.', 4.50, '/MVC/public/img/brownie.webp', 100, 1, 4),
(5, 'Ceviche Peruano', 'Un ceviche peruano vibrante, fresco y cítrico, preparado según la tradición y con el equilibrio perfecto.', 13.90, '/MVC/public/img/ceviche_peru.webp', 100, 1, 13),
(7, 'Cheese Pizza', 'La pizza de queso definitiva: simple, clásica y deliciosa, ideal para los amantes del sabor auténtico.', 9.50, '/MVC/public/img/cheese_pizza.webp', 100, 1, 1),
(9, 'Explosive BBQ Pizza', 'Una pizza BBQ con un sabor ahumado y explosivo que te engancha desde el primer bocado.', 12.90, '/MVC/public/img/explosive-bbq-pizza.webp', 100, 1, 1),
(10, 'Explosive BBQ Pizza 2', 'Una versión alternativa de la clásica BBQ, con matices más profundos y un final sorprendente.', 12.90, '/MVC/public/img/explosive_bbq_pizza.webp', 100, 1, 1),
(11, 'Fish & Chips', 'El clásico británico en su versión más crujiente y sabrosa. Un viaje directo al Reino Unido en cada porción.', 10.90, '/MVC/public/img/fish_chips_uk.webp', 100, 1, 10),
(12, 'Galaxy Pizza', 'Una pizza cósmica llena de colores y sabores que desafían lo tradicional.', 14.90, '/MVC/public/img/galaxy_pizza.webp', 100, 1, 1),
(13, 'Goulash Húngaro', 'El goulash húngaro original: carne tierna, especias cálidas y un sabor reconfortante que encanta a todos.', 13.50, '/MVC/public/img/gooulash_hungria.webp', 100, 1, 11),
(15, 'Jamón Ibérico', 'Un plato de jamón ibérico de calidad excepcional que captura el alma de España.', 15.90, '/MVC/public/img/jamon_iberico_spain.webp', 100, 1, 8),
(16, 'Mediterranean Pizza', 'Una pizza fresca con ingredientes mediterráneos que te transportan directamente a la costa.', 12.00, '/MVC/public/img/mediterranean_pizza.webp', 100, 1, 1),
(18, 'Paella Española', 'La paella española de siempre, llena de sabor y tradición, ideal para compartir.', 15.50, '/MVC/public/img/paella_spain.webp', 100, 1, 8),
(19, 'Pasta Italiana', 'Pasta italiana tradicional elaborada con ingredientes frescos y una combinación de sabores que nunca falla.', 11.90, '/MVC/public/img/pasta_italia.webp', 100, 1, 9),
(20, 'Pato Pekín', 'El tradicional pato Pekín, crujiente y aromático, uno de los platos más emblemáticos de China.', 16.90, '/MVC/public/img/pato_pekines.webp', 100, 1, 6),
(22, 'Pulpo a la Gallega', 'Pulpo gallego tradicional, tierno y lleno de aroma, preparado al estilo clásico.', 16.00, '/MVC/public/img/pulpo_gallega_spain.webp', 100, 1, 8),
(23, 'Ramen', 'Un ramen auténtico con caldo profundo, fideos suaves y acompañamientos clásicos de la cocina japonesa.', 12.50, '/MVC/public/img/ramen.webp', 100, 1, 5),
(24, 'Sushi', 'Una selección de sushi variado y fresco que ofrece una experiencia japonesa completa en cada pieza.', 14.50, '/MVC/public/img/sushi.webp', 100, 1, 5),
(25, 'Taco Francés', 'Un taco con toque francés y estilo gourmet, perfecto para quienes buscan algo distinto.', 9.90, '/MVC/public/img/taco_frances.webp', 100, 1, 8),
(26, 'Tortilla de Patatas', 'Una tortilla española jugosa y tradicional, elaborada al estilo casero para los amantes de lo auténtico.', 8.50, '/MVC/public/img/tortilla_patatas_spain.webp', 100, 1, 8),
(28, 'Adrenaline', 'Una hamburguesa explosivamente picante, diseñada para quienes buscan acción en cada bocado.', 9.99, '/MVC/public/img/adrenaline_producto.webp', 100, 1, 2),
(29, 'Cosmic', 'Una hamburguesa futurista con queso azul y un sabor que parece venir de otra galaxia.', 8.99, '/MVC/public/img/cosmic_producto.webp', 100, 1, 2),
(30, 'Dark Flame', 'Una hamburguesa intensa con pan negro y sabores potentes para quienes disfrutan de lo desconocido.', 10.50, '/MVC/public/img/darkFlame_producto.webp', 100, 1, 2),
(31, 'Happy Bite', 'Una hamburguesa divertida y llena de sabor, pensada para conquistar a toda la familia en cada mordisco.', 7.25, '/MVC/public/img/happyBite_producto.webp', 100, 1, 2),
(32, 'Hidden Taste', 'Una hamburguesa gourmet con una salsa secreta que convierte cada bocado en un misterio irresistible.', 9.25, '/MVC/public/img/hiddenTaste_producto.webp', 100, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('cliente','administrador') DEFAULT 'cliente',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `password`, `direccion`, `telefono`, `rol`, `fecha_registro`) VALUES
(1, 'test', 'test@test.com', '$2y$10$qiM.C4c1DaWObq97DefvJuXpFr0MrIxczCfyC2X.HWEZ2Cz9KtaSy', '', '', 'administrador', '2025-11-27 14:30:39'),
(3, 'test2', 'test2@test.com', '$2y$10$nPa7ZT9gIWmzz/6JpxTXYuV..Is/mWVfGadhVrlojHls/nEQ0Qi8W', 'Calle mirda', '682464307', 'cliente', '2025-11-27 20:15:49'),
(7, 'Arnau', 'canetarn05@gmail.com', '$2y$10$afLpYtYB8Qrz.ip7OCLNeOOpANLtx38wpIF2cNFtu0wj1Lry5HOB6', 'Lleida 16, 08754, El Papiol', '682464307', 'administrador', '2026-01-07 15:44:23'),
(8, 'aaaa2', 'asdasd@gmail.com', '$2y$10$17YS1il7zS96aC4OMkxfI.KSys5sKI99PchzQ1NTQGPPnAknQhKQG', '', '', 'cliente', '2026-01-07 18:24:22'),
(9, 'test3', 'test3@test.com', '$2y$10$nO7Pbtb0DMBH1OsPY49fvePL5neaVcTB5wGrCUg0L7SoIqYh1YvEm', '', '', 'cliente', '2026-01-08 10:01:04'),
(10, 'test23', 'test23@test.com', '$2y$10$DIm5QjrIkENVL4i/4y.9m.4k40NUn9L2CyWsPN3N6xYDw/uXITXeu', '', '', 'cliente', '2026-01-08 10:33:02');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índexs per a la taula `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Índexs per a la taula `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índexs per a la taula `mi_comida`
--
ALTER TABLE `mi_comida`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Índexs per a la taula `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Índexs per a la taula `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Índexs per a la taula `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índexs per a la taula `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la taula `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la taula `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la taula `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la taula `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la taula `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT per la taula `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restriccions per a la taula `mi_comida`
--
ALTER TABLE `mi_comida`
  ADD CONSTRAINT `mi_comida_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mi_comida_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restriccions per a la taula `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
