-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-01-2024 a las 02:00:43
-- Versión del servidor: 8.0.31
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `data_tpi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE `cuota` (
  `id` int NOT NULL,
  `prestamo` int NOT NULL,
  `numeroCuota` int NOT NULL,
  `montoCuota` double NOT NULL,
  `fechavencimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int NOT NULL COMMENT '1-Pagado,2-No pagado',
  `interes` double NOT NULL,
  `principal` double NOT NULL,
  `saldoPendiente` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cuota`
--

INSERT INTO `cuota` (`id`, `prestamo`, `numeroCuota`, `montoCuota`, `fechavencimiento`, `estado`, `interes`, `principal`, `saldoPendiente`) VALUES
(228, 28, 1, 191.22340240141497, '2023-12-09 06:00:00', 1, 75, 116.22340240141497, 2883.776597598585),
(229, 28, 2, 191.22340240141497, '2024-03-09 06:00:00', 1, 72.09441493996462, 119.12898746145035, 2764.6476101371345),
(230, 28, 3, 191.22340240141497, '2024-06-09 06:00:00', 1, 69.11619025342836, 122.10721214798662, 2642.540397989148),
(231, 28, 4, 191.22340240141497, '2024-09-09 06:00:00', 1, 66.0635099497287, 125.15989245168628, 2517.380505537462),
(232, 28, 5, 191.22340240141497, '2024-12-09 06:00:00', 1, 62.934512638436544, 128.28888976297844, 2389.091615774483),
(233, 28, 6, 191.22340240141497, '2025-03-09 06:00:00', 1, 59.72729039436208, 131.4961120070529, 2257.5955037674303),
(234, 28, 7, 191.22340240141497, '2025-06-09 06:00:00', 1, 56.43988759418575, 134.7835148072292, 2122.8119889602012),
(235, 28, 8, 191.22340240141497, '2025-09-09 06:00:00', 1, 53.07029972400503, 138.15310267740995, 1984.6588862827912),
(236, 28, 9, 191.22340240141497, '2025-12-09 06:00:00', 1, 49.61647215706978, 141.6069302443452, 1843.051956038446),
(237, 28, 10, 191.22340240141497, '2026-03-09 06:00:00', 1, 46.07629890096115, 145.14710350045382, 1697.9048525379922),
(238, 28, 11, 191.22340240141497, '2026-06-09 06:00:00', 1, 42.4476213134498, 148.77578108796519, 1549.129071450027),
(239, 28, 12, 191.22340240141497, '2026-09-09 06:00:00', 1, 38.72822678625067, 152.4951756151643, 1396.6338958348626),
(240, 28, 13, 191.22340240141497, '2026-12-09 06:00:00', 1, 34.915847395871566, 156.3075550055434, 1240.3263408293192),
(241, 28, 14, 191.22340240141497, '2027-03-09 06:00:00', 1, 31.008158520732977, 160.215243880682, 1080.1110969486372),
(242, 28, 15, 191.22340240141497, '2027-06-09 06:00:00', 1, 27.002777423715926, 164.22062497769906, 915.890471970938),
(243, 28, 16, 191.22340240141497, '2027-09-09 06:00:00', 1, 22.89726179927345, 168.32614060214152, 747.5643313687965),
(244, 28, 17, 191.22340240141497, '2027-12-09 06:00:00', 1, 18.689108284219913, 172.53429411719506, 575.0300372516015),
(245, 28, 18, 191.22340240141497, '2028-03-09 06:00:00', 2, 14.375750931290035, 176.84765147012493, 398.18238578147657),
(246, 28, 19, 191.22340240141497, '2028-06-09 06:00:00', 2, 9.954559644536914, 181.26884275687806, 216.9135430245985),
(247, 28, 20, 191.22340240141497, '2028-09-09 06:00:00', 2, 5.422838575614962, 216.9135430245985, 0),
(248, 29, 1, 382.44680480282994, '2023-12-09 06:00:00', 1, 150, 232.44680480282994, 2767.55319519717),
(249, 29, 2, 382.44680480282994, '2024-06-09 06:00:00', 1, 138.3776597598585, 244.06914504297146, 2523.484050154199),
(250, 29, 3, 382.44680480282994, '2024-12-09 06:00:00', 1, 126.17420250770995, 256.27260229512, 2267.211447859079),
(251, 29, 4, 382.44680480282994, '2025-06-09 06:00:00', 1, 113.36057239295394, 269.086232409876, 1998.1252154492029),
(252, 29, 5, 382.44680480282994, '2025-12-09 06:00:00', 1, 99.90626077246014, 282.5405440303698, 1715.584671418833),
(253, 29, 6, 382.44680480282994, '2026-06-09 06:00:00', 1, 85.77923357094164, 296.6675712318883, 1418.9171001869447),
(254, 29, 7, 382.44680480282994, '2026-12-09 06:00:00', 1, 70.94585500934724, 311.50094979348273, 1107.416150393462),
(255, 29, 8, 382.44680480282994, '2027-06-09 06:00:00', 1, 55.37080751967309, 327.0759972831569, 780.3401531103051),
(256, 29, 9, 382.44680480282994, '2027-12-09 06:00:00', 1, 39.01700765551526, 343.4297971473147, 436.9103559629904),
(257, 29, 10, 382.44680480282994, '2028-06-09 06:00:00', 1, 21.845517798149523, 436.9103559629904, 0),
(258, 30, 1, 386.8309078160131, '2023-12-11 06:00:00', 2, 22.5, 364.3309078160131, 1135.6690921839868),
(259, 30, 2, 386.8309078160131, '2024-06-11 06:00:00', 1, 17.035036382759802, 369.7958714332533, 765.8732207507335),
(260, 30, 3, 386.8309078160131, '2024-12-11 06:00:00', 1, 11.488098311261002, 375.3428095047521, 390.5304112459814),
(261, 30, 4, 386.8309078160131, '2025-06-11 06:00:00', 1, 5.8579561686897215, 390.5304112459814, 0),
(262, 31, 1, 907.3085785920747, '2024-01-02 06:00:00', 1, 133.33333333333331, 773.9752452587413, 9226.024754741258),
(263, 31, 2, 907.3085785920747, '2024-02-02 06:00:00', 1, 123.0136633965501, 784.2949151955246, 8441.729839545733),
(264, 31, 3, 907.3085785920747, '2024-03-02 06:00:00', 1, 112.55639786060976, 794.7521807314649, 7646.977658814268),
(265, 31, 4, 907.3085785920747, '2024-04-02 06:00:00', 1, 101.95970211752356, 805.3488764745512, 6841.628782339716),
(266, 31, 5, 907.3085785920747, '2024-05-02 06:00:00', 1, 91.22171709786288, 816.0868614942118, 6025.541920845504),
(267, 31, 6, 907.3085785920747, '2024-06-02 06:00:00', 1, 80.34055894460671, 826.9680196474679, 5198.573901198036),
(268, 31, 7, 907.3085785920747, '2024-07-02 06:00:00', 1, 69.31431868264048, 837.9942599094343, 4360.579641288601),
(269, 31, 8, 907.3085785920747, '2024-08-02 06:00:00', 1, 58.14106188384801, 849.1675167082267, 3511.4121245803744),
(270, 31, 9, 907.3085785920747, '2024-09-02 06:00:00', 1, 46.81882832773832, 860.4897502643364, 2650.9223743160383),
(271, 31, 10, 907.3085785920747, '2024-10-02 06:00:00', 1, 35.34563165754717, 871.9629469345275, 1778.9594273815107),
(272, 31, 11, 907.3085785920747, '2024-11-02 06:00:00', 1, 23.719459031753477, 883.5891195603213, 895.3703078211895),
(273, 31, 12, 907.3085785920747, '2024-12-02 06:00:00', 1, 11.938270770949192, 895.3703078211895, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `identificacion` int NOT NULL,
  `usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `apellido`, `identificacion`, `usuario`) VALUES
(22, 'admin', 'admin', 31, 24),
(23, 'admin', 'admin', 32, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion`
--

CREATE TABLE `identificacion` (
  `id` int NOT NULL,
  `numero` varchar(25) NOT NULL,
  `tipoIdentificacion` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `identificacion`
--

INSERT INTO `identificacion` (`id`, `numero`, `tipoIdentificacion`) VALUES
(1, '12345433', 1),
(2, '123456789', 1),
(3, '12345', 2),
(4, '12345', 1),
(5, '12345433', 2),
(6, '', 1),
(7, '12345433', 1),
(8, '', 1),
(9, '', 1),
(10, '', 1),
(11, '', 1),
(12, '12345', 3),
(13, '12345', 1),
(14, '000000000', 1),
(21, '12345', 1),
(22, '12345', 1),
(23, '12345', 1),
(24, '1234', 1),
(25, '12345', 1),
(26, '12345', 2),
(27, '000000000', 1),
(28, '12345', 1),
(29, '12345321', 1),
(30, '1234', 2),
(31, '2345454', 1),
(32, '000000000', 1),
(33, '134533221', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id` int NOT NULL,
  `codigo` varchar(7) NOT NULL,
  `montoPrestamo` double NOT NULL,
  `destinoPrestamo` int NOT NULL COMMENT '1-cultivo,2-personal,3-financiamiento',
  `tasaInteres` double(11,0) NOT NULL,
  `fechaInicio` date NOT NULL,
  `estadoPrestamo` int NOT NULL COMMENT '1-Activo, 2-Inactivo',
  `amortizacion` double NOT NULL,
  `socio` int NOT NULL,
  `plazo_anio` int NOT NULL,
  `plazo_cuota` int DEFAULT NULL COMMENT '1-mensual, 2-trimestral, 3-semestral',
  `saldo_pendiente` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id`, `codigo`, `montoPrestamo`, `destinoPrestamo`, `tasaInteres`, `fechaInicio`, `estadoPrestamo`, `amortizacion`, `socio`, `plazo_anio`, `plazo_cuota`, `saldo_pendiente`) VALUES
(27, 'ASCG100', 3000, 1, 10, '2023-12-09', 1, 0, 5, 5, 2, 0),
(28, 'BGHJ500', 3000, 1, 10, '2023-12-09', 1, 0, 5, 5, 2, 0),
(29, 'KPOI678', 3000, 1, 10, '2023-12-09', 1, 0, 5, 5, 3, 0),
(30, 'LLOP122', 1500, 3, 3, '2023-12-11', 1, 0, 5, 2, 3, 0),
(31, 'CVBN230', 10000, 2, 16, '2024-01-02', 1, 0, 5, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'Empleado'),
(2, 'Administrador'),
(3, 'Socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `identificacion` int NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `codigoSocio` varchar(50) NOT NULL,
  `usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `nombre`, `apellido`, `identificacion`, `direccion`, `telefono`, `codigoSocio`, `usuario`) VALUES
(5, 'Naydelin', 'Alvarado', 33, 'San vicente', '73118258', '2dlney', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoidentificacion`
--

CREATE TABLE `tipoidentificacion` (
  `id` int NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipoidentificacion`
--

INSERT INTO `tipoidentificacion` (`id`, `tipo`) VALUES
(1, 'DUI'),
(2, 'NIT'),
(3, 'Pasaporte'),
(4, 'Carnet de minoridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `foto` longblob,
  `rol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `foto`, `rol`) VALUES
(24, 'ever', 'kDxfjI5EIJQrV66ChiFG9A==', NULL, 1),
(25, 'admin', 'kDxfjI5EIJQrV66ChiFG9A==', NULL, 1),
(26, 'nay', '23897514', NULL, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuenta` (`prestamo`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identificacion` (`identificacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipoIdentificacion` (`tipoIdentificacion`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_socio` (`socio`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identificacion` (`identificacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `tipoidentificacion`
--
ALTER TABLE `tipoidentificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuota`
--
ALTER TABLE `cuota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipoidentificacion`
--
ALTER TABLE `tipoidentificacion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD CONSTRAINT `cuota_ibfk_1` FOREIGN KEY (`prestamo`) REFERENCES `prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`identificacion`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD CONSTRAINT `identificacion_ibfk_1` FOREIGN KEY (`tipoIdentificacion`) REFERENCES `tipoidentificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_socio` FOREIGN KEY (`socio`) REFERENCES `socio` (`id`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`identificacion`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `socio_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
