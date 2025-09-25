# 📖 DOCUMENTACIÓN PROYECTO TECNOVR

## 🎯 DESCRIPCIÓN GENERAL
TecnoVR es una aplicación de realidad virtual basada en web que permite explorar una tienda virtual de productos tecnológicos. Utiliza A-Frame como framework principal para crear experiencias VR/AR inmersivas directamente en el navegador.

## 🏗️ ARQUITECTURA DEL PROYECTO

### 📂 ESTRUCTURA DE ARCHIVOS

```
TECNOVR/
├── assets/                     # Recursos 3D (modelos, texturas)
│   ├── cel_1/                 # Modelo de celular
│   ├── estructura/            # Modelo de la tienda
│   ├── laptop1/               # Laptop principal
│   ├── monitor/               # Monitores
│   ├── monitor(2)/
│   ├── monitor_1/
│   └── monitor_2/
├── index.php                  # Página principal de la aplicación VR
├── main.js                    # Control de cámara y navegación táctil
├── productos.js               # Gestión de productos e interacciones
├── get_product.php            # API REST para obtener datos de productos
├── controles-tactiles.php     # Interfaz de controles móviles
├── modelos-texturas.php       # Carga de assets 3D
├── objetos-escena.php         # Posicionamiento de objetos en la escena
└── panel-informacion.php      # UI panel de información de productos
```

## 🔧 COMPONENTES PRINCIPALES

### 1. 📱 **index.php** - Página Principal
- **Propósito**: Punto de entrada de la aplicación VR
- **Características**:
  - Verificación de sesión de usuario
  - Integración de A-Frame 1.7.1
  - Sistema de controles táctiles responsivo
  - Configuración de cámara VR con controles look/WASD
  - Interfaz de cursor con animaciones de fusión
  - Estilos CSS avanzados con efectos glassmorphism
  - Banner demo flotante
  - Detección automática de dispositivos móviles

- **Tecnologías**:
  - A-Frame 1.7.1
  - PHP (autenticación)
  - CSS3 (animaciones, glassmorphism)
  - JavaScript (integración)

### 2. 🎮 **main.js** - Control de Navegación
- **Propósito**: Manejo de controles táctiles y navegación
- **Funcionalidades**:
  - Detección de dispositivos móviles/desktop
  - Simulación de eventos de teclado (WASD)
  - Sistema de vibración háptica
  - Efectos visuales ripple en botones
  - Control de estados de botones (presionado/liberado)
  - Eventos táctiles mejorados con retroalimentación

- **Características técnicas**:
  - Prevención de eventos duplicados
  - Gestión de memoria para efectos visuales
  - Compatibilidad cross-platform
  - Animaciones CSS dinámicas

### 3. 🛒 **productos.js** - Gestión de Productos
- **Propósito**: Manejo de interacciones con productos en la escena VR
- **Funcionalidades**:
  - Detección de clics/taps en objetos 3D
  - Fetch asíncrono de datos de productos
  - Control del panel de información
  - Posicionamiento dinámico del panel
  - Gestión de animaciones del panel
  - Redirección a páginas de detalle

- **Flujo de trabajo**:
  1. Usuario hace clic en objeto 3D
  2. Se obtiene ID del producto del atributo `data-product`
  3. Fetch a `get_product.php` con el ID
  4. Se actualiza el panel con información del producto
  5. Se posiciona el panel detrás de la cámara
  6. Se muestran animaciones de aparición

### 4. 🔄 **get_product.php** - API de Productos
- **Propósito**: API REST para obtener información de productos
- **Funcionalidades**:
  - Mapeo de IDs de objetos VR a productos de BD
  - Consultas SQL seguras con prepared statements
  - Respuestas JSON con información completa
  - Manejo de errores y validaciones
  - Soporte para CORS

- **Mapeo actual de productos**:
```php
$mapa_objetos = [
    'laptop1'    => 19, // HP Pavilion x360
    'celular1'   => 6,  // Samsung Galaxy S23 Ultra
    'monitor1'   => 34, // Samsung S90C (QD-OLED)
    'monitor2'   => 38, // Sony X90J (OLED)
    'cube1'      => 1,  // iPhone 15 Pro Max
    'cube2'      => 2,  // JBL TUNE 520
    'cube3'      => 3,  // Samsung TV 50 4K
    // Laptops gamer
    'lapgamer'   => 4,  // MSI KATANA 15
    'lapgamer1'  => 20, // Dell Inspiron 14
    'lapgamer2'  => 21, // Lenovo IdeaPad 3
    'lapgamer3'  => 22, // Asus VivoBook 15
    'lapgamer5'  => 23, // Acer Aspire 5
    // PCs gamer
    'pc1'        => 5,  // PC Gamer Fury
    'pc2'        => 15, // Digital Master PC Gamer SILVER PRO
    'pc3'        => 16, // PC Gamer Spartan Imagine
    'pc4'        => 17, // Xtreme PC Gaming CM-05505
    'pc5'        => 18, // PC Gamer Delios 80
    'pc6'        => 5,  // PC Gamer Fury (duplicado)
];
```

### 5. 📱 **controles-tactiles.php** - Interfaz Móvil
- **Propósito**: Controles de navegación para dispositivos táctiles
- **Características**:
  - Diseño circular con indicadores visuales
  - Botones direccionales (▲▼◀▶)
  - Efectos hover diferenciados por función
  - Estilos glassmorphism avanzados
  - Indicadores de estado
  - Diseño responsivo

- **Controles incluidos**:
  - Forward (W) - Avanzar
  - Back (S) - Retroceder  
  - Left (A) - Izquierda
  - Right (D) - Derecha

### 6. 🎨 **modelos-texturas.php** - Assets 3D
- **Propósito**: Carga y configuración de modelos 3D y texturas
- **Assets incluidos**:
  - `estructura`: Modelo de la tienda principal
  - `laptop1`: Laptop principal mostrada
  - `celular1`: Modelo de smartphone
  - `monitor1/2`: Monitores de diferentes tipos
  - `laptopgamer1-5`: Variedad de laptops gamer
  - `pc1-6`: Gabinetes de PC gamer

- **Formato de assets**:
  - Modelos: `.obj` (Wavefront OBJ)
  - Materiales: `.mtl` (Material Template Library)

### 7. 🌍 **objetos-escena.php** - Escena 3D
- **Propósito**: Posicionamiento y configuración de objetos en la escena VR
- **Configuración**:
  - Coordenadas de posición (x, y, z)
  - Escalas de objetos (uniformes y no uniformes)
  - Rotaciones iniciales
  - Clases CSS para interactividad
  - Atributos `data-product` para identificación

- **Objetos configurados**:
  - Estructura de la tienda (escala 0.5)
  - Productos posicionados estratégicamente
  - Cubos de prueba para testing
  - Elementos clickeables con clase `clickable product`

### 8. 🎪 **panel-informacion.php** - UI de Información
- **Propósito**: Panel flotante con información detallada de productos
- **Características visuales**:
  - Efecto glassmorphism con transparencia
  - Animaciones de aparición/desaparición
  - Efectos de partículas decorativas
  - Bordes brillantes y sombras
  - Tipografía mejorada con Roboto

- **Elementos del panel**:
  - Imagen del producto (0.9x0.9)
  - Nombre del producto
  - Precio destacado en color teal
  - Descripción truncada (180 caracteres)
  - Botón "Ver detalles" (0.8x0.15)
  - Botón cerrar (X)
  - Instrucciones de uso

- **Animaciones incluidas**:
  - Escalado al aparecer/desaparecer
  - Efectos hover en botones
  - Línea separadora animada
  - Partículas flotantes
  - Efectos de brillo pulsante

## 🔗 INTEGRACIÓN CON SISTEMA PRINCIPAL

### Conexión con Base de Datos
- Utiliza la conexión establecida en `../PHP/conexion.php`
- Consultas a tablas: `productos`, `productos_fotos`, `categorias`, `marcas`
- Autenticación basada en sesiones PHP

### Redirección a Tienda Principal
- Botón "Ver detalles" redirige a: `https://tecnofutura.shop/HTML/producto.php?id_producto={ID}`
- Apertura en nueva pestaña (`_blank`)
- Integración seamless con el sistema de e-commerce

## 🎯 FLUJO DE USUARIO

1. **Acceso**: Usuario con sesión activa accede a `/TECNOVR/`
2. **Carga**: Se inicializa la escena VR con todos los assets
3. **Navegación**: 
   - Desktop: Mouse + teclado (WASD + look controls)
   - Móvil: Controles táctiles + giroscopio
4. **Exploración**: Usuario navega por la tienda virtual
5. **Interacción**: Click/tap en productos muestra panel informativo
6. **Detalle**: Botón "Ver detalles" abre página completa del producto
7. **Compra**: Integración con sistema de e-commerce principal

## 🔧 CONFIGURACIÓN TÉCNICA

### Requisitos del Sistema
- Navegador compatible con WebXR/WebGL
- Conexión a internet estable
- Dispositivo con aceleración gráfica
- Para VR: Headset compatible (opcional)

### Configuración del Servidor
- PHP 7.4+
- MySQL/MariaDB
- Apache/Nginx con mod_rewrite
- Extensiones PHP: MySQLi, JSON

### Optimizaciones
- Assets 3D optimizados para web
- Compresión de texturas
- LOD (Level of Detail) para modelos
- Lazy loading de assets
- Caché de consultas SQL

## 🎨 SISTEMA DE ESTILOS

### Paleta de Colores
```css
:root {
  --glass-bg: rgba(76, 195, 217, 0.1);      /* Fondo glassmorphism */
  --glass-border: rgba(255, 255, 255, 0.2); /* Bordes glass */
  --text-light: #ffffff;                     /* Texto principal */
  --accent-blue: #4CC3D9;                    /* Azul de acento */
  --accent-teal: #4ECDC4;                    /* Verde azulado */
  --accent-red: #FF6B6B;                     /* Rojo de acento */
}
```

### Efectos Visuales
- **Glassmorphism**: Transparencias con blur backdrop
- **Animaciones CSS**: Keyframes para transiciones suaves
- **Efectos Ripple**: Ondas al tocar botones
- **Partículas**: Elementos decorativos flotantes
- **Glow Effects**: Brillos y sombras dinámicas

## 🚀 FUNCIONALIDADES AVANZADAS

### Realidad Virtual
- Soporte nativo para headsets VR
- Controles de mano en VR
- Teleportación y navegación libre
- Interfaz adaptativa VR/AR

### Optimizaciones Móviles
- Detección automática de dispositivo
- Controles táctiles nativos
- Vibración háptica
- Optimización de rendimiento
- Reducción de assets para móviles

### Accesibilidad
- Cursor con animación de fusión
- Controles alternativos (teclado/gamepad)
- Tamaños de texto escalables
- Alto contraste en UI

## 🔄 MANTENIMIENTO Y ACTUALIZACIONES

### Assets 3D
- Modelos almacenados en `/assets/`
- Nomenclatura consistente: `{objeto}-obj/mtl`
- Optimización periódica recomendada
- Backup de modelos originales

### Base de Datos
- Mapeo de productos en `get_product.php`
- Sincronización con catálogo principal
- Validación de stock en tiempo real
- Cache de consultas frecuentes

### Actualizaciones de A-Frame
- Versión actual: 1.7.1
- Testing requerido antes de updates
- Compatibilidad con componentes custom
- Backup de configuración actual

## 🎯 PRÓXIMAS MEJORAS SUGERIDAS

1. **Sistema de Carrito VR**: Agregar productos directamente desde VR
2. **Multiplayer**: Exploración colaborativa
3. **AR Mode**: Visualización en realidad aumentada
4. **Voice Commands**: Control por voz
5. **Analytics**: Tracking de interacciones en VR
6. **Personalization**: Avatares y preferencias de usuario
7. **Social Features**: Compartir experiencias VR
8. **Advanced Physics**: Simulaciones físicas más realistas

---

**Fecha de Documentación**: Septiembre 2025  
**Versión del Proyecto**: 1.0  
**Última Actualización**: Mapeo de productos extendido  
**Autor**: Sistema de Documentación Automática  

---

> 💡 **Nota**: Esta documentación debe actualizarse con cada cambio significativo en el proyecto para mantener la coherencia y facilitar el mantenimiento futuro.