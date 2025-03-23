-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-03-2025 a las 04:46:51
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
-- Base de datos: `tecnofutura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `ID_Administrador` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Contrasena` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `ID_Carrito` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Producto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito_compras`
--

INSERT INTO `carrito_compras` (`ID_Carrito`, `ID_Cliente`, `ID_Producto`, `Cantidad`) VALUES
(11, 7, 1, 1),
(12, 7, 34, 1),
(45, 10, 6, 1),
(46, 10, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`ID_Categoria`, `Nombre`) VALUES
(1, 'Teléfonos'),
(2, 'Cómputo'),
(3, 'Televisores'),
(4, 'Audio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Edad` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `Nombre`, `Correo`, `Telefono`, `Contrasena`, `Edad`) VALUES
(5, 'Super', 'su@gmail.com', '9811001100', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 19),
(6, 'Manuel', 'davidcblanco10pro@gmail.com', '9811001400', '474b236db97417c741846c97b6e453cff88d11a3efdbe9434c4e6ff014deb6ca', 22),
(7, 'David Jesus Castro Escalante', 'taz@gmail.com', '9812049123', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 43),
(8, 'Administración', 'administrador@gmail.com', '9811001400', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 22),
(10, 'Max', 'bmdp149@hotmail.com', '123456789', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
  `ID_DetallePedido` int(11) NOT NULL,
  `ID_Estado` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Metodo` int(11) NOT NULL,
  `ID_Direccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`ID_DetallePedido`, `ID_Estado`, `ID_Producto`, `Cantidad`, `ID_Cliente`, `ID_Metodo`, `ID_Direccion`) VALUES
(20, 1, 6, 1, 5, 11, 3),
(21, 1, 8, 1, 5, 11, 3),
(22, 1, 11, 1, 5, 11, 3),
(23, 1, 14, 1, 5, 11, 3),
(24, 1, 1, 1, 5, 11, 3),
(25, 1, 1, 1, 5, 11, 3),
(29, 1, 10, 1, 5, 16, 3),
(30, 1, 4, 1, 5, 16, 3),
(31, 1, 8, 1, 5, 16, 3),
(32, 1, 6, 1, 5, 16, 3),
(33, 1, 9, 1, 5, 15, 3),
(34, 1, 8, 2, 5, 16, 3),
(35, 1, 14, 2, 5, 16, 3),
(36, 1, 4, 1, 5, 16, 3),
(37, 1, 10, 1, 5, 15, 3),
(38, 1, 28, 1, 5, 16, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `ID_Direccion` int(11) NOT NULL,
  `Calle` varchar(150) NOT NULL,
  `NumExt` int(100) NOT NULL,
  `NumInt` int(100) DEFAULT NULL,
  `Entrecalles` varchar(200) NOT NULL,
  `NumContacto` varchar(15) NOT NULL,
  `Colonia` varchar(100) NOT NULL,
  `ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`ID_Direccion`, `Calle`, `NumExt`, `NumInt`, `Entrecalles`, `NumContacto`, `Colonia`, `ID_Cliente`) VALUES
(3, '123', 12, 0, '456', '987654321', 'COLIONITA', 5),
(9, '345', 456, 45, '4', '456789', 'MaxitoPrueba3', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedidos`
--

CREATE TABLE `estado_pedidos` (
  `ID_Estado` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_pedidos`
--

INSERT INTO `estado_pedidos` (`ID_Estado`, `Descripcion`) VALUES
(1, 'EN PROCESO'),
(2, 'ENVIADO'),
(3, 'RECIBIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_soporte`
--

CREATE TABLE `estado_soporte` (
  `ID_estado_soporte` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_soporte`
--

INSERT INTO `estado_soporte` (`ID_estado_soporte`, `Nombre`) VALUES
(1, 'Finalizada'),
(2, 'Cancelada'),
(3, 'En Proceso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `ID_Marca` int(11) NOT NULL,
  `Marca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`ID_Marca`, `Marca`) VALUES
(1, 'Samsung'),
(2, 'Sony'),
(3, 'MSI'),
(4, 'Apple'),
(5, 'JBL'),
(6, 'PC\'s'),
(7, 'Xiaomi'),
(8, 'OnePlus'),
(9, 'HP'),
(10, 'DELL'),
(11, 'Lenovo'),
(12, 'Asus'),
(13, 'Acer'),
(14, 'HyperX'),
(15, 'Corsair'),
(16, 'Arctis'),
(17, 'Razer'),
(18, 'Logitech'),
(19, 'Bose'),
(20, 'Sennheiser'),
(21, 'Technica'),
(22, 'TCL'),
(23, 'LG'),
(24, 'Vizio'),
(25, 'Hisense'),
(26, 'Toshiba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodospagos`
--

CREATE TABLE `metodospagos` (
  `ID_Metodo` int(11) NOT NULL,
  `Titular` varchar(100) NOT NULL,
  `Numeros` varchar(255) NOT NULL,
  `CVV` int(3) NOT NULL,
  `MyA` varchar(10) NOT NULL,
  `ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodospagos`
--

INSERT INTO `metodospagos` (`ID_Metodo`, `Titular`, `Numeros`, `CVV`, `MyA`, `ID_Cliente`) VALUES
(10, 'Manuel David Castro Blanco', '1234678923457890', 234, '12-2026', 7),
(11, 'Manuel David Castro Blanco', '1234678901294567', 123, '03-2028', 5),
(15, 'MaxitoPrueba', '1234567890123456', 0, '12-2030', 5),
(16, 'MaxitoPrueba2', '1234567890123456', 0, '12-2025', 5),
(17, 'Max', '1234567890123456', 123, '01-2026', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` int(255) NOT NULL,
  `Stock` int(11) NOT NULL,
  `ID_Categoria` int(11) NOT NULL,
  `ID_Marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Producto`, `Nombre`, `Descripcion`, `Precio`, `Stock`, `ID_Categoria`, `ID_Marca`) VALUES
(1, 'iPhone 15 Pro Max', 'El iPhone 15 Pro Max tiene una pantalla de 6.7 pulgadas, chip A17 Pro y un diseño elegante de titanio.', 29000, 200, 1, 4),
(2, 'JBL TUNE 520', 'El JBL TUNE 520BT son audífonos inalámbricos con JBL Pure Bass y gran calidad de sonido y comodidad.', 750, 200, 4, 5),
(3, 'Samsung TV 50 4K', 'El Samsung TV 50\" 4K combina Ultra HD, HDR y Tizen para ofrecer imágenes nítidas y colores vibrantes.', 12500, 200, 3, 1),
(4, 'MSI KATANA 15', 'El MSI Katana 15 B13V tiene Intel 13ª gen, RTX serie 40 y un diseño ideal para gaming y productividad.', 28500, 199, 2, 3),
(5, 'PC Gamer Fury ', 'La PC Gamer Fury está diseñada para jugadores que buscan alto rendimiento y confiabilidad.', 40300, 200, 2, 6),
(6, 'Samsung Galaxy S23 Ultra', 'El Samsung Galaxy S23 Ultra es un teléfono de alta gama lanzado en 2023, con rendimiento excepcional.', 28000, 200, 1, 1),
(7, 'Xiaomi 13T', 'El Xiaomi 13T es un smartphone de gama media-alta con características premium.', 14500, 200, 1, 7),
(8, 'iPhone 16 Pro Max', 'El iPhone 16 Pro Max es el modelo más avanzado de Apple en 2024, con gran potencia.', 37000, 198, 1, 4),
(9, 'Samsung Galaxy S24 Ultra ', 'El Samsung Galaxy S24 Ultra es el buque insignia de Samsung para 2024', 28000, 200, 1, 1),
(10, 'Xiaomi 14 Ultra ', 'El Xiaomi 14 Ultra es el modelo insignia de 2024, enfocado en fotografía y rendimiento.', 25000, 0, 1, 7),
(11, 'OnePlus 12 ', 'El OnePlus 12 es el más reciente modelo insignia de la marca, anunciado en diciembre de 2023.', 23000, 200, 1, 8),
(12, 'POCO F6 ', 'El POCO F6 de Xiaomi ofrece potencia y eficiencia en un dispositivo elegante de gama media-alta.', 9500, 200, 1, 7),
(13, 'Redmi Note 13 Pro+ 5G', 'El Redmi Note 13 Pro+ 5G de Xiaomi ofrece potencia características destacadas a buen precio.', 8000, 200, 1, 7),
(14, 'Samsung Galaxy A55 5G ', 'El Samsung Galaxy A55 5G es un smartphone de gama media que combina diseño refinado y rendimiento.', 8000, 198, 1, 1),
(15, 'Digital Master PC Gamer SILVER PRO ', 'La Digital Master PC Gamer SILVER PRO V1.0 es una computadora diseñada para gaming y tareas exigentes.', 32000, 200, 2, 6),
(16, 'PC Gamer Spartan Imagine ', 'La PC Gamer Spartan Imagine ofrece rendimiento sólido en juegos, tareas exigente para gamers.', 21000, 200, 2, 6),
(17, 'Xtreme PC Gaming CM-05505 ', 'La Xtreme PC Gaming CM-05505 está diseñada para gamers, rendimiento en juegos y multitarea.', 19100, 200, 2, 6),
(18, 'PC Gamer Delios 80¡', 'La PC Gamer Delios 80 de Spartan Geek es una máquina de alto rendimiento para gamers.', 60300, 200, 2, 6),
(19, 'HP Pavilion x360', 'El HP Pavilion x360 es una laptop convertible, versátil, que combina portabilidad, rendimiento y Durabilidad.', 16000, 200, 2, 9),
(20, 'Dell Inspiron 14 ', 'El Dell Inspiron 14 es un portátil versátil, con buen rendimiento, portabilidad y características modernas.', 14500, 200, 2, 10),
(21, 'Lenovo IdeaPad 3 ', 'El Lenovo IdeaPad 3 es una laptop de gama de entrada, con buen rendimiento y precio accesible.', 13600, 200, 2, 11),
(22, 'Asus VivoBook 15 ', 'El Asus VivoBook 15 es un portátil de gama media diseñado para uso cotidiano.', 11000, 200, 2, 12),
(23, 'Acer Aspire 5 ', 'El Acer Aspire 5 es un portátil versátil y eficiente, ideal para estudiantes y profesionales.', 9500, 200, 2, 13),
(24, 'HyperX Cloud Alpha', 'HyperX Cloud Alpha son audífonos gamer de alta calidad, con excelente rendimiento y comodidad.', 2000, 200, 4, 14),
(25, 'Corsair HS55 Stereo ', 'Corsair HS55 Stereo es un auricular gamer de alta calidad, cómodo y con buen sonido.', 1000, 200, 4, 15),
(26, 'SteelSeries Arctis Nova Pro Wireless', 'SteelSeries Arctis Nova Pro Wireless es un auricular gamer de alta gama, con sonido superior.', 4000, 200, 4, 16),
(27, 'Razer BlackShark V2 Pro', 'Razer BlackShark V2 Pro es un auricular gamer inalámbrico de alta gama, ideal para esports.', 2700, 200, 4, 17),
(28, 'Logitech G Pro X ', 'Logitech G Pro X es un auricular gamer de alta gama, ideal para esports y juegos competitivos.', 3100, 199, 4, 18),
(29, 'Sony WH-1000XM5 ', 'Sony WH-1000XM5 son audífonos inalámbricos de alta gama con cancelación de ruido avanzada.', 6000, 200, 4, 2),
(30, 'Bose QuietComfort 45', 'Bose QuietComfort 45 son audífonos inalámbricos de alta gama con cancelación de ruido avanzada.', 6700, 200, 4, 19),
(31, 'Sennheiser Momentum 4 Wireless ', 'Sennheiser Momentum 4 Wireless son audífonos inalámbricos de alta gama con cancelación de ruido.', 8100, 200, 4, 20),
(32, 'Audio-Technica ATH-M50X ', 'Audio-Technica ATH-M50X son audífonos profesionales de estudio, con excelente sonido y durabilidad.', 2000, 200, 4, 21),
(33, 'Bose SoundLink Around-Ear Wireless II', 'Bose SoundLink Around-Ear Wireless II son audífonos inalámbricos con cancelación de ruido.', 3700, 200, 4, 19),
(34, 'Samsung S90C ', 'Televisor QD-OLED con excelente imagen, rendimiento de juego y sonido incorporado.', 17100, 200, 3, 1),
(35, 'TCL QM851G', 'Televisor mini-LED de gama media con alto brillo, atenuación local y pantalla antirreflectante.', 30000, 200, 3, 22),
(36, 'Samsung The Frame', 'Televisor de diseño delgado y estilo de cuadro, ideal para decoración con Art Mode exclusivo.', 30000, 200, 3, 1),
(37, 'Samsung Neo QLED', 'Televisor con tecnología de puntos cuánticos y mini-LED, ofreciendo brillo y color 100% real.', 20000, 200, 3, 1),
(38, 'Sony X90J', 'Televisor OLED con calidad de imagen y sonido, soporte para HDR y visualización envolvente.', 25000, 200, 3, 2),
(39, 'LG C1', 'Televisor OLED de alta gama con excelente reproducción de colores y contraste, ideal para  Apasionados.', 22000, 200, 3, 23),
(40, 'Vizio P-Series Quantum', 'Televisor LED con retroiluminación Quantum, calidad de imagen nítida y soporte HDR.', 18000, 200, 3, 7),
(41, 'Hisense U8G', 'Televisor LED con retroiluminación mini-LED, excelente contraste y colores vivos.', 15000, 200, 3, 25),
(42, 'Toshiba Fire TV 43 pulgadas', 'Televisor Smart TV con Alexa, retroiluminación LED y soporte para HDR, ideal para streaming.', 4400, 200, 3, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_fotos`
--

CREATE TABLE `productos_fotos` (
  `ID_Producto` int(11) NOT NULL,
  `Ruta1` varchar(100) NOT NULL,
  `Ruta2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_fotos`
--

INSERT INTO `productos_fotos` (`ID_Producto`, `Ruta1`, `Ruta2`) VALUES
(1, '../IMG_ITEM/iPh15PM.png', '../IMG_ITEM/iPh15PM_2.png'),
(2, '../IMG_ITEM/JBL_TUNE_520.png', '../IMG_ITEM/JBL_tune_520.png'),
(3, '../IMG_ITEM/Samsung_TV_50_4K.png', '../IMG_ITEM/Samsung_TV_50_4K2.png'),
(4, '../IMG_ITEM/MSI_KATANA_15.png', '../IMG_ITEM/MSI_KATANA_15_2.png'),
(5, '../IMG_ITEM/PCGamer_Fury.webp', '../IMG_ITEM/PCGamer_Fury2.webp'),
(6, '../IMG_ITEM/Samsung_Galaxy_S23_Ultra.png', '../IMG_ITEM/Samsung_Galaxy_S23_Ultra2.png'),
(7, '../IMG_ITEM/Xiaomi_13T.png', '../IMG_ITEM/Xiaomi_13T2.png'),
(8, '../IMG_ITEM/iPhone_16_Pro_Max.png', '../IMG_ITEM/iPhone_16_Pro_Max2.png'),
(9, '../IMG_ITEM/Samsung_Galaxy_S24_Ultra.png', '../IMG_ITEM/Samsung_Galaxy_S24_Ultra2.png'),
(10, '../IMG_ITEM/Xiaomi_14_Ultra.png', '../IMG_ITEM/Xiaomi_14_Ultra2.png'),
(11, '../IMG_ITEM/OnePlus_12.png', ''),
(12, '../IMG_ITEM/POCO_F6.png', '../IMG_ITEM/POCO_F62.png'),
(13, '../IMG_ITEM/Redmi_Note_13_Pro+.png', '../IMG_ITEM/Redmi_Note_13_Pro+2.png'),
(14, '../IMG_ITEM/Samsung_Galaxy_A55.png', '../IMG_ITEM/Samsung_Galaxy_A55_5G2.png'),
(15, '../IMG_ITEM/Digital_Master_PC_Gamer_SILVER_PRO_V1.0.png', '../IMG_ITEM/Digital_Master_PC_Gamer_SILVER_PRO_V1.02.png'),
(16, '../IMG_ITEM/PC_Gamer_Spartan_Imagine.webp', ''),
(17, '../IMG_ITEM/Xtreme_PC_Gaming_CM-05505.png', '../IMG_ITEM/Xtreme_PC_Gaming_CM-055052.webp'),
(18, '../IMG_ITEM/PC_Gamer_Delios_80¡.webp', '../IMG_ITEM/PC_Gamer_Delios_80¡2.webp'),
(19, '../IMG_ITEM/HP_Pavilion_x360.png', '../IMG_ITEM/HP_Pavilion_x3602.png'),
(20, '../IMG_ITEM/Dell_Inspiron_14.png', '../IMG_ITEM/Dell_Inspiron_14_2.png'),
(21, '../IMG_ITEM/Lenovo_IdeaPad_3.png', '../IMG_ITEM/Lenovo_IdeaPad_3_2.png'),
(22, '../IMG_ITEM/Asus_VivoBook_15.png', '../IMG_ITEM/Asus_VivoBook_15_2.png'),
(23, '../IMG_ITEM/Acer_Aspire_5.png', '../IMG_ITEM/Acer_Aspire_5_2.png'),
(24, '../IMG_ITEM/HyperX_Cloud_Alpha.png', '../IMG_ITEM/HyperX_Cloud_Alpha2.png'),
(25, '../IMG_ITEM/Corsair_HS55_Stereo.png', '../IMG_ITEM/Corsair_HS55_Stereo2.png'),
(26, '../IMG_ITEM/SteelSeries_Arctis_Nova_Pro_Wireless.png', '../IMG_ITEM/SteelSeries_Arctis_Nova_Pro_Wireless2.png'),
(27, '../IMG_ITEM/Razer_BlackShark_V2_Pro.png', '../IMG_ITEM/Razer_BlackShark_V2_Pro2.png'),
(28, '../IMG_ITEM/Logitech_G_Pro_X.png', '../IMG_ITEM/Logitech_G_Pro_X2.png'),
(29, '../IMG_ITEM/Sony_WH-1000XM5.png', '../IMG_ITEM/Sony_WH-1000XM5_2.png'),
(30, '../IMG_ITEM/Bose_QuietComfort_45.png', '../IMG_ITEM/Bose_QuietComfort_45_2.png'),
(31, '../IMG_ITEM/Sennheiser_Momentum_4_Wireless.png', '../IMG_ITEM/Sennheiser_Momentum_4_Wireless2.png'),
(32, '../IMG_ITEM/Audio-Technica_ATH-M50X.png', '../IMG_ITEM/Audio-Technica_ATH-M50X2.png'),
(33, '../IMG_ITEM/Bose_SoundLink_AroundEar_Wireless_II.png', '../IMG_ITEM/Bose_SoundLink_AroundEar_Wireless_II_2.png'),
(34, '../IMG_ITEM/Samsung_S90C.png', '../IMG_ITEM/Samsung_S90C2.png'),
(35, '../IMG_ITEM/TCL_QM851G.png', '../IMG_ITEM/TCL_QM851G2.png'),
(36, '../IMG_ITEM/Samsung_The_Frame.png', '../IMG_ITEM/Samsung_The_Frame2.png'),
(37, '../IMG_ITEM/Samsung_Neo_QLED.png', '../IMG_ITEM/Samsung_Neo_QLED2.png'),
(38, '../IMG_ITEM/Sony_X90J.png', '../IMG_ITEM/Sony_X90J2.png'),
(39, '../IMG_ITEM/LG_C1.png', '../IMG_ITEM/LG_C12.png'),
(40, '../IMG_ITEM/Vizio_P-Series_Quantum.png', '../IMG_ITEM/Vizio_P-Series_Quantum2.png'),
(41, '../IMG_ITEM/Hisense_U8G.png', '../IMG_ITEM/Hisense_U8G2.png'),
(42, '../IMG_ITEM/Toshiba_Fire_TV_43.png', '../IMG_ITEM/Toshiba_Fire_TV_43_2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `ID_Soporte` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Motivo` varchar(30) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `ID_estado_soporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `ID_Trabajador` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Contrasena` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`ID_Administrador`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`ID_Carrito`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD UNIQUE KEY `Correo_2` (`Correo`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`ID_DetallePedido`),
  ADD KEY `ID_Producto` (`ID_Producto`),
  ADD KEY `ID_Estado` (`ID_Estado`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_Metodo`,`ID_Direccion`),
  ADD KEY `ID_Metodo` (`ID_Metodo`),
  ADD KEY `ID_Direccion` (`ID_Direccion`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`ID_Direccion`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  ADD PRIMARY KEY (`ID_Estado`);

--
-- Indices de la tabla `estado_soporte`
--
ALTER TABLE `estado_soporte`
  ADD PRIMARY KEY (`ID_estado_soporte`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`ID_Marca`);

--
-- Indices de la tabla `metodospagos`
--
ALTER TABLE `metodospagos`
  ADD PRIMARY KEY (`ID_Metodo`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Categoria` (`ID_Categoria`),
  ADD KEY `ID_Marca` (`ID_Marca`),
  ADD KEY `ID_Marca_2` (`ID_Marca`);

--
-- Indices de la tabla `productos_fotos`
--
ALTER TABLE `productos_fotos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`ID_Soporte`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_estado_soporte`),
  ADD KEY `ID_estado_soporte` (`ID_estado_soporte`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`ID_Trabajador`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `ID_Administrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `ID_DetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `ID_Direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `metodospagos`
--
ALTER TABLE `metodospagos`
  MODIFY `ID_Metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `ID_Soporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `ID_Trabajador` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  ADD CONSTRAINT `detalles_pedido_ibfk_3` FOREIGN KEY (`ID_Estado`) REFERENCES `estado_pedidos` (`ID_Estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedido_ibfk_4` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `detalles_pedido_ibfk_5` FOREIGN KEY (`ID_Metodo`) REFERENCES `metodospagos` (`ID_Metodo`),
  ADD CONSTRAINT `detalles_pedido_ibfk_6` FOREIGN KEY (`ID_Direccion`) REFERENCES `direcciones` (`ID_Direccion`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`);

--
-- Filtros para la tabla `metodospagos`
--
ALTER TABLE `metodospagos`
  ADD CONSTRAINT `metodospagos_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categorias` (`ID_Categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`ID_Marca`) REFERENCES `marcas` (`ID_Marca`);

--
-- Filtros para la tabla `productos_fotos`
--
ALTER TABLE `productos_fotos`
  ADD CONSTRAINT `productos_fotos_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `soporte_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soporte_ibfk_2` FOREIGN KEY (`ID_estado_soporte`) REFERENCES `estado_soporte` (`ID_estado_soporte`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
