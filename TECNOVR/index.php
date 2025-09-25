<?php
// Incluir archivos de configuración y conexión a la base de datos
include "../PHP/conexion.php";
session_start();
// VERIFICACIÓN DE SESIÓN ACTIVA
if (!isset($_SESSION['ID_Cliente'])) {
    header("Location: ../HTML/index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TecnoVR</title>
  <script src="https://aframe.io/releases/1.7.1/aframe.min.js"></script>
  <style>
    :root {
      --glass-bg: rgba(76, 195, 217, 0.1);
      --glass-border: rgba(255, 255, 255, 0.2);
      --text-light: #ffffff;
      --accent-blue: #4CC3D9;
      --accent-teal: #4ECDC4;
      --accent-red: #FF6B6B;
    }

    @keyframes floatAnimation {
      0% { transform: translateY(0px) rotate(0deg); }
      100% { transform: translateY(-20px) rotate(5deg); }
    }

    .touch-controls {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 1000;
      pointer-events: none;
      filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
    }

    .touch-grid {
      display: grid;
      grid-template-columns: 70px 70px 70px;
      grid-template-rows: 70px;
      gap: 15px;
      justify-items: center;
      align-items: center;
    }

    .touch-btn {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: linear-gradient(145deg, 
        rgba(76, 195, 217, 0.3), 
        rgba(78, 205, 196, 0.2));
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      color: var(--text-light);
      font-size: 2.2em;
      font-weight: 600;
      border: 2px solid var(--glass-border);
      pointer-events: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
      touch-action: manipulation;
      position: relative;
      overflow: hidden;
      box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .touch-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.2), 
        transparent);
      transition: left 0.5s;
    }

    .touch-btn:hover::before {
      left: 100%;
    }

    .touch-btn:hover {
      transform: translateY(-5px) scale(1.05);
      background: linear-gradient(145deg, 
        rgba(76, 195, 217, 0.6), 
        rgba(78, 205, 196, 0.4));
      box-shadow: 
        0 15px 40px rgba(76, 195, 217, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .touch-btn:active {
      transform: translateY(-2px) scale(0.98);
      background: linear-gradient(145deg, 
        rgba(76, 195, 217, 0.8), 
        rgba(78, 205, 196, 0.6));
    }

    /* Estilo para botón presionado */
    .touch-btn.btn-pressed {
      transform: translateY(-2px) scale(0.95);
      background: linear-gradient(145deg, 
        rgba(76, 195, 217, 0.9), 
        rgba(78, 205, 196, 0.7)) !important;
      box-shadow: 
        0 5px 20px rgba(76, 195, 217, 0.6),
        inset 0 2px 0 rgba(255, 255, 255, 0.3);
    }

    /* Animación para efecto ripple */
    @keyframes ripple {
      0% {
        transform: scale(0);
        opacity: 0.6;
      }
      100% {
        transform: scale(2);
        opacity: 0;
      }
    }

    .touch-row-top {
      display: flex;
      justify-content: center;
      margin-bottom: 10px;
    }

    /* Estilos responsivos para dispositivos móviles */
    @media (max-width: 768px) {
      .touch-controls {
        left: 15px;
        bottom: 25px;
      }
      
      .touch-btn {
        width: 60px;
        height: 60px;
        font-size: 1.8em;
      }
      
      .touch-grid {
        grid-template-columns: 60px 60px 60px;
        grid-template-rows: 60px;
        gap: 12px;
      }
    }

    /* Ocultar controles en desktop por defecto */
    /* @media (min-width: 769px) {
      .touch-controls {
        display: none !important;
      }
    } */

    #demo-banner-div {
      position: fixed;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, 
        rgba(255, 107, 107, 0.9), 
        rgba(255, 69, 69, 0.8));
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: white;
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 1.1em;
      font-weight: 600;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      z-index: 2000;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 
        0 8px 32px rgba(255, 107, 107, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
      animation: demoPulse 3s ease-in-out infinite;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
      letter-spacing: 0.5px;
    }

    @keyframes demoPulse {
      0%, 100% { 
        transform: translateX(-50%) scale(1); 
        box-shadow: 
          0 8px 32px rgba(255, 107, 107, 0.3),
          inset 0 1px 0 rgba(255, 255, 255, 0.2);
      }
      50% { 
        transform: translateX(-50%) scale(1.02); 
        box-shadow: 
          0 12px 40px rgba(255, 107, 107, 0.5),
          inset 0 1px 0 rgba(255, 255, 255, 0.3);
      }
    }

    /* Estilos adicionales para el cursor mejorado */
    #cursor-container {
      pointer-events: none;
    }
    
    /* Efectos de brillo para elementos interactivos */
    .clickable {
      transition: all 0.3s ease;
    }
    
    .clickable:hover {
      filter: brightness(1.2) drop-shadow(0 0 10px rgba(76, 195, 217, 0.5));
    }

    /* Estilo para elementos que están siendo apuntados */
    .cursor-hovering {
      animation: glow 1s ease-in-out infinite alternate;
    }

    @keyframes glow {
      from {
        filter: brightness(1) drop-shadow(0 0 5px rgba(76, 195, 217, 0.3));
      }
      to {
        filter: brightness(1.3) drop-shadow(0 0 15px rgba(76, 195, 217, 0.8));
      }
    }

    /* Ocultar cursor del navegador en la escena VR */
    a-scene {
      cursor: none !important;
    }
  </style>
</head>

<body>
  <div id="demo-banner-div">DEMO - Esta es una versión de prueba</div>
  <!-------- [[CONTROLES TÁCTILES]] -------->
  <?php include ('controles-tactiles.php') ?>

  <a-scene cursor="rayOrigin: mouse" vr-mode-ui="enabled: true">
    <!-- [[LLAMADO DE MODELOS Y TEXTURAS]] -->
    <a-assets>
      <?php include ('modelos-texturas.php') ?>
    </a-assets>
    
    <!--------- [[OBJETOS EN ESCENA]] --------->
    <?php include ('objetos-escena.php') ?>

    <!-- PANEL DE INFORMACIÓN DE PRODUCTOS -->
    <?php include ('panel-informacion.php') ?>

    <!------- [[CÁMARA PRINCIPAL DEL USUARIO]] ------->
    <a-entity id="rig" position="0 1.6 0">
      <a-entity id="main-camera" camera look-controls="touchEnabled: true; reverseMouseDrag: false" wasd-controls position="0 0 0">
        <a-cursor 
          fuse="true" 
          fuse-timeout="1500" 
          color="#4CC3D9"
          raycaster="objects: .clickable"
          animation__fusing="property: scale; from: 1 1 1; to: 0.5 0.5 0.5; startEvents: fusing"
          animation__mouseleave="property: scale; to: 1 1 1; startEvents: mouseleave"
        ></a-cursor>
      </a-entity>
    </a-entity>

    <a-sky color="#ECECEC"></a-sky>
  </a-scene>

  <!-- SCRIPT DE CÁMARA, MENÚ Y TECLADO TOUCH -->
  <script src="main.js"></script>
  <!-- SCRIPT DINÁMICO DE PRODUCTOS -->
  <script src="productos.js"></script>
  <!-- SCRIPT DEL SISTEMA DE MOSTRADORES -->
  <script src="mostrador.js"></script>

</body>

</html>