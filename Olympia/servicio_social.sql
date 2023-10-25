-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2023 a las 20:32:08
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicio_social`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `clave_car` varchar(15) NOT NULL,
  `carrera` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla de informacion de las carreras';

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`clave_car`, `carrera`) VALUES
('043', 'TECNOLOGIAS DE LA INFORMACION'),
('109', 'ING.ELECTRICA Y ELECTRONICA'),
('110', 'ING.COMPUTACION'),
('114', 'ING.INDUSTRIAL'),
('124', 'ING.MECATRONICA'),
('200', 'DISEÑO DE ANIMACION DIGITAL'),
('210', 'PSICOLOGIA'),
('301', 'ADMINISTRACION'),
('304', 'CONTADURIA'),
('305', 'DERECHO'),
('401', 'ARTES VISUALES'),
('421', 'PEDAGOGIA'),
('423', 'DISEÑO Y COMUNICACION VISUAL'),
('890', 'TECNOLOGIAS DE LA INFORMACION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_contacto`
--

CREATE TABLE `info_contacto` (
  `correo` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `contacto_emerge` varchar(80) NOT NULL,
  `curp` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Informacion de contacto del aspirante';

--
-- Volcado de datos para la tabla `info_contacto`
--

INSERT INTO `info_contacto` (`correo`, `direccion`, `telefono`, `contacto_emerge`, `curp`) VALUES
('MFERNANDA.TORRES854@GMIAL.COM', 'AV. VALLE DE ALMAZORA', '5612800834', '5510067676', 'TOMI020907MMCRRNA2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_escuela`
--

CREATE TABLE `info_escuela` (
  `clave_plan` varchar(20) NOT NULL,
  `universidad` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='informacion de estudios del aspirante';

--
-- Volcado de datos para la tabla `info_escuela`
--

INSERT INTO `info_escuela` (`clave_plan`, `universidad`) VALUES
('0002', 'FACULTA DE ARTES Y DISEÑO UNAM'),
('0006', 'FACULTAD DE CONTADURIA Y ADMINISTRACION UNAM'),
('0007', 'FACULTAD DE DERECHO UNAM'),
('0011', 'FACULTAD DE INGENIERIA UNAM'),
('0019', 'FACULTA DE PSICOLOGIA UNAM'),
('0407', 'FES ARAGON (DERECHO)'),
('0410', 'FES ARAGON (FILOSOFIA)'),
('0411', 'FES ARAGON (INGENIERIA)'),
('091D', 'UNIVERSIDAD DE LONDRES'),
('09PB', 'UNIVERSIDAD CUGS'),
('09PS', 'UNIVERSIDAD DE NEGOCIOS ISEC'),
('09PU', 'UNIVERSIDAD SALESIANA'),
('1183', 'UNIVERSIDAD LATINA'),
('15PS', 'UNIVERSIDAD INSURGENTES'),
('4111', 'FES ARAGON (PEDAGOGIA)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_personal`
--

CREATE TABLE `info_personal` (
  `curp` varchar(18) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `padecimientos` varchar(60) NOT NULL,
  `nacimiento` varchar(15) NOT NULL,
  `medicamento` varchar(100) NOT NULL,
  `accion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Informacion personal del aspirante';

--
-- Volcado de datos para la tabla `info_personal`
--

INSERT INTO `info_personal` (`curp`, `nombre`, `padecimientos`, `nacimiento`, `medicamento`, `accion`) VALUES
('TOMI020907MMCRRNA2', 'INGRID FERNANDA TORRES MORENO', 'NADA', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `clave_ss` varchar(25) NOT NULL,
  `programa_ss` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`clave_ss`, `programa_ss`) VALUES
('2022-5/883-1076', 'FORTALECIMIENTO EN PROGRAMAS PARA EL DESARROLLO DE COMPETENCIAS LABORA'),
('2022-5/883-1077', 'DESARROLLO DE SISTEMAS DE GESTIÓN Y LA METODOLOGÍA APLICADA PARA SU IMPLEMENTACIÓN EN LA SUSTENTABILIDAD EN LA PEQUEÑA Y MEDIANA EMPRESA (PYMES)'),
('2022-5/883-1088', 'SOPORTE EN LA PLATAFORMA DIGITAL PARA IMPARTICIÓN DE CURSOS DE CAPACITACIÓN SOBRE SUSTENTABILIDAD, DESARROLLO SOCIAL Y HUMANO'),
('2023-5/883-3235', 'DESARROLLO DE SISTEMAS DE GESTIÓN Y LA METODOLOGÍA APLICADA PARA SU IMPLEMENTACIÓN EN LA SUSTENTABILIDAD EN LA PEQUEÑA Y MEDIANA EMPRESA (PYMES)'),
('2023-5/883-3543', 'SOPORTE EN LA PLATAFORMA DIGITAL PARA IMPARTICIÓN DE CURSOS DE CAPACITACIÓN SOBRE SUSTENTABILIDAD, DESARROLLO SOCIAL Y HUMANO.'),
('2023-5/883-3662', 'FORTALECIMIENTO EN PROGRAMAS PARA EL DESARROLLO DE COMPETENCIAS LABORALES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `curp` varchar(18) NOT NULL,
  `clave_plan` varchar(20) NOT NULL,
  `clave_car` varchar(15) NOT NULL,
  `modalidad` varchar(12) NOT NULL,
  `fecha_inicio` varchar(15) NOT NULL,
  `fecha_fin` varchar(15) NOT NULL,
  `horario` varchar(80) NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `promedio` float NOT NULL,
  `creditos` varchar(6) NOT NULL,
  `RFC` varchar(13) NOT NULL,
  `clave_ss` varchar(25) NOT NULL,
  `reporte` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Informacion del servicio del aspirante ';

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`curp`, `clave_plan`, `clave_car`, `modalidad`, `fecha_inicio`, `fecha_fin`, `horario`, `estatus`, `promedio`, `creditos`, `RFC`, `clave_ss`, `reporte`) VALUES
('TOMI020907MMCRRNA2', '0011', '110', 'PRESENCIAL', '2023-06-05', '2023-12-05', '9 A 2', 'ACTIVO', 9, '75', 'TOMI020907GGG', '2022-5/883-1076', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`clave_car`);

--
-- Indices de la tabla `info_contacto`
--
ALTER TABLE `info_contacto`
  ADD PRIMARY KEY (`curp`),
  ADD KEY `fk_curp_contacto` (`curp`);

--
-- Indices de la tabla `info_escuela`
--
ALTER TABLE `info_escuela`
  ADD PRIMARY KEY (`clave_plan`);

--
-- Indices de la tabla `info_personal`
--
ALTER TABLE `info_personal`
  ADD PRIMARY KEY (`curp`) USING BTREE;

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`clave_ss`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`curp`),
  ADD KEY `FK_Curp` (`curp`),
  ADD KEY `FK_servicio-escuela` (`clave_plan`),
  ADD KEY `FK_servicio-carrera` (`clave_car`),
  ADD KEY `servicio_ibfk_4` (`clave_ss`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `info_contacto`
--
ALTER TABLE `info_contacto`
  ADD CONSTRAINT `info_contacto_ibfk_1` FOREIGN KEY (`curp`) REFERENCES `servicio` (`curp`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`clave_plan`) REFERENCES `info_escuela` (`clave_plan`),
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`clave_car`) REFERENCES `carreras` (`clave_car`),
  ADD CONSTRAINT `servicio_ibfk_3` FOREIGN KEY (`curp`) REFERENCES `info_personal` (`curp`),
  ADD CONSTRAINT `servicio_ibfk_4` FOREIGN KEY (`clave_ss`) REFERENCES `programa` (`clave_ss`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
