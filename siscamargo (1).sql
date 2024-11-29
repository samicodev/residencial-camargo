-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2024 a las 13:23:20
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siscamargo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `idperfil` int(11) NOT NULL,
  `idopcion` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`idperfil`, `idopcion`, `estado`) VALUES
(1, 1, 0),
(1, 2, 1),
(1, 3, 0),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(2, 3, 0),
(2, 4, 0),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1),
(2, 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `idcaja` int(11) NOT NULL,
  `fechaapertura` datetime NOT NULL,
  `fechacierre` datetime DEFAULT NULL,
  `saldoinicial` decimal(10,2) NOT NULL,
  `observacion` varchar(250) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`idcaja`, `fechaapertura`, `fechacierre`, `saldoinicial`, `observacion`, `estado`) VALUES
(1, '2024-11-01 07:04:10', NULL, '50.00', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL,
  `codigohabitacion` varchar(10) NOT NULL,
  `id_tipohabitacion` tinyint(4) NOT NULL,
  `estadohabitacion` tinyint(6) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `codigohabitacion`, `id_tipohabitacion`, `estadohabitacion`, `estado`) VALUES
(1, '1', 1, 1, 1),
(2, '2', 1, 0, 1),
(3, '3', 1, 1, 1),
(4, '4', 1, 0, 1),
(5, '5', 1, 0, 1),
(6, '6', 1, 0, 1),
(7, '7', 1, 0, 1),
(8, '8', 2, 0, 1),
(9, '9', 1, 0, 1),
(10, '10', 2, 0, 1),
(11, '11', 2, 0, 1),
(12, '12', 2, 0, 1),
(13, '13', 3, 0, 1),
(14, '14', 3, 0, 1),
(15, '15', 3, 0, 1),
(16, '16', 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedaje`
--

CREATE TABLE `hospedaje` (
  `id_hospedaje` int(11) NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `fechainicio` datetime NOT NULL,
  `fechafinal` datetime DEFAULT NULL,
  `duracionestadia` int(11) NOT NULL DEFAULT 1,
  `observacion` varchar(250) DEFAULT NULL,
  `estado` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `hospedaje`
--

INSERT INTO `hospedaje` (`id_hospedaje`, `id_habitacion`, `fechainicio`, `fechafinal`, `duracionestadia`, `observacion`, `estado`) VALUES
(1, 3, '2024-11-02 08:14:52', '2024-11-03 06:22:26', 1, NULL, 1),
(2, 3, '2024-11-03 19:24:46', '2024-11-05 11:34:42', 2, '', 1),
(3, 7, '2024-11-04 09:36:39', '2024-11-05 11:43:18', 1, NULL, 1),
(4, 8, '2024-11-06 18:47:09', '2024-11-07 08:51:02', 1, NULL, 1),
(5, 13, '2024-11-07 10:54:13', '2024-11-09 09:00:21', 2, '', 1),
(6, 1, '2024-11-09 08:05:58', '2024-11-10 11:07:35', 1, NULL, 1),
(7, 4, '2024-11-11 06:11:57', '2024-11-12 11:12:44', 1, NULL, 1),
(8, 2, '2024-11-12 17:23:18', '2024-11-13 07:24:05', 1, NULL, 1),
(9, 7, '2024-11-13 19:25:57', '2024-11-14 10:26:34', 1, NULL, 1),
(10, 6, '2024-11-14 11:31:49', '2024-11-16 07:32:43', 2, '', 1),
(11, 5, '2024-11-16 14:36:54', '2024-11-18 11:37:52', 2, '', 1),
(12, 6, '2024-11-19 11:42:24', '2024-11-20 07:43:04', 1, NULL, 1),
(13, 1, '2024-11-20 15:45:08', '2024-11-21 05:46:15', 1, NULL, 1),
(14, 9, '2024-11-21 16:49:30', '2024-11-24 07:03:33', 3, '', 1),
(15, 2, '2024-11-22 10:53:54', '2024-11-23 11:54:37', 1, NULL, 1),
(16, 6, '2024-11-23 06:57:13', '2024-11-24 11:03:50', 1, NULL, 1),
(17, 1, '2024-11-23 16:02:27', '2024-11-24 08:04:25', 1, NULL, 1),
(18, 3, '2024-11-24 08:07:11', NULL, 3, '', 1),
(19, 5, '2024-11-25 13:12:20', '2024-11-26 08:13:35', 1, NULL, 1),
(20, 1, '2024-11-26 08:17:37', NULL, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedar`
--

CREATE TABLE `hospedar` (
  `id_hospedar` int(11) NOT NULL,
  `resante` varchar(50) NOT NULL,
  `fechaingreso` datetime NOT NULL,
  `fechasalida` datetime DEFAULT NULL,
  `id_hospedaje` int(11) NOT NULL,
  `id_huesped` int(11) NOT NULL,
  `motviaje` varchar(200) NOT NULL,
  `estado` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `hospedar`
--

INSERT INTO `hospedar` (`id_hospedar`, `resante`, `fechaingreso`, `fechasalida`, `id_hospedaje`, `id_huesped`, `motviaje`, `estado`) VALUES
(1, 'Pando', '2024-11-02 08:20:14', '2024-11-03 06:52:22', 1, 19, 'Comerciante', 1),
(2, 'Beni', '2024-11-03 19:31:17', '2024-11-05 11:34:38', 2, 21, 'Trabajo', 1),
(3, 'Santa Cruz', '2024-11-04 09:39:18', '2024-11-05 11:41:09', 3, 22, 'Estudio', 1),
(4, 'La Paz', '2024-11-06 18:49:01', '2024-11-07 07:51:01', 4, 23, 'Trabajo', 1),
(5, 'La Paz', '2024-11-06 18:50:36', '2024-11-07 07:50:59', 4, 24, 'Trabajo', 1),
(6, 'Cochabamba', '2024-11-07 10:56:16', '2024-11-09 07:00:10', 5, 25, 'Estudio', 1),
(7, 'Cochabamba', '2024-11-07 10:57:47', '2024-11-09 07:00:09', 5, 26, 'Estudio', 1),
(8, 'Cochabamba', '2024-11-07 10:59:28', '2024-11-09 07:00:08', 5, 27, 'Estudio', 1),
(9, 'Pando', '2024-11-09 08:07:22', '2024-11-10 11:07:33', 6, 28, 'Trabajo', 1),
(10, 'Beni', '2024-11-11 06:12:26', '2024-11-12 11:12:42', 7, 1, 'Trabajo', 1),
(11, 'Pando', '2024-11-12 17:23:40', '2024-11-13 07:24:02', 8, 2, 'Trabajo', 1),
(12, 'Pando', '2024-11-13 19:26:20', '2024-11-14 10:26:31', 9, 3, 'Trabajo', 1),
(13, 'Pando', '2024-11-14 11:32:21', '2024-11-16 07:32:41', 10, 5, 'Trabajo', 1),
(14, 'Beni', '2024-11-16 14:37:08', '2024-11-18 11:37:50', 11, 11, 'Trabajo', 1),
(15, 'Beni', '2024-11-16 14:37:21', '2024-11-18 11:37:49', 11, 10, 'Trabajo', 1),
(16, 'Beni', '2024-11-19 11:42:48', '2024-11-20 07:43:02', 12, 1, 'Trabajo', 1),
(17, 'Santa Cruz', '2024-11-20 15:45:56', '2024-11-21 05:46:13', 13, 18, 'Turistico', 1),
(18, 'Pando', '2024-11-21 16:50:01', '2024-11-24 07:02:31', 14, 20, 'Estudio', 1),
(19, 'Pando', '2024-11-22 10:54:08', '2024-11-23 11:54:29', 15, 10, 'Trabajo', 1),
(20, 'Pando', '2024-11-23 06:59:32', '2024-11-24 11:02:49', 16, 29, 'Trabajo', 1),
(21, 'Pando', '2024-11-23 16:04:04', '2024-11-24 08:04:23', 17, 30, 'Trabajo', 1),
(22, 'Beni', '2024-11-24 08:08:18', NULL, 18, 31, 'Estudio', 1),
(23, 'Beni', '2024-11-24 08:09:38', NULL, 18, 32, 'Estudio', 1),
(24, 'Pando', '2024-11-25 13:12:35', '2024-11-26 08:13:33', 19, 21, 'Trabajo', 1),
(25, 'Pando', '2024-11-26 08:18:00', NULL, 20, 1, 'Trabajo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huesped`
--

CREATE TABLE `huesped` (
  `id_huesped` int(11) NOT NULL,
  `nombcomp` varchar(100) NOT NULL,
  `nrodocumento` varchar(20) NOT NULL,
  `id_tipodocumento` int(11) NOT NULL,
  `fenac` date NOT NULL,
  `nacionalidad` varchar(20) NOT NULL,
  `profesion` varchar(50) NOT NULL,
  `fecharegistro` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `huesped`
--

INSERT INTO `huesped` (`id_huesped`, `nombcomp`, `nrodocumento`, `id_tipodocumento`, `fenac`, `nacionalidad`, `profesion`, `fecharegistro`, `estado`) VALUES
(1, 'Patricia Fernandez Vaca', '5789099', 1, '1992-04-06', 'Boliviano', 'Medico', '2024-08-10', 1),
(2, 'Luis Flores Vaca', '7896121', 1, '1996-04-04', 'Boliviano', 'Albañil', '2024-08-10', 1),
(3, 'Clara García Martínez', '8904521', 2, '1990-04-14', 'Boliviano', 'Profesora', '2024-08-10', 1),
(4, 'Alejandro López Rodríguez', '5531076', 1, '1985-04-24', 'Boliviano', 'Profesor', '2024-08-10', 1),
(5, 'María José García Pérez', '4311120', 1, '1997-09-02', 'Boliviano', 'Ama de casa', '2024-08-10', 1),
(6, 'Alejandro Martín Rodríguez', '6618213', 1, '1995-11-27', 'Boliviano', 'Medico', '2024-08-10', 1),
(7, 'Ana Sofía López García', '5510341', 1, '1994-07-20', 'Boliviano', 'Estudiante', '2024-08-10', 1),
(8, 'Lucas González Márquez', '8021107', 1, '2000-05-09', 'Peruano', 'Chofer', '2024-08-10', 1),
(9, 'Fernanda Gutiérrez Martínez', '3841231', 1, '1982-12-04', 'Boliviano', 'Medico', '2024-08-10', 1),
(10, 'Roberto Vargas Aguilar', '4508082', 1, '1990-10-23', 'Boliviano', 'Ing. Sistemas', '2024-08-10', 1),
(11, 'Guillermo Flores Alonzo', '3431211', 1, '1992-09-30', 'Boliviano', 'Medico', '2024-08-10', 1),
(12, 'Juan Perez Almanza', '5334242', 1, '1979-04-10', 'Boliviano', 'Ing. Sistemas', '2024-09-10', 1),
(13, 'Jimena Perez Ali', '4534341', 1, '2006-10-09', 'Boliviano', 'Estudiante', '2024-09-10', 1),
(14, 'Noelia Quispe Zapata', '8912345', 1, '1985-04-06', 'Boliviano', 'Comerciante', '2024-09-19', 1),
(15, 'Lucas Gomez Alvarez', '5523111', 1, '2001-10-23', 'Boliviano', 'Estudiante', '2024-09-23', 2),
(16, 'Miguel Rojas Alves', '5432133', 2, '2001-10-10', 'Boliviano', 'Comerciante', '2024-09-03', 2),
(17, 'Lucas Fernández Apaza', '9122122', 1, '1997-02-10', 'Bolivano', 'Soldador', '2024-11-12', 1),
(18, 'Henry Suarez Aguilera', '8912331', 1, '1989-11-02', 'Boliviano', 'Mecanico', '2024-11-26', 1),
(19, 'Lucia Marupa Alvez', '5700661', 1, '1995-04-18', 'Boliviano', 'Comerciante', '2024-11-26', 1),
(20, 'Jesica Cusi Bazan', '9950309', 1, '1989-07-06', 'Boliviano', ' Profesora', '2024-11-26', 1),
(21, 'Gonzalo Calizaya Gutierrez', '12916233', 1, '1991-04-08', 'Boliviano', 'Ing. Civil', '2024-11-26', 1),
(22, 'Nirma Monje Callau', '13135784', 1, '1999-10-03', 'Boliviano', 'Estudiante', '2024-11-26', 1),
(23, 'Damaris Cartagena Chipunavi', '7581067', 1, '1998-08-23', 'Boliviano', 'Profesora', '2024-11-26', 1),
(24, 'Jesus Hurtado Calle', '12820386', 1, '1997-05-17', 'Boliviano', 'Profesor', '2024-11-26', 1),
(25, 'Armando Céspedes Pérez', '1764270', 1, '2004-04-06', 'Boliviano', 'Estudiante', '2024-11-26', 1),
(26, 'Nickol Chavez Cuellar', '5703808', 1, '2003-08-19', 'Boliviano', 'Estudiante', '2024-11-26', 1),
(27, 'Jorge Alarcon Ribera', '5291640', 1, '2003-07-28', 'Boliviano', 'Estudiante', '2024-11-26', 1),
(28, 'Miguel Justiniano Mercado', '1767019', 1, '1998-10-07', 'Boliviano', 'Medico', '2024-11-26', 1),
(29, 'Osman Roca Telleria', '5583155', 1, '1989-02-17', 'Boliviano', 'Contador', '2024-11-26', 1),
(30, 'Liliana Ruiz Alipaz', '12820121', 1, '1993-11-19', 'Boliviano', 'Ama de casa', '2024-11-26', 1),
(31, 'Raquel Rutani Mayo', '7625467', 1, '2002-12-04', 'Boliviano', 'Estudiante', '2024-11-26', 1),
(32, 'Jose Saavedra Aliaga', '6958751', 1, '2003-06-04', 'Boliviano', 'Estudiante', '2024-11-26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodopago`
--

CREATE TABLE `metodopago` (
  `idmetodopago` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `metodopago`
--

INSERT INTO `metodopago` (`idmetodopago`, `nombre`, `estado`) VALUES
(1, 'Efectivo', 1),
(2, 'Transferencia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `idopcion` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idopcion`, `descripcion`, `icono`, `url`, `estado`) VALUES
(1, 'Perfiles', 'fa-user-circle', 'vista/perfiles.php', 1),
(2, 'Usuarios', 'fa-user-lock', 'vista/usuarios.php', 1),
(3, 'Tipos de Habitacion', 'fa-tags', 'vista/tipohabitacion.php', 1),
(4, 'Habitaciones', 'fa-hotel', 'vista/habitaciones.php', 1),
(5, 'Huespedes', 'fa-id-card', 'vista/huespedes.php', 1),
(6, 'Hospedajes', 'fa-luggage-cart', 'vista/hospedajes.php', 1),
(7, 'Cajas', 'fa-money-check-alt', 'vista/cajas.php ', 1),
(8, 'Reportes', 'fa-file-alt', 'vista/reportes.php', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL COMMENT '0 -> INACTIVO \n1 -> ACTIVO\n2 -> ELIMINADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idperfil`, `nombre`, `estado`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'RECEPCIONISTA', 1),
(3, 'CAJERO', 2),
(4, 'ALMACENERO', 2),
(5, 'PRUEBA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id_tipodocumento` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id_tipodocumento`, `nombre`, `estado`) VALUES
(1, 'Cedula de Identidad', 1),
(2, 'Pasaporte', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `id_tipohabitacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipohabitacion`
--

INSERT INTO `tipohabitacion` (`id_tipohabitacion`, `nombre`, `precio`, `estado`) VALUES
(1, 'Simple', '100.00', 1),
(2, 'Doble', '150.00', 1),
(3, 'Triple', '180.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `idtransaccion` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `tipotransaccion` varchar(50) NOT NULL,
  `idmetodopago` int(11) NOT NULL,
  `idhuesped` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `idhospedaje` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`idtransaccion`, `monto`, `descripcion`, `tipotransaccion`, `idmetodopago`, `idhuesped`, `idcaja`, `idhospedaje`, `idusuario`, `fecha`) VALUES
(1, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 19, 1, 1, 4, '2024-11-02 08:22:12'),
(2, '200.00', 'Servicio de hospedaje', 'Ingreso', 1, 21, 1, 2, 5, '2024-11-03 07:18:22'),
(3, '100.00', 'Servicio de hospedaje', 'Ingreso', 2, 22, 1, 3, 4, '2024-11-04 09:41:06'),
(4, '120.00', 'Suministros de limpieza', 'Egreso', 1, 0, 1, 0, 4, '2024-11-04 10:46:12'),
(5, '150.00', 'Servicio de hospedaje', 'Ingreso', 1, 24, 1, 4, 5, '2024-11-06 07:20:04'),
(6, '360.00', 'Servicio de hospedaje', 'Ingreso', 1, 25, 1, 5, 4, '2024-11-07 11:00:04'),
(7, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 28, 1, 6, 4, '2024-11-09 07:07:31'),
(8, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 1, 1, 7, 4, '2024-11-11 06:12:37'),
(9, '10.00', 'Impresion y copias de planillas', 'Egreso', 1, 0, 1, 0, 4, '2024-11-11 14:16:37'),
(10, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 2, 1, 8, 5, '2024-11-12 17:25:16'),
(11, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 3, 1, 9, 5, '2024-11-13 19:29:00'),
(12, '200.00', 'Servicio de hospedaje', 'Ingreso', 1, 5, 1, 10, 4, '2024-11-14 11:32:39'),
(13, '200.00', 'Servicio de hospedaje', 'Ingreso', 1, 11, 1, 11, 4, '2024-11-16 14:37:42'),
(14, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 1, 1, 12, 4, '2024-11-20 07:42:57'),
(15, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 18, 1, 13, 4, '2024-11-20 15:46:11'),
(16, '300.00', 'Servicio de hospedaje', 'Ingreso', 1, 20, 1, 14, 5, '2024-11-21 16:50:29'),
(17, '100.00', 'Servicio de hospedaje', 'Ingreso', 2, 10, 1, 15, 4, '2024-11-22 11:54:26'),
(18, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 29, 1, 16, 4, '2024-11-23 06:59:46'),
(19, '100.00', 'Servicio de hospedaje', 'Ingreso', 1, 30, 1, 17, 5, '2024-11-23 08:06:29'),
(20, '200.00', 'Servicio de hospedaje', 'Ingreso', 1, 31, 1, 18, 4, '2024-11-24 08:10:11'),
(21, '100.00', 'Servicio de hospedaje', 'Ingreso', 2, 21, 1, 19, 4, '2024-11-25 08:12:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `idperfil` int(11) NOT NULL,
  `urlimagen` varchar(200) NOT NULL DEFAULT 'imagen/usuario/default.jpg',
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `usuario`, `clave`, `idperfil`, `urlimagen`, `estado`) VALUES
(1, 'Samuel Mamani', 'samuel', '96dd15ef622d7c10a9d3ad98c8619ba4733e0812', 1, 'imagen/usuario/default.jpg', 1),
(2, 'Cecilia Beatriz Quispe Camargo', 'cecilia', '6e4ca0dced8ff091780a3f13375642645960e0b6', 1, 'imagen/usuario/IMG_2default.jpg', 1),
(3, 'Pablo Camargo Quispe', 'pablo', '707d14912bb250caf67dfe0ea4035681fbfc4f56', 1, 'imagen/usuario/default.jpg', 1),
(4, 'Lizeth Muzumbita', 'lizeth', 'f22f65b7648b39ed9a143ee135e879244f79cc36', 2, 'imagen/usuario/default.jpg', 1),
(5, 'Freddy Marino', 'freddy', '5c8a7a129de8b649e9a0cbfbb7e9cec37a6efcb6', 2, 'imagen/usuario/default.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`idperfil`,`idopcion`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`idcaja`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`);

--
-- Indices de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  ADD PRIMARY KEY (`id_hospedaje`);

--
-- Indices de la tabla `hospedar`
--
ALTER TABLE `hospedar`
  ADD PRIMARY KEY (`id_hospedar`);

--
-- Indices de la tabla `huesped`
--
ALTER TABLE `huesped`
  ADD PRIMARY KEY (`id_huesped`);

--
-- Indices de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  ADD PRIMARY KEY (`idmetodopago`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`idopcion`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id_tipodocumento`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`id_tipohabitacion`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`idtransaccion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  MODIFY `id_hospedaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `hospedar`
--
ALTER TABLE `hospedar`
  MODIFY `id_hospedar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `huesped`
--
ALTER TABLE `huesped`
  MODIFY `id_huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  MODIFY `idmetodopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `idopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id_tipodocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `id_tipohabitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `idtransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
