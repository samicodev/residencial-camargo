-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 08:26:45
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
(1, '2024-09-28 20:13:39', '2024-09-28 22:50:39', '0.00', 'No se realizo ningún movimiento', 1);

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
(1, '1', 1, 0, 1),
(2, '2', 1, 0, 1),
(3, '3', 3, 0, 1),
(4, '4', 1, 0, 1),
(5, '5', 2, 0, 1),
(6, '6', 3, 0, 1),
(7, '7', 1, 0, 1),
(8, '8', 3, 0, 1),
(9, '9', 1, 0, 1),
(10, '10', 2, 0, 1),
(11, '11', 2, 0, 1),
(12, '12', 3, 0, 1),
(13, '13', 3, 0, 1),
(14, '14', 3, 0, 1),
(15, '17', 3, 0, 1),
(16, '18', 2, 0, 2);

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
(1, 'Patricia Fernandez Vaca', '5789099', 1, '2000-04-06', 'Boliviano', 'Medico', '2024-08-10', 1),
(2, 'Luis Flores Vaca', '7896121', 1, '2004-04-04', 'Boliviano', 'Albañil', '2024-08-10', 1),
(3, 'Clara García Martínez', '8904521', 2, '2004-04-14', 'Boliviano', 'Profesora', '2024-08-10', 1),
(4, 'Alejandro López Rodríguez', '5531076', 1, '2000-04-24', 'Boliviano', 'Profesor', '2024-08-10', 1),
(5, 'María José García Pérez', '4311120', 1, '1997-09-02', 'Boliviano', 'Trabajadora del hogar', '2024-08-10', 1),
(6, 'Alejandro Martín Rodríguez', '6618213', 1, '1995-11-27', 'Boliviano', 'Medico', '2024-08-10', 1),
(7, 'Ana Sofía López García', '5510341', 1, '1994-07-20', 'Boliviano', 'Estudiante', '2024-08-10', 1),
(8, 'Lucas González Márquez', '8021107', 1, '2000-05-09', 'Peruano', 'Chofer', '2024-08-10', 1),
(9, 'Fernanda Gutiérrez Martínez', '3841231', 1, '2001-12-04', 'Boliviano', 'Medico', '2024-08-10', 1),
(10, 'Efrain Opi', '4508082', 1, '1990-10-23', 'Boliviano', 'Ing. Sistemas', '2024-08-10', 1),
(11, 'Guillermo Flores', '343121', 1, '1992-09-30', 'Boliviano', 'Medico', '2024-08-10', 1),
(12, 'Juan Perez', '5334242', 1, '2000-10-10', 'Boliviano', 'Ing. Sistemas', '2024-09-10', 1),
(13, 'Jimena Perez', '453434', 1, '2001-10-09', 'Boliviano', 'Estudiante', '2024-09-10', 1),
(14, 'Noelia Quispe', '8912345', 1, '2001-04-06', 'Boliviano', 'Comerciante', '2024-09-19', 1),
(15, 'Lucas Gomez', '5523111', 1, '2001-10-23', 'Boliviano', 'Estudiante', '2024-09-23', 2),
(16, 'Miguel Rojas', '5432133', 2, '2001-10-10', 'Boliviano', 'Comerciante', '2024-09-03', 2);

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
(1, 'Matrimonial', '100.00', 1),
(2, 'Doble', '150.00', 1),
(3, 'Triple', '180.00', 1),
(4, 'Estandar', '80.00', 2),
(5, 'Premiun', '350.00', 2);

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
(2, 'Pablo Camargo Quispe', 'pablo', '96dd15ef622d7c10a9d3ad98c8619ba4733e0812', 1, 'imagen/usuario/IMG_2default.jpg', 1),
(3, 'Diego Calle', 'diego', '8354336224c63279aadd00a9621757ef4fdf31fc', 2, 'imagen/usuario/default.jpg', 1);

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
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  MODIFY `id_hospedaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hospedar`
--
ALTER TABLE `hospedar`
  MODIFY `id_hospedar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `huesped`
--
ALTER TABLE `huesped`
  MODIFY `id_huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `idtransaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
