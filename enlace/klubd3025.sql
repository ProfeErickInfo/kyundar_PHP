-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2025 a las 18:07:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `klubd3025`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_almacenes`
--

CREATE TABLE `trn25_almacenes` (
  `id_almacen` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ubicacion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_categorias`
--

CREATE TABLE `trn25_categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_clase_disciplina`
--

CREATE TABLE `trn25_clase_disciplina` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `trn25_clase_disciplina`
--

INSERT INTO `trn25_clase_disciplina` (`id`, `nombre`) VALUES
(1, 'Olímpico'),
(2, 'Paralímpica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_clientes`
--

CREATE TABLE `trn25_clientes` (
  `id_cliente` bigint(20) NOT NULL,
  `tipo` enum('socio','externo') NOT NULL DEFAULT 'externo',
  `referencia_socio` bigint(20) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `documento` varchar(64) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_compras`
--

CREATE TABLE `trn25_compras` (
  `id_compra` bigint(20) NOT NULL,
  `numero_documento` varchar(128) DEFAULT NULL,
  `id_proveedor` bigint(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `id_almacen` bigint(20) DEFAULT NULL,
  `estado` enum('borrador','confirmado','anulado','cerrado') DEFAULT 'borrador',
  `subtotal` decimal(14,2) DEFAULT 0.00,
  `impuestos` decimal(14,2) DEFAULT 0.00,
  `total` decimal(14,2) DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `created_by` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_compras_items`
--

CREATE TABLE `trn25_compras_items` (
  `id_compra_item` bigint(20) NOT NULL,
  `id_compra` bigint(20) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `cantidad` decimal(14,3) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) DEFAULT 0.00,
  `impuesto` decimal(12,2) DEFAULT 0.00,
  `subtotal` decimal(14,2) DEFAULT NULL,
  `id_almacen` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `trn25_compras_items`
--
DELIMITER $$
CREATE TRIGGER `trn25_after_insert_compra_item` AFTER INSERT ON `trn25_compras_items` FOR EACH ROW BEGIN
  DECLARE v_almacen BIGINT;
  IF NEW.id_almacen IS NULL THEN
    SELECT id_almacen INTO v_almacen FROM trn25_compras WHERE id_compra = NEW.id_compra LIMIT 1;
  ELSE
    SET v_almacen = NEW.id_almacen;
  END IF;

  -- Insertar o actualizar inventario con costo promedio
  INSERT INTO trn25_inventario (id_producto, id_almacen, cantidad, costo_promedio, updated_at)
  VALUES (NEW.id_producto, v_almacen, NEW.cantidad, NEW.precio_unitario, NOW())
  ON DUPLICATE KEY UPDATE
    cantidad = cantidad + VALUES(cantidad),
    costo_promedio = CASE
      WHEN (cantidad + VALUES(cantidad)) <> 0
        THEN ((costo_promedio * cantidad) + (VALUES(costo_promedio) * VALUES(cantidad))) / (cantidad + VALUES(cantidad))
      ELSE VALUES(costo_promedio)
    END,
    updated_at = NOW();

  -- Registrar movimiento
  INSERT INTO trn25_stock_movimientos (id_producto, id_almacen, tipo, referencia_tipo, referencia_id, cantidad, costo_unitario, fecha, usuario)
  VALUES (NEW.id_producto, v_almacen, 'entrada', 'compra', NEW.id_compra, NEW.cantidad, NEW.precio_unitario, NOW(), CURRENT_USER());

  -- Actualizar totales de la compra
  UPDATE trn25_compras
    SET subtotal = COALESCE((SELECT SUM(COALESCE(subtotal, cantidad * precio_unitario - COALESCE(descuento,0))) FROM trn25_compras_items WHERE id_compra = NEW.id_compra),0),
        impuestos = 0,
        total = COALESCE((SELECT SUM(COALESCE(subtotal, cantidad * precio_unitario - COALESCE(descuento,0))) FROM trn25_compras_items WHERE id_compra = NEW.id_compra),0)
  WHERE id_compra = NEW.id_compra;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_departamentos`
--

CREATE TABLE `trn25_departamentos` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `codigo` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_descuentox`
--

CREATE TABLE `trn25_descuentox` (
  `id` bigint(20) NOT NULL,
  `id_club` bigint(20) NOT NULL DEFAULT 0,
  `id_Dep` bigint(20) NOT NULL DEFAULT 0,
  `valor` float NOT NULL DEFAULT 0,
  `Minicio` int(2) NOT NULL DEFAULT 0,
  `Mfin` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_disciplinas`
--

CREATE TABLE `trn25_disciplinas` (
  `id` bigint(20) NOT NULL,
  `id_tipo` bigint(20) NOT NULL DEFAULT 1,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `trn25_disciplinas`
--

INSERT INTO `trn25_disciplinas` (`id`, `id_tipo`, `nombre`, `descripcion`) VALUES
(1, 1, 'Taekwondo', 'Arte Marcial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_ecivil`
--

CREATE TABLE `trn25_ecivil` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_genero`
--

CREATE TABLE `trn25_genero` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_infoxpeso`
--

CREATE TABLE `trn25_infoxpeso` (
  `id` bigint(20) NOT NULL,
  `id_deportista` bigint(20) NOT NULL,
  `info` float NOT NULL DEFAULT 0,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_inventario`
--

CREATE TABLE `trn25_inventario` (
  `id_inventario` bigint(20) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `id_almacen` bigint(20) DEFAULT NULL,
  `cantidad` decimal(14,3) DEFAULT 0.000,
  `cantidad_minima` decimal(14,3) DEFAULT 0.000,
  `cantidad_maxima` decimal(14,3) DEFAULT NULL,
  `costo_promedio` decimal(12,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_lista_barrios`
--

CREATE TABLE `trn25_lista_barrios` (
  `id` int(5) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `localidad` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_municipios`
--

CREATE TABLE `trn25_municipios` (
  `id` bigint(20) NOT NULL,
  `departamento_id` bigint(20) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_nsocios`
--

CREATE TABLE `trn25_nsocios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero_socio` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `numero_documento` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  `ocupacion` varchar(100) DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `foto_perfil` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_organizacion`
--

CREATE TABLE `trn25_organizacion` (
  `id` bigint(20) NOT NULL,
  `id_liga` bigint(20) NOT NULL DEFAULT 1,
  `id_instituto` bigint(20) NOT NULL DEFAULT 1,
  `id_disciplina` bigint(20) NOT NULL DEFAULT 1,
  `nombre` varchar(200) DEFAULT NULL,
  `id_municipio` bigint(20) DEFAULT 1,
  `id_barrio` bigint(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `entrenador` varchar(250) DEFAULT 'No presenta',
  `telefono` bigint(14) DEFAULT NULL,
  `representante` varchar(250) DEFAULT 'No Aplica',
  `cel` bigint(14) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `escudo` varchar(200) DEFAULT 'escudo.jpg',
  `valinscripcion` bigint(10) NOT NULL DEFAULT 30000,
  `valmes` bigint(10) NOT NULL DEFAULT 85000,
  `fec_reg` date DEFAULT NULL,
  `tipo_U` int(2) DEFAULT NULL COMMENT '1=Club - 2=socio - 3=liga - 4= federación - 5= institucional - 6= Administrador'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_paises`
--

CREATE TABLE `trn25_paises` (
  `id` bigint(20) NOT NULL,
  `nombre` text NOT NULL,
  `codigo_iso3` varchar(4) NOT NULL DEFAULT 'NA',
  `zona` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_productos`
--

CREATE TABLE `trn25_productos` (
  `id_producto` bigint(20) NOT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `unidad_medida` varchar(32) DEFAULT NULL,
  `precio_costo` decimal(12,2) DEFAULT NULL,
  `precio_venta` decimal(12,2) DEFAULT NULL,
  `tasa_iva` decimal(5,2) DEFAULT 0.00,
  `codigo_barra` varchar(128) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(128) DEFAULT NULL,
  `updated_by` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_proveedores`
--

CREATE TABLE `trn25_proveedores` (
  `id_proveedor` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `identificacion` varchar(64) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `contacto_nombre` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_reg_abono`
--

CREATE TABLE `trn25_reg_abono` (
  `id` bigint(20) NOT NULL,
  `id_club` bigint(20) NOT NULL,
  `id_socio` bigint(20) NOT NULL,
  `mes` int(2) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  `valor` int(6) NOT NULL,
  `saldo` bigint(10) NOT NULL DEFAULT 0,
  `periodo` int(4) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_reg_egreso`
--

CREATE TABLE `trn25_reg_egreso` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `creado_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_reg_pago`
--

CREATE TABLE `trn25_reg_pago` (
  `id` bigint(20) NOT NULL,
  `id_club` bigint(20) NOT NULL,
  `id_socio` bigint(20) NOT NULL,
  `mes` int(2) NOT NULL,
  `tipo_pago` int(1) NOT NULL DEFAULT 1,
  `valor` int(6) NOT NULL,
  `periodo` int(4) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_socios`
--

CREATE TABLE `trn25_socios` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL COMMENT 'campo que asigna el id del socio.',
  `id_Club` bigint(20) DEFAULT 0,
  `cod_int` bigint(20) UNSIGNED ZEROFILL DEFAULT 00000000000000000000,
  `nombres` varchar(255) DEFAULT NULL COMMENT 'campo que recibe los nomnbres del alumno',
  `apellidos` varchar(255) DEFAULT NULL COMMENT 'campo que recibe los apellidos del alumno.',
  `film` varchar(250) DEFAULT '0.png',
  `fecha_nac` date DEFAULT current_timestamp() COMMENT 'campo que recibe la fecha de nacimiento del alumno.',
  `lugar_nac` int(11) DEFAULT 0 COMMENT 'campo que recibe el lugar de nacimiento del alumno.',
  `sexo` int(11) DEFAULT 0 COMMENT 'campo que recibe el sexo del alumno.',
  `edad` int(3) UNSIGNED ZEROFILL DEFAULT 000 COMMENT 'campo que recibe y/o calcula la edad del alumno.',
  `tipo_doc` int(3) UNSIGNED ZEROFILL DEFAULT 000 COMMENT 'campo que recibe el id del tipo de documento del alumno.',
  `documento` varchar(50) DEFAULT '0' COMMENT 'campo que recibe el numero del documento del alumno',
  `email` varchar(255) DEFAULT 'ninguno@ninguno.com' COMMENT 'campo que recibe el email del alumno.',
  `tipo_lugar` int(1) DEFAULT 2,
  `barrio` varchar(60) DEFAULT '0' COMMENT 'campo que recibe el nombre del barrio donde recide el alumno',
  `direccion` varchar(255) DEFAULT 'NINGUNO' COMMENT 'campo que recibe la direccion donde recide el alumno.',
  `servsalud` int(4) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'campo que recibeel tipo de servicio de salud',
  `celular` int(15) UNSIGNED ZEROFILL DEFAULT 000000000000000 COMMENT 'campo que recibe el numero del celular del alumno.',
  `tipo_socio` int(2) DEFAULT 1,
  `responsable` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoDoc` int(3) DEFAULT NULL,
  `docRes` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(2) UNSIGNED ZEROFILL DEFAULT 01 COMMENT 'campo que recibe [0] =Inactivo, [1]=Activo,[2]=Egresado',
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_edit` date DEFAULT NULL,
  `nombreEps` varchar(100) DEFAULT NULL COMMENT 'campo para guardar la eps',
  `ano_lectivo` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `id_grado` int(4) DEFAULT 1,
  `peso` float DEFAULT 0,
  `id_cat` int(4) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla que almacena a los alumnos matriculados.';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_ssalud`
--

CREATE TABLE `trn25_ssalud` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `trn25_ssalud`
--

INSERT INTO `trn25_ssalud` (`id`, `nombre`, `detalle`) VALUES
(1, 'Sisben', 'Sisben'),
(2, 'EPS', 'EPS'),
(3, 'Pre-Pagada', 'Pre-Pagada'),
(4, 'Sin Definir', 'Sin Definir');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_stock_movimientos`
--

CREATE TABLE `trn25_stock_movimientos` (
  `id_movimiento` bigint(20) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `id_almacen` bigint(20) DEFAULT NULL,
  `tipo` enum('entrada','salida','ajuste','transferencia') NOT NULL,
  `referencia_tipo` varchar(50) DEFAULT NULL,
  `referencia_id` bigint(20) DEFAULT NULL,
  `cantidad` decimal(14,3) NOT NULL,
  `costo_unitario` decimal(12,2) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_tipouxer`
--

CREATE TABLE `trn25_tipouxer` (
  `id` bigint(5) NOT NULL,
  `codtipo` int(1) NOT NULL COMMENT '1=Club - 2=socio - 3=liga - 4= federación - 5= institucional - 6= Administrador ',
  `detalle` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `caracter` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_tipo_disciplina`
--

CREATE TABLE `trn25_tipo_disciplina` (
  `id` bigint(20) NOT NULL,
  `id_clase` bigint(20) NOT NULL DEFAULT 1,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_tipo_documento`
--

CREATE TABLE `trn25_tipo_documento` (
  `id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 1,
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'campo que recibe la descripcion del tipo de documento.',
  `sigla` varchar(3) DEFAULT NULL COMMENT 'campo que recibe la sigla del tipo de documento.',
  `id_usuario` bigint(20) NOT NULL,
  `fecha_edit` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla que almacena el tipo de documento.';



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_tipo_socio`
--

CREATE TABLE `trn25_tipo_socio` (
  `id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 1,
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'campo que recibe la descripcion del tipo de documento.',
  `sigla` varchar(3) DEFAULT NULL COMMENT 'campo que recibe la sigla del tipo de documento.',
  `id_usuario` bigint(20) NOT NULL,
  `fecha_edit` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla que almacena el tipo de documento.';



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_ventas`
--

CREATE TABLE `trn25_ventas` (
  `id_venta` bigint(20) NOT NULL,
  `numero_documento` varchar(128) DEFAULT NULL,
  `id_cliente` bigint(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_almacen` bigint(20) DEFAULT NULL,
  `estado` enum('borrador','confirmado','anulado','cerrado') DEFAULT 'borrador',
  `subtotal` decimal(14,2) DEFAULT 0.00,
  `impuestos` decimal(14,2) DEFAULT 0.00,
  `total` decimal(14,2) DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `created_by` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn25_ventas_items`
--

CREATE TABLE `trn25_ventas_items` (
  `id_venta_item` bigint(20) NOT NULL,
  `id_venta` bigint(20) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `cantidad` decimal(14,3) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) DEFAULT 0.00,
  `impuesto` decimal(12,2) DEFAULT 0.00,
  `subtotal` decimal(14,2) DEFAULT NULL,
  `id_almacen` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `trn25_ventas_items`
--
DELIMITER $$
CREATE TRIGGER `trn25_after_insert_venta_item` AFTER INSERT ON `trn25_ventas_items` FOR EACH ROW BEGIN
  DECLARE v_almacen BIGINT;
  IF NEW.id_almacen IS NULL THEN
    SELECT id_almacen INTO v_almacen FROM trn25_ventas WHERE id_venta = NEW.id_venta LIMIT 1;
  ELSE
    SET v_almacen = NEW.id_almacen;
  END IF;

  -- Intentar actualizar inventario (restar)
  UPDATE trn25_inventario
    SET cantidad = cantidad - NEW.cantidad,
        updated_at = NOW()
    WHERE id_producto = NEW.id_producto AND (id_almacen <=> v_almacen);

  -- Si no existe fila en inventario, insertar registro con cantidad negativa
  IF ROW_COUNT() = 0 THEN
    INSERT INTO trn25_inventario (id_producto, id_almacen, cantidad, updated_at)
    VALUES (NEW.id_producto, v_almacen, -NEW.cantidad, NOW());
  END IF;

  -- Registrar movimiento
  INSERT INTO trn25_stock_movimientos (id_producto, id_almacen, tipo, referencia_tipo, referencia_id, cantidad, costo_unitario, fecha, usuario)
  VALUES (NEW.id_producto, v_almacen, 'salida', 'venta', NEW.id_venta, NEW.cantidad, NEW.precio_unitario, NOW(), CURRENT_USER());

  -- Actualizar totales de la venta
  UPDATE trn25_ventas
    SET subtotal = COALESCE((SELECT SUM(COALESCE(subtotal, cantidad * precio_unitario - COALESCE(descuento,0))) FROM trn25_ventas_items WHERE id_venta = NEW.id_venta),0),
        impuestos = 0,
        total = COALESCE((SELECT SUM(COALESCE(subtotal, cantidad * precio_unitario - COALESCE(descuento,0))) FROM trn25_ventas_items WHERE id_venta = NEW.id_venta),0)
  WHERE id_venta = NEW.id_venta;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wx25_usu`
--

CREATE TABLE `wx25_usu` (
  `id` bigint(20) NOT NULL,
  `tipoU` int(2) NOT NULL DEFAULT 1 COMMENT '1=Club - 2=socio - 3=liga - 4= federación - 5= institucional - 6= Administrador',
  `id_asocc` bigint(20) NOT NULL COMMENT 'id asociado del club o del invitado',
  `nickz` varchar(50) NOT NULL,
  `pazz` varchar(50) NOT NULL,
  `fec_reg` date NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `trn25_almacenes`
--
ALTER TABLE `trn25_almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `trn25_categorias`
--
ALTER TABLE `trn25_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_clase_disciplina`
--
ALTER TABLE `trn25_clase_disciplina`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_clientes`
--
ALTER TABLE `trn25_clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `trn25_clientes_nombre_idx` (`nombre`);

--
-- Indices de la tabla `trn25_compras`
--
ALTER TABLE `trn25_compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_almacen` (`id_almacen`),
  ADD KEY `trn25_compras_proveedor_idx` (`id_proveedor`);

--
-- Indices de la tabla `trn25_compras_items`
--
ALTER TABLE `trn25_compras_items`
  ADD PRIMARY KEY (`id_compra_item`),
  ADD KEY `fk_compra_item_producto` (`id_producto`),
  ADD KEY `fk_compra_item_almacen` (`id_almacen`),
  ADD KEY `trn25_compras_items_compra_idx` (`id_compra`);

--
-- Indices de la tabla `trn25_departamentos`
--
ALTER TABLE `trn25_departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_descuentox`
--
ALTER TABLE `trn25_descuentox`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_disciplinas`
--
ALTER TABLE `trn25_disciplinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_ecivil`
--
ALTER TABLE `trn25_ecivil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_genero`
--
ALTER TABLE `trn25_genero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_infoxpeso`
--
ALTER TABLE `trn25_infoxpeso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_inventario`
--
ALTER TABLE `trn25_inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD UNIQUE KEY `ux_trn25_inventario_producto_almacen` (`id_producto`,`id_almacen`),
  ADD KEY `fk_inv_almacen` (`id_almacen`),
  ADD KEY `trn25_inventario_prod_alm_idx` (`id_producto`,`id_almacen`);

--
-- Indices de la tabla `trn25_lista_barrios`
--
ALTER TABLE `trn25_lista_barrios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_municipios`
--
ALTER TABLE `trn25_municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- Indices de la tabla `trn25_nsocios`
--
ALTER TABLE `trn25_nsocios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_socio` (`numero_socio`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`);

--
-- Indices de la tabla `trn25_organizacion`
--
ALTER TABLE `trn25_organizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_paises`
--
ALTER TABLE `trn25_paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_productos`
--
ALTER TABLE `trn25_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `trn25_productos_nombre_idx` (`nombre`);

--
-- Indices de la tabla `trn25_proveedores`
--
ALTER TABLE `trn25_proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `trn25_reg_abono`
--
ALTER TABLE `trn25_reg_abono`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_reg_egreso`
--
ALTER TABLE `trn25_reg_egreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trn25_egreso_categoria` (`categoria_id`);

--
-- Indices de la tabla `trn25_reg_pago`
--
ALTER TABLE `trn25_reg_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_socios`
--
ALTER TABLE `trn25_socios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grado` (`nombreEps`),
  ADD KEY `genero` (`sexo`);

--
-- Indices de la tabla `trn25_ssalud`
--
ALTER TABLE `trn25_ssalud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_stock_movimientos`
--
ALTER TABLE `trn25_stock_movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `fk_mov_almacen` (`id_almacen`),
  ADD KEY `trn25_stock_movimientos_prod_idx` (`id_producto`);

--
-- Indices de la tabla `trn25_tipouxer`
--
ALTER TABLE `trn25_tipouxer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_tipo_disciplina`
--
ALTER TABLE `trn25_tipo_disciplina`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trn25_tipo_documento`
--
ALTER TABLE `trn25_tipo_documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`,`fecha_edit`);

--
-- Indices de la tabla `trn25_tipo_socio`
--
ALTER TABLE `trn25_tipo_socio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`,`fecha_edit`);

--
-- Indices de la tabla `trn25_ventas`
--
ALTER TABLE `trn25_ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_venta_almacen` (`id_almacen`),
  ADD KEY `trn25_ventas_cliente_idx` (`id_cliente`);

--
-- Indices de la tabla `trn25_ventas_items`
--
ALTER TABLE `trn25_ventas_items`
  ADD PRIMARY KEY (`id_venta_item`),
  ADD KEY `fk_venta_item_producto` (`id_producto`),
  ADD KEY `fk_venta_item_almacen` (`id_almacen`),
  ADD KEY `trn25_ventas_items_venta_idx` (`id_venta`);

--
-- Indices de la tabla `wx25_usu`
--
ALTER TABLE `wx25_usu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `trn25_almacenes`
--
ALTER TABLE `trn25_almacenes`
  MODIFY `id_almacen` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_categorias`
--
ALTER TABLE `trn25_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_clase_disciplina`
--
ALTER TABLE `trn25_clase_disciplina`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trn25_clientes`
--
ALTER TABLE `trn25_clientes`
  MODIFY `id_cliente` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_compras`
--
ALTER TABLE `trn25_compras`
  MODIFY `id_compra` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_compras_items`
--
ALTER TABLE `trn25_compras_items`
  MODIFY `id_compra_item` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_departamentos`
--
ALTER TABLE `trn25_departamentos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `trn25_descuentox`
--
ALTER TABLE `trn25_descuentox`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `trn25_disciplinas`
--
ALTER TABLE `trn25_disciplinas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `trn25_ecivil`
--
ALTER TABLE `trn25_ecivil`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `trn25_genero`
--
ALTER TABLE `trn25_genero`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trn25_infoxpeso`
--
ALTER TABLE `trn25_infoxpeso`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `trn25_inventario`
--
ALTER TABLE `trn25_inventario`
  MODIFY `id_inventario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_lista_barrios`
--
ALTER TABLE `trn25_lista_barrios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `trn25_municipios`
--
ALTER TABLE `trn25_municipios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1127;

--
-- AUTO_INCREMENT de la tabla `trn25_nsocios`
--
ALTER TABLE `trn25_nsocios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_organizacion`
--
ALTER TABLE `trn25_organizacion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT de la tabla `trn25_paises`
--
ALTER TABLE `trn25_paises`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `trn25_productos`
--
ALTER TABLE `trn25_productos`
  MODIFY `id_producto` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_proveedores`
--
ALTER TABLE `trn25_proveedores`
  MODIFY `id_proveedor` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `trn25_reg_abono`
--
ALTER TABLE `trn25_reg_abono`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `trn25_reg_egreso`
--
ALTER TABLE `trn25_reg_egreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_reg_pago`
--
ALTER TABLE `trn25_reg_pago`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `trn25_socios`
--
ALTER TABLE `trn25_socios`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'campo que asigna el id del socio.', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `trn25_ssalud`
--
ALTER TABLE `trn25_ssalud`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `trn25_stock_movimientos`
--
ALTER TABLE `trn25_stock_movimientos`
  MODIFY `id_movimiento` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_tipouxer`
--
ALTER TABLE `trn25_tipouxer`
  MODIFY `id` bigint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `trn25_tipo_disciplina`
--
ALTER TABLE `trn25_tipo_disciplina`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trn25_tipo_documento`
--
ALTER TABLE `trn25_tipo_documento`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `trn25_tipo_socio`
--
ALTER TABLE `trn25_tipo_socio`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trn25_ventas`
--
ALTER TABLE `trn25_ventas`
  MODIFY `id_venta` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trn25_ventas_items`
--
ALTER TABLE `trn25_ventas_items`
  MODIFY `id_venta_item` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `wx25_usu`
--
ALTER TABLE `wx25_usu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `trn25_compras`
--
ALTER TABLE `trn25_compras`
  ADD CONSTRAINT `fk_compra_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_compra_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `trn25_proveedores` (`id_proveedor`) ON DELETE SET NULL;

--
-- Filtros para la tabla `trn25_compras_items`
--
ALTER TABLE `trn25_compras_items`
  ADD CONSTRAINT `fk_compra_item_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_compra_item_compra` FOREIGN KEY (`id_compra`) REFERENCES `trn25_compras` (`id_compra`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_compra_item_producto` FOREIGN KEY (`id_producto`) REFERENCES `trn25_productos` (`id_producto`);

--
-- Filtros para la tabla `trn25_inventario`
--
ALTER TABLE `trn25_inventario`
  ADD CONSTRAINT `fk_inv_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_inv_producto` FOREIGN KEY (`id_producto`) REFERENCES `trn25_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `trn25_reg_egreso`
--
ALTER TABLE `trn25_reg_egreso`
  ADD CONSTRAINT `fk_trn25_egreso_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `trn25_categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `trn25_stock_movimientos`
--
ALTER TABLE `trn25_stock_movimientos`
  ADD CONSTRAINT `fk_mov_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mov_producto` FOREIGN KEY (`id_producto`) REFERENCES `trn25_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `trn25_ventas`
--
ALTER TABLE `trn25_ventas`
  ADD CONSTRAINT `fk_venta_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `trn25_clientes` (`id_cliente`) ON DELETE SET NULL;

--
-- Filtros para la tabla `trn25_ventas_items`
--
ALTER TABLE `trn25_ventas_items`
  ADD CONSTRAINT `fk_venta_item_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `trn25_almacenes` (`id_almacen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_venta_item_producto` FOREIGN KEY (`id_producto`) REFERENCES `trn25_productos` (`id_producto`),
  ADD CONSTRAINT `fk_venta_item_venta` FOREIGN KEY (`id_venta`) REFERENCES `trn25_ventas` (`id_venta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
