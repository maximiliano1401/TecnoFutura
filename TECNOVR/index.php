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
    .touch-controls {
      position: fixed;
      bottom: 15px;
      left: 20%;
      transform: translateX(-50%);
      z-index: 1000;
      pointer-events: none;
    }

    .touch-grid {
      display: grid;
      grid-template-columns: 60px 60px 60px;
      grid-template-rows: 60px 60px;
      gap: 10px;
      justify-items: center;
      align-items: center;
    }

    .touch-btn {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: rgba(44, 195, 217, 0.5);
      color: #fff;
      font-size: 2em;
      border: 2px solid rgba(44, 195, 217, 0.7);
      pointer-events: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      transition: all 0.1s ease;
      cursor: pointer;
      touch-action: manipulation;
    }

    .touch-btn:active {
      background: rgba(44, 195, 217, 0.8);
      transform: scale(0.95);
    }

    .touch-row-top {
      display: flex;
      justify-content: center;
      margin-bottom: 5px;
    }

    /* Estilos responsivos para dispositivos móviles */
    @media (max-width: 768px) {
      .touch-controls {
        left: 10%;
        bottom: 20px;
      }
      
      .touch-btn {
        width: 50px;
        height: 50px;
        font-size: 1.5em;
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
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      background-color: rgba(255, 0, 0, 0.8);
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 1.2em;
      z-index: 2000;
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

</body>

</html>