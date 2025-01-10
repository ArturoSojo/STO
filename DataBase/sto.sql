-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-01-2013 a las 08:55:50
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID` int(20) NOT NULL,
  `IDCLIENTE` int(10) NOT NULL,
  `IDPRODUCTO` int(10) NOT NULL,
  `PRECIO` double(20,2) NOT NULL,
  `CANTIDAD` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(10) NOT NULL,
  `categoria_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_descripcion`, `categoria_estado`) VALUES
(1, 'Computadoras', 'Equipos de computadoras y accesorios tecnológicos.', 'Habilitada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL,
  `cliente_nombre` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_apellido` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_genero` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(22) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_provincia` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cuenta_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cuenta_verificada` varchar(17) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(3) NOT NULL,
  `empresa_tipo_documento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_numero_documento` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `metodos_de_pago` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `favorito_id` int(15) NOT NULL,
  `favorito_fecha` date NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `imagen_id` int(30) NOT NULL,
  `imagen_nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(20) NOT NULL,
  `receptor_id` int(20) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(1000) NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `pedido_id` int(20) NOT NULL,
  `pedido_codigo` int(20) NOT NULL,
  `pedido_nombre` varchar(20) NOT NULL,
  `pedido_fecha` date NOT NULL,
  `pedido_tipo_envio` varchar(15) NOT NULL,
  `pedido_estado_envio` varchar(15) NOT NULL,
  `pedido_cantidad` int(10) NOT NULL,
  `pedido_costo` float(10,2) NOT NULL,
  `pedido_foto` varchar(100) NOT NULL,
  `cliente_id` int(20) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL,
  `producto_codigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_sku` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_descripcion` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_stock` int(10) NOT NULL,
  `producto_stock_minimo` int(10) NOT NULL,
  `producto_precio_compra` decimal(30,2) NOT NULL,
  `producto_precio_venta` decimal(30,2) NOT NULL,
  `producto_costo_envio` float(20,2) NOT NULL,
  `producto_descuento` int(3) NOT NULL,
  `producto_tipo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_presentacion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_marca` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_modelo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_portada` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(37) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_telefono` varchar(22) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_genero` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cuenta_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_telefono`, `usuario_genero`, `usuario_cargo`, `usuario_usuario`, `usuario_email`, `usuario_clave`, `usuario_cuenta_estado`, `usuario_foto`) VALUES
(1, 'Administrador', 'Principal', '00000000', 'Masculino', 'Administrador', 'Administrador', 'artlexweb@gmail.com', 'T1ZyUXBYZnRjWW56RXVvZ09UZDRBQT09', 'Activa', 'Avatar_Male_3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id` int(20) NOT NULL,
  `cliente_id` int(20) NOT NULL,
  `ultima_visita` datetime NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PRECIO` (`PRECIO`),
  ADD KEY `IDCLIENTE` (`IDCLIENTE`),
  ADD KEY `IDPRODUCTO` (`IDPRODUCTO`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`favorito_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`imagen_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receptor_id` (`receptor_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`pedido_id`),
  ADD UNIQUE KEY `cliente_id` (`cliente_id`),
  ADD UNIQUE KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `favorito_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `imagen_id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `pedido_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`IDCLIENTE`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`IDPRODUCTO`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`);

--
-- Filtros para la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
