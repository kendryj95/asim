-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2019 a las 06:14:48
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asim_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `balance_generale`
--

CREATE TABLE `balance_generale` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `activo_fecha` date NOT NULL,
  `activo_saldo` decimal(20,2) NOT NULL,
  `pasivo_patrimonio_fecha` date NOT NULL,
  `pasivo_patrimonio_saldo` decimal(20,2) NOT NULL,
  `resultado_perdida_fecha` date NOT NULL,
  `resultado_perdida_saldo` decimal(20,2) NOT NULL,
  `resultado_ganancia_fecha` date NOT NULL,
  `resultado_ganancia_saldo` decimal(10,0) NOT NULL,
  `utilidad_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL,
  `caja` varchar(150) NOT NULL,
  `fecha_emision` date NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `saldo` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contras`
--

CREATE TABLE `contras` (
  `id` int(11) NOT NULL,
  `contra` varchar(150) NOT NULL,
  `fecha_emision` date NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `saldo` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `participacion` varchar(150) NOT NULL,
  `comentario_reporte_empresa` varchar(250) NOT NULL,
  `comentario_reporte_inversion` varchar(250) NOT NULL,
  `inversor` varchar(10) NOT NULL,
  `ghost` varchar(60) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `have_children` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favores`
--

CREATE TABLE `favores` (
  `id` int(11) NOT NULL,
  `favor` varchar(150) NOT NULL,
  `fecha_emision` date NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `saldo` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificardor_pares`
--

CREATE TABLE `identificardor_pares` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_emps_users`
--

CREATE TABLE `permisos_emps_users` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_reporte_inversiones`
--

CREATE TABLE `registro_reporte_inversiones` (
  `id` int(11) NOT NULL,
  `id_reporte_inversiones` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `detalle_glosa` text NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `tipo` varchar(60) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_empresas`
--

CREATE TABLE `reporte_empresas` (
  `id` int(11) NOT NULL,
  `fecha_limite` date NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_realizacion` int(11) NOT NULL,
  `registro_transaccion` varchar(60) NOT NULL,
  `origen` varchar(60) NOT NULL,
  `destino` varchar(60) NOT NULL,
  `pares` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` text NOT NULL,
  `monto` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_inversiones`
--

CREATE TABLE `reporte_inversiones` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_propiedades`
--

CREATE TABLE `reporte_propiedades` (
  `id` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `rental` varchar(150) NOT NULL,
  `rol` varchar(60) NOT NULL,
  `fecha_compra` date NOT NULL,
  `folio` varchar(150) NOT NULL,
  `notaria` varchar(150) NOT NULL,
  `deuda_uf` decimal(20,2) NOT NULL,
  `banco` varchar(60) NOT NULL,
  `dividendo` int(11) NOT NULL,
  `monto_uf` decimal(20,2) NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `tipo`, `status`, `created_at`) VALUES
(1, 'Kendry Ortiz', 'ortiz@gmail.com', '123456', 1, 1, '2019-07-31 04:03:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `balance_generale`
--
ALTER TABLE `balance_generale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empresa_fk` (`id_empresa`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contras`
--
ALTER TABLE `contras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favores`
--
ALTER TABLE `favores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `identificardor_pares`
--
ALTER TABLE `identificardor_pares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_emps_users`
--
ALTER TABLE `permisos_emps_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_fk` (`id_user`),
  ADD KEY `id_empresa_fk` (`id_empresa`) USING BTREE;

--
-- Indices de la tabla `registro_reporte_inversiones`
--
ALTER TABLE `registro_reporte_inversiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_empresas`
--
ALTER TABLE `reporte_empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_inversiones`
--
ALTER TABLE `reporte_inversiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_propiedades`
--
ALTER TABLE `reporte_propiedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `balance_generale`
--
ALTER TABLE `balance_generale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contras`
--
ALTER TABLE `contras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favores`
--
ALTER TABLE `favores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `identificardor_pares`
--
ALTER TABLE `identificardor_pares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_emps_users`
--
ALTER TABLE `permisos_emps_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_reporte_inversiones`
--
ALTER TABLE `registro_reporte_inversiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_empresas`
--
ALTER TABLE `reporte_empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_inversiones`
--
ALTER TABLE `reporte_inversiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_propiedades`
--
ALTER TABLE `reporte_propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `balance_generale`
--
ALTER TABLE `balance_generale`
  ADD CONSTRAINT `id_empresa_fk` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos_emps_users`
--
ALTER TABLE `permisos_emps_users`
  ADD CONSTRAINT `id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
