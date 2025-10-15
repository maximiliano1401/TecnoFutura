-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2025 at 08:42 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u373598520_tecnofutura`
--

-- --------------------------------------------------------

--
-- Table structure for table `administradores`
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
-- Table structure for table `carrito_compras`
--

CREATE TABLE `carrito_compras` (
  `ID_Carrito` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Producto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carrito_compras`
--

INSERT INTO `carrito_compras` (`ID_Carrito`, `ID_Cliente`, `ID_Producto`, `Cantidad`) VALUES
(74, 5, 1, 11),
(77, 30, 37, 150),
(78, 31, 1, 2),
(81, 33, 5, 1),
(82, 33, 32, 1),
(90, 35, 31, 2),
(91, 35, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`ID_Categoria`, `Nombre`) VALUES
(1, 'Teléfonos'),
(2, 'Cómputo'),
(3, 'Televisores'),
(4, 'Audio');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Edad` int(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `FotoPerfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `Nombre`, `Correo`, `Telefono`, `Contrasena`, `Edad`, `fecha_registro`, `FotoPerfil`) VALUES
(5, 'Super', 'su@gmail.com', '9811001100', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 19, '2025-03-11 04:37:45', '../PERFILES/5.jpg'),
(8, 'Administración', 'administrador@gmail.com', '9811001400', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 22, '2025-03-11 04:37:45', NULL),
(16, 'Maximiliano', 'ein450@gmail.com', '987654321', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 28, '2025-03-11 04:37:45', '../PERFILES/16.jpg'),
(24, 'testiador pro', 'pepe@gmail.com', '9876543210', '2ad66d043f350663f395db353ab26763cb0960f1d58d93520ebb0b5abbe917b7', 24, '2025-03-23 09:16:53', NULL),
(27, 'pablo leonel Salomon Campos', 'mastersensei@gmail.com', '9821250643', '5d75dee765220e9797e7cdfc40cd0c0a175a92e0c0c7184bec6c866271aad54e', 21, '2025-03-24 22:24:25', NULL),
(28, 'Mario Alonso Segovia Gutierrez', 'mario@dominiofalso', '9811356011', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 28, '2025-03-27 00:04:30', NULL),
(29, 'Mario Alonso Segovia Gutierrez', 'mario.segovia.gtz@gmail.com', '9811356911', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 28, '2025-03-27 00:05:15', NULL),
(30, 'Juanito', 'juanito@gmail.com', '11111111111', 'a78a8be81f02f57fd5c73dd684c82ec2fd0c48fd2aea269286bb70d1ee41bf1f', 90, '2025-03-31 22:55:24', NULL),
(31, 'Pruebas', 'yo@gmail.com', '2554646597', 'cc7f9583281d9ba563abcd304f61cfdbaf39e3df281e984da4fb2bfe38fd9e31', 25, '2025-03-31 23:15:20', NULL),
(32, 'Pruebas2', '1@gmail.com', '313154884', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 54, '2025-03-31 23:55:41', NULL),
(33, 'Minecraft', 'bmdp149@hotmail.com', '987654321', 'c775e7b757ede630cd0aa1113bd102661ab38829ca52a6422ab782862f268646', 28, '2025-04-01 00:53:11', NULL),
(34, 'Ñ', 'jesusyabur@gmail.com', '999999999999999', '6c49f8b7e3c1d712e6c75a2ec5b7e7a1e2fba8250cd545db2d0379748c6063da', 89, '2025-04-01 23:57:49', NULL),
(35, 'JORGE MIGUEL ', 'michaelalavez2109@gmail.com', '9812181897', '806827df63b79114e94edd305f5a11963036a91f709b50e965b4b53b85e869ec', 27, '2025-04-01 23:57:53', NULL),
(36, 'Abraham Pech', 'Abrahamayil415@gmail.com', '9811303951', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 22, '2025-04-01 23:58:03', NULL),
(37, 'Melanie Alcocer Esquivrl', 'melanieatr2005@gmail.com', '9811788432', 'd00339a8cad8688d3abb3f4ff6ff098923e4498383719819f59729bf2e965a34', 19, '2025-04-01 23:58:11', NULL),
(39, 'Eduardo', 'eduardo.zyh@gmail.com', '5586750786', 'e24df920078c3dd4e7e8d2442f00e5c9ab2a231bb3918d65cc50906e49ecaef4', 50, '2025-04-01 23:59:00', NULL),
(40, '.|.', 'sus@gus.com', '9981763623', '5e15ef2b628974be5fcda83295e75b8be0bb23c386d9963cc993eda0f2cb80da', 23, '2025-04-01 23:59:10', '../PERFILES/40.jpg'),
(42, 'Angel yeh', 'hectoooooor.27@gmail.com', '9811573679', 'e34e7005f228c18793f10fbc408b3fcbd629db2eb56cb6c574b95d992add6bce', 21, '2025-04-02 00:01:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detalles_pedido`
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
-- Dumping data for table `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`ID_DetallePedido`, `ID_Estado`, `ID_Producto`, `Cantidad`, `ID_Cliente`, `ID_Metodo`, `ID_Direccion`) VALUES
(56, 1, 8, 1, 24, 17, 9),
(57, 1, 7, 1, 27, 18, 10),
(58, 1, 6, 1, 32, 20, 14),
(59, 1, 42, 1, 32, 20, 14),
(60, 1, 20, 3, 40, 22, 16),
(61, 1, 14, 1, 39, 24, 18),
(62, 1, 2, 2, 42, 23, 17),
(63, 1, 40, 4, 40, 22, 16),
(64, 1, 33, 51, 40, 22, 16);

-- --------------------------------------------------------

--
-- Table structure for table `direcciones`
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
-- Dumping data for table `direcciones`
--

INSERT INTO `direcciones` (`ID_Direccion`, `Calle`, `NumExt`, `NumInt`, `Entrecalles`, `NumContacto`, `Colonia`, `ID_Cliente`) VALUES
(9, 'av titi me pregunto', 33, 78, '01 centro', '98765432103', 'master sensei', 24),
(10, 'av titi me pregunto', 33, 78, '01 centro', '98765432103', 'master sensei', 27),
(11, 'asdad', 12, 12, 'Juanito y Rah', '123456789101213', 'Nose', 30),
(12, 'asdad', 12, 12, 'Juanito y Rah', '98765433116', 'Nose', 30),
(13, 'mastila esta', 321, 974, 'Juanito y Rah', '98765433116', 'Av Central Norte', 30),
(14, 'Calle benito', 0, 0, 'Dddxx', 'Ddddd', 'sdfdsf', 32),
(15, 'Call', 123, 0, '789', '123456789', 'Coloon', 33),
(16, '69', 666, 0, 'Si', '9981767878', 'Sascatelum', 40),
(17, 'Calle 8', 43, 1, '1 y 3', '9911241433', 'cuauhtemoc', 42),
(18, 'Calle', 12, 12, 'Calle 1', '8371749103', 'Colonia', 39);

-- --------------------------------------------------------

--
-- Table structure for table `estado_pedidos`
--

CREATE TABLE `estado_pedidos` (
  `ID_Estado` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estado_pedidos`
--

INSERT INTO `estado_pedidos` (`ID_Estado`, `Descripcion`) VALUES
(1, 'EN PROCESO'),
(2, 'ENVIADO'),
(3, 'RECIBIDO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_soporte`
--

CREATE TABLE `estado_soporte` (
  `ID_estado_soporte` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estado_soporte`
--

INSERT INTO `estado_soporte` (`ID_estado_soporte`, `Nombre`) VALUES
(1, 'Finalizada'),
(2, 'Cancelada'),
(3, 'En Proceso');

-- --------------------------------------------------------

--
-- Table structure for table `marcas`
--

CREATE TABLE `marcas` (
  `ID_Marca` int(11) NOT NULL,
  `Marca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marcas`
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
-- Table structure for table `metodospagos`
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
-- Dumping data for table `metodospagos`
--

INSERT INTO `metodospagos` (`ID_Metodo`, `Titular`, `Numeros`, `CVV`, `MyA`, `ID_Cliente`) VALUES
(17, 'Pepe tito', '5517782417043532', 876, '01-2027', 24),
(18, 'Pablo Salomon', '5512386547043942', 101, '01-2030', 27),
(19, 'Juanito', '1111111111111111', 123, '12-2030', 30),
(20, 'Gihoih', '1234567898765443', 876, '10-2058', 32),
(21, 'Maximiliano', '1234567890123456', 123, '12-2030', 33),
(22, 'Piplup P', '8888999966667777', 898, '10-2026', 40),
(23, 'Angel yeh', '4819999991977247', 888, '03-2029', 42),
(24, 'EDUARDO JIMENEZ CRUZ', '8877778838173952', 123, '05-2030', 39);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
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
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`ID_Producto`, `Nombre`, `Descripcion`, `Precio`, `Stock`, `ID_Categoria`, `ID_Marca`) VALUES
(1, 'iPhone 15 Pro Max', 'El iPhone 15 Pro Max tiene una pantalla de 6.7 pulgadas, chip A17 Pro y un diseño elegante de titanio.', 29000, 10, 1, 4),
(2, 'JBL TUNE 520', 'El JBL TUNE 520BT son audífonos inalámbricos con JBL Pure Bass y gran calidad de sonido y comodidad.', 750, 23, 4, 5),
(3, 'Samsung TV 50 4K', 'El Samsung TV 50\" 4K combina Ultra HD, HDR y Tizen para ofrecer imágenes nítidas y colores vibrantes.', 12500, 3, 3, 1),
(4, 'MSI KATANA 15', 'El MSI Katana 15 B13V tiene Intel 13ª gen, RTX serie 40 y un diseño ideal para gaming y productividad.', 28500, 9, 2, 3),
(5, 'PC Gamer Fury ', 'La PC Gamer Fury está diseñada para jugadores que buscan alto rendimiento y confiabilidad.', 40300, 200, 2, 6),
(6, 'Samsung Galaxy S23 Ultra', 'El Samsung Galaxy S23 Ultra es un teléfono de alta gama lanzado en 2023, con rendimiento excepcional.', 28000, 199, 1, 1),
(7, 'Xiaomi 13T', 'El Xiaomi 13T es un smartphone de gama media-alta con características premium.', 14500, 199, 1, 7),
(8, 'iPhone 16 Pro Max', 'El iPhone 16 Pro Max es el modelo más avanzado de Apple en 2024, con gran potencia.', 37000, 199, 1, 4),
(9, 'Samsung Galaxy S24 Ultra ', 'El Samsung Galaxy S24 Ultra es el buque insignia de Samsung para 2024', 28000, 200, 1, 1),
(10, 'Xiaomi 14 Ultra ', 'El Xiaomi 14 Ultra es el modelo insignia de 2024, enfocado en fotografía y rendimiento.', 25000, 200, 1, 7),
(11, 'OnePlus 12 ', 'El OnePlus 12 es el más reciente modelo insignia de la marca, anunciado en diciembre de 2023.', 23000, 200, 1, 8),
(12, 'POCO F6 ', 'El POCO F6 de Xiaomi ofrece potencia y eficiencia en un dispositivo elegante de gama media-alta.', 9500, 200, 1, 7),
(13, 'Redmi Note 13 Pro+ 5G', 'El Redmi Note 13 Pro+ 5G de Xiaomi ofrece potencia características destacadas a buen precio.', 8000, 200, 1, 7),
(14, 'Samsung Galaxy A55 5G ', 'El Samsung Galaxy A55 5G es un smartphone de gama media que combina diseño refinado y rendimiento.', 8000, 199, 1, 1),
(15, 'Digital Master PC Gamer SILVER PRO ', 'La Digital Master PC Gamer SILVER PRO V1.0 es una computadora diseñada para gaming y tareas exigentes.', 32000, 200, 2, 6),
(16, 'PC Gamer Spartan Imagine ', 'La PC Gamer Spartan Imagine ofrece rendimiento sólido en juegos, tareas exigente para gamers.', 21000, 200, 2, 6),
(17, 'Xtreme PC Gaming CM-05505 ', 'La Xtreme PC Gaming CM-05505 está diseñada para gamers, rendimiento en juegos y multitarea.', 19100, 200, 2, 6),
(18, 'PC Gamer Delios 80¡', 'La PC Gamer Delios 80 de Spartan Geek es una máquina de alto rendimiento para gamers.', 60300, 200, 2, 6),
(19, 'HP Pavilion x360', 'El HP Pavilion x360 es una laptop convertible, versátil, que combina portabilidad, rendimiento y Durabilidad.', 16000, 200, 2, 9),
(20, 'Dell Inspiron 14 ', 'El Dell Inspiron 14 es un portátil versátil, con buen rendimiento, portabilidad y características modernas.', 14500, 197, 2, 10),
(21, 'Lenovo IdeaPad 3 ', 'El Lenovo IdeaPad 3 es una laptop de gama de entrada, con buen rendimiento y precio accesible.', 13600, 200, 2, 11),
(22, 'Asus VivoBook 15 ', 'El Asus VivoBook 15 es un portátil de gama media diseñado para uso cotidiano.', 11000, 200, 2, 12),
(23, 'Acer Aspire 5 ', 'El Acer Aspire 5 es un portátil versátil y eficiente, ideal para estudiantes y profesionales.', 9500, 200, 2, 13),
(24, 'HyperX Cloud Alpha', 'HyperX Cloud Alpha son audífonos gamer de alta calidad, con excelente rendimiento y comodidad.', 2000, 200, 4, 14),
(25, 'Corsair HS55 Stereo ', 'Corsair HS55 Stereo es un auricular gamer de alta calidad, cómodo y con buen sonido.', 1000, 200, 4, 15),
(26, 'SteelSeries Arctis Nova Pro Wireless', 'SteelSeries Arctis Nova Pro Wireless es un auricular gamer de alta gama, con sonido superior.', 4000, 200, 4, 16),
(27, 'Razer BlackShark V2 Pro', 'Razer BlackShark V2 Pro es un auricular gamer inalámbrico de alta gama, ideal para esports.', 2700, 200, 4, 17),
(28, 'Logitech G Pro X ', 'Logitech G Pro X es un auricular gamer de alta gama, ideal para esports y juegos competitivos.', 3100, 200, 4, 18),
(29, 'Sony WH-1000XM5 ', 'Sony WH-1000XM5 son audífonos inalámbricos de alta gama con cancelación de ruido avanzada.', 6000, 200, 4, 2),
(30, 'Bose QuietComfort 45', 'Bose QuietComfort 45 son audífonos inalámbricos de alta gama con cancelación de ruido avanzada.', 6700, 200, 4, 19),
(31, 'Sennheiser Momentum 4 Wireless ', 'Sennheiser Momentum 4 Wireless son audífonos inalámbricos de alta gama con cancelación de ruido.', 8100, 200, 4, 20),
(32, 'Audio-Technica ATH-M50X ', 'Audio-Technica ATH-M50X son audífonos profesionales de estudio, con excelente sonido y durabilidad.', 2000, 200, 4, 21),
(33, 'Bose SoundLink Around-Ear Wireless II', 'Bose SoundLink Around-Ear Wireless II son audífonos inalámbricos con cancelación de ruido.', 3700, 149, 4, 19),
(34, 'Samsung S90C ', 'Televisor QD-OLED con excelente imagen, rendimiento de juego y sonido incorporado.', 17100, 200, 3, 1),
(35, 'TCL QM851G', 'Televisor mini-LED de gama media con alto brillo, atenuación local y pantalla antirreflectante.', 30000, 200, 3, 22),
(36, 'Samsung The Frame', 'Televisor de diseño delgado y estilo de cuadro, ideal para decoración con Art Mode exclusivo.', 30000, 200, 3, 1),
(37, 'Samsung Neo QLED', 'Televisor con tecnología de puntos cuánticos y mini-LED, ofreciendo brillo y color 100% real.', 20000, 200, 3, 1),
(38, 'Sony X90J', 'Televisor OLED con calidad de imagen y sonido, soporte para HDR y visualización envolvente.', 25000, 200, 3, 2),
(39, 'LG C1', 'Televisor OLED de alta gama con excelente reproducción de colores y contraste, ideal para  Apasionados.', 22000, 200, 3, 23),
(40, 'Vizio P-Series Quantum', 'Televisor LED con retroiluminación Quantum, calidad de imagen nítida y soporte HDR.', 18000, 196, 3, 7),
(41, 'Hisense U8G', 'Televisor LED con retroiluminación mini-LED, excelente contraste y colores vivos.', 15000, 200, 3, 25),
(42, 'Toshiba Fire TV 43 pulgadas', 'Televisor Smart TV con Alexa, retroiluminación LED y soporte para HDR, ideal para streaming.', 4400, 199, 3, 26);

-- --------------------------------------------------------

--
-- Table structure for table `productos_fotos`
--

CREATE TABLE `productos_fotos` (
  `ID_Producto` int(11) NOT NULL,
  `Ruta1` varchar(100) NOT NULL,
  `Ruta2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos_fotos`
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
-- Table structure for table `soporte`
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
-- Table structure for table `trabajadores`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`ID_Administrador`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indexes for table `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD PRIMARY KEY (`ID_Carrito`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD UNIQUE KEY `Correo_2` (`Correo`);

--
-- Indexes for table `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD PRIMARY KEY (`ID_DetallePedido`),
  ADD KEY `ID_Producto` (`ID_Producto`),
  ADD KEY `ID_Estado` (`ID_Estado`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_Metodo`,`ID_Direccion`),
  ADD KEY `ID_Metodo` (`ID_Metodo`),
  ADD KEY `ID_Direccion` (`ID_Direccion`);

--
-- Indexes for table `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`ID_Direccion`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indexes for table `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  ADD PRIMARY KEY (`ID_Estado`);

--
-- Indexes for table `estado_soporte`
--
ALTER TABLE `estado_soporte`
  ADD PRIMARY KEY (`ID_estado_soporte`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`ID_Marca`);

--
-- Indexes for table `metodospagos`
--
ALTER TABLE `metodospagos`
  ADD PRIMARY KEY (`ID_Metodo`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Categoria` (`ID_Categoria`),
  ADD KEY `ID_Marca` (`ID_Marca`),
  ADD KEY `ID_Marca_2` (`ID_Marca`);

--
-- Indexes for table `productos_fotos`
--
ALTER TABLE `productos_fotos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indexes for table `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`ID_Soporte`),
  ADD KEY `ID_Cliente` (`ID_Cliente`,`ID_estado_soporte`),
  ADD KEY `ID_estado_soporte` (`ID_estado_soporte`);

--
-- Indexes for table `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`ID_Trabajador`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administradores`
--
ALTER TABLE `administradores`
  MODIFY `ID_Administrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carrito_compras`
--
ALTER TABLE `carrito_compras`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  MODIFY `ID_DetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `ID_Direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `metodospagos`
--
ALTER TABLE `metodospagos`
  MODIFY `ID_Metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `soporte`
--
ALTER TABLE `soporte`
  MODIFY `ID_Soporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `ID_Trabajador` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrito_compras`
--
ALTER TABLE `carrito_compras`
  ADD CONSTRAINT `carrito_compras_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `carrito_compras_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Constraints for table `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  ADD CONSTRAINT `detalles_pedido_ibfk_3` FOREIGN KEY (`ID_Estado`) REFERENCES `estado_pedidos` (`ID_Estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedido_ibfk_4` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`),
  ADD CONSTRAINT `detalles_pedido_ibfk_5` FOREIGN KEY (`ID_Metodo`) REFERENCES `metodospagos` (`ID_Metodo`),
  ADD CONSTRAINT `detalles_pedido_ibfk_6` FOREIGN KEY (`ID_Direccion`) REFERENCES `direcciones` (`ID_Direccion`);

--
-- Constraints for table `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`);

--
-- Constraints for table `metodospagos`
--
ALTER TABLE `metodospagos`
  ADD CONSTRAINT `metodospagos_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categorias` (`ID_Categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`ID_Marca`) REFERENCES `marcas` (`ID_Marca`);

--
-- Constraints for table `productos_fotos`
--
ALTER TABLE `productos_fotos`
  ADD CONSTRAINT `productos_fotos_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Constraints for table `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `soporte_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soporte_ibfk_2` FOREIGN KEY (`ID_estado_soporte`) REFERENCES `estado_soporte` (`ID_estado_soporte`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
