-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-07-2024 a las 22:31:39
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebas4416`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoría`
--

CREATE TABLE `Categoría` (
  `id_categoria` int NOT NULL,
  `nombre_categoria` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Categoría`
--

INSERT INTO `Categoría` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Red Conexión A'),
(2, 'Personal B'),
(3, 'Información Técnica C'),
(4, 'Madurez D'),
(5, 'Costo de Producción E'),
(6, 'Incentivo Fiscal F'),
(7, 'Opinión Comunidad G'),
(8, 'Financiamiento H'),
(9, 'Conciencia I'),
(10, 'Políticas J'),
(11, 'Cambios Gubernamentales K'),
(12, 'Pobreza L'),
(13, 'Capacitación M'),
(14, 'Comunicación N'),
(15, 'Conflicto Poder O'),
(16, 'Interés Social P'),
(17, 'Cultura Q_R');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Encuesta`
--

CREATE TABLE `Encuesta` (
  `id_encuesta` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Factor`
--

CREATE TABLE `Factor` (
  `id_factor` int NOT NULL,
  `nombre_factor` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `contenido_factor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Factor`
--

INSERT INTO `Factor` (`id_factor`, `nombre_factor`, `contenido_factor`) VALUES
(1, 'FACTOR A', 'Falta de redes de transmisión eléctrica en zonas con potencial de producción de energías renovables.'),
(2, 'FACTOR B', 'Falta de personal formado en el desarrollo e implantación de proyectos de energías renovables.'),
(3, 'FACTOR C', 'Falta de información técnica para el desarrollo y la ejecución de proyectos de energías renovables.'),
(4, 'FACTOR D', 'Falta de diversificación de las energías renovables debido a la madurez de cada tecnología'),
(5, 'FACTOR E', 'Costo elevado de la generación de energía renovable en comparación con los costes de producción de la energía convencional.'),
(6, 'FACTOR F', 'Falta de promoción de incentivos fiscales para invertir en tecnologías de energías renovables'),
(7, 'FACTOR G', 'No tener en cuenta a las personas de las comunidades locales'),
(8, 'FACTOR H', 'Falta de subvenciones para financiar las energías renovables en comparación con las fuentes tradicionales'),
(9, 'FACTOR I', 'Falta de concienciación entre los usuarios potenciales de la tecnología debido a que las empresas dedican poco tiempo a concientizar'),
(10, 'FACTOR J', 'Política energética basada en los combustibles fósiles'),
(11, 'FACTOR K', 'Cambios en el gobierno y en las políticas gubernamentales'),
(12, 'FACTOR L', 'Los ingresos económicos y la pobreza de la población impiden la implantación de energías renovables'),
(13, 'FACTOR M', 'Falta de programas formales de formación para personas en este campo'),
(14, 'FACTOR N', 'Poca comunicación entre el gobierno, el sector privado y el sector público'),
(15, 'FACTOR O', 'En ausencia de gobernanza, el poder se ejerce para poner en marcha proyectos de energías renovables, sin tener en cuenta el contexto sociocultural, generando conflictos y nuevos poderes.'),
(16, 'FACTOR P', 'Escasa participación e interés de la sociedad debido a la incipiente información sobre proyectos de energías renovables'),
(17, 'FACTOR Q', 'La cultura mexicana no valora los beneficios medioambientales de las energías renovables tanto como otros países.'),
(18, 'FACTOR R', 'Cambio de uso del suelo, fragmentación del paisaje y posibles alteraciones de la fauna y la flora.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Respuesta`
--

CREATE TABLE `Respuesta` (
  `id_respuesta` int NOT NULL,
  `id_encuesta` int DEFAULT NULL,
  `id_factor_1` int DEFAULT NULL,
  `id_factor_2` int DEFAULT NULL,
  `factor_dominante` int NOT NULL,
  `porcentaje_incidencia` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sector`
--

CREATE TABLE `Sector` (
  `id_sector` int NOT NULL,
  `nombre_sector` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Sector`
--

INSERT INTO `Sector` (`id_sector`, `nombre_sector`) VALUES
(1, 'admon'),
(2, 'Gubernamental'),
(3, 'Académico'),
(4, 'Empresa de energía renovable'),
(5, 'Usuario de la tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `id_usuario` int NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `id_sector` int DEFAULT NULL,
  `check_respuesta` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `usuario`, `password`, `id_sector`, `check_respuesta`) VALUES
(1, 'Master', '$2y$10$bJ/rm95QqhDm1bhJ1Rde8uL3VbFkNhil1bjegJmQHQiDnM2cr9a4S', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Categoría`
--
ALTER TABLE `Categoría`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `Encuesta`
--
ALTER TABLE `Encuesta`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `Factor`
--
ALTER TABLE `Factor`
  ADD PRIMARY KEY (`id_factor`);

--
-- Indices de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_encuesta` (`id_encuesta`),
  ADD KEY `id_factor_1` (`id_factor_1`),
  ADD KEY `id_factor_2` (`id_factor_2`),
  ADD KEY `factor_dominante` (`factor_dominante`);

--
-- Indices de la tabla `Sector`
--
ALTER TABLE `Sector`
  ADD PRIMARY KEY (`id_sector`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_sector` (`id_sector`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Categoría`
--
ALTER TABLE `Categoría`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `Encuesta`
--
ALTER TABLE `Encuesta`
  MODIFY `id_encuesta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Factor`
--
ALTER TABLE `Factor`
  MODIFY `id_factor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  MODIFY `id_respuesta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Sector`
--
ALTER TABLE `Sector`
  MODIFY `id_sector` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Encuesta`
--
ALTER TABLE `Encuesta`
  ADD CONSTRAINT `Encuesta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`),
  ADD CONSTRAINT `Encuesta_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `Categoría` (`id_categoria`);

--
-- Filtros para la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  ADD CONSTRAINT `Respuesta_ibfk_1` FOREIGN KEY (`id_encuesta`) REFERENCES `Encuesta` (`id_encuesta`),
  ADD CONSTRAINT `Respuesta_ibfk_2` FOREIGN KEY (`id_factor_1`) REFERENCES `Factor` (`id_factor`),
  ADD CONSTRAINT `Respuesta_ibfk_3` FOREIGN KEY (`id_factor_2`) REFERENCES `Factor` (`id_factor`),
  ADD CONSTRAINT `Respuesta_ibfk_4` FOREIGN KEY (`factor_dominante`) REFERENCES `Factor` (`id_factor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`id_sector`) REFERENCES `Sector` (`id_sector`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
