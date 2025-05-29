<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecnoVR</title>
    <!-- A-Frame Framework -->
    <script src="https://aframe.io/releases/1.7.1/aframe.min.js"></script>
    <style>
      /* Botones touch para móvil */
      .touch-controls {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        display: flex;
        gap: 20px;
        pointer-events: none;
      }
      .touch-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(44,195,217,0.8);
        color: #fff;
        font-size: 2em;
        border: none;
        pointer-events: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
      }
    </style>
</head>

<body>
    <!-- Botones touch solo para móvil -->
    <div id="touch-controls" class="touch-controls" style="display:none;">
      <button class="touch-btn" id="btn-forward">&#8593;</button>
      <button class="touch-btn" id="btn-left">&#8592;</button>
      <button class="touch-btn" id="btn-back">&#8595;</button>
      <button class="touch-btn" id="btn-right">&#8594;</button>
    </div>

    <!-- Ejemplo básico de escena A-Frame con botón de VR siempre visible -->
    <a-scene cursor="rayOrigin: mouse" vr-mode-ui="enabled: true">
        
    <a-assets>
      <a-asset-item id="mac-obj" src="assets/laptop1/mac laptop.obj"></a-asset-item>
      <a-asset-item id="mac-mtl" src="assets/laptop1/mac laptop.mtl"></a-asset-item>

      <a-asset-item id="rack-obj" src="assets/rack/ElectronicRack.obj"></a-asset-item>
      <a-asset-item id="rack-mtl" src="assets/rack/ElectronicRack.mtl"></a-asset-item>
    
      <a-asset-item id="asus-obj" src="assets/laptop2/Laptop_Obj/Laptop.obj"></a-asset-item>
      <a-asset-item id="asus-mtl" src="assets/laptop2/Laptop_Obj/Laptop.mtl"></a-asset-item>

      <a-asset-item id="store-obj" src="assets/Store/Store.obj"></a-asset-item>
      <a-asset-item id="store-mtl" src="assets/Store/Store.mtl"></a-asset-item>

    </a-assets>

    <!-- <a-entity obj-model="obj: #mac-obj; mtl: #mac-mtl" position="0 0 0" scale="1 1 1"></a-entity> -->
    <!-- <a-entity obj-model="obj: #rack-obj; mtl: #rack-mtl" position="1 1 1" scale="1 1 1"></a-entity> -->
    <!-- <a-entity obj-model="obj: #asus-obj; mtl: #asus-mtl" position="2 2 2" scale="1 1 1"></a-entity> -->
    
    <a-entity obj-model="obj: #store-obj; mtl: #store-mtl" position="-250 -10 150" scale="0.5 0.5 0.5" rotation="-90 0 0"></a-entity>
        
        <!-- Cámara con cursor para selección por mirada -->
        <a-entity id="rig" position="0 1.6 0">
            <a-entity id="main-camera" camera look-controls="touchEnabled: true; reverseMouseDrag: false" wasd-controls>
                <a-cursor 
                    fuse="true" 
                    fuse-timeout="1000" 
                    color="#4CC3D9"
                    raycaster="objects: .clickable">
                </a-cursor>
                <!-- Botón para abrir el menú -->
                <a-image id="menu-btn" src="https://cdn-icons-png.flaticon.com/512/1828/1828859.png"
                         position="0.7 0.4 -1" width="0.15" height="0.15"
                         class="clickable"
                         event-set__enter="_event: mouseenter; scale: 1.2 1.2 1"
                         event-set__leave="_event: mouseleave; scale: 1 1 1"></a-image>
                <!-- Menú de usuario anclado a la cámara, oculto al inicio -->
                <a-entity id="user-menu" visible="false" position="0 0 -1.2">
                    <a-plane width="1.5" height="0.8" color="#222" opacity="0.85" radius="0.1"></a-plane>
                    <a-text value="Menú Usuario" color="#FFF" position="0 0.28 0.01" align="center" width="1.4"></a-text>
                    <a-text value="Perfil" color="#4CC3D9" position="0 0.10 0.01" align="center" width="1"
                            class="clickable" 
                            event-set__enter="_event: mouseenter; color: #FFF"
                            event-set__leave="_event: mouseleave; color: #4CC3D9"
                            onclick="window.location.href='../HTML/perfil.php'"></a-text>
                    <a-text value="Menú Principal" color="#4CC3D9" position="0 -0.05 0.01" align="center" width="1"
                            class="clickable"
                            event-set__enter="_event: mouseenter; color: #FFF"
                            event-set__leave="_event: mouseleave; color: #4CC3D9"
                            onclick="window.location.href='../HTML/menu.php'"></a-text>
                    <a-text value="Cerrar sesión" color="#EF2D5E" position="0 -0.20 0.01" align="center" width="1"
                            class="clickable"
                            event-set__enter="_event: mouseenter; color: #FFF"
                            event-set__leave="_event: mouseleave; color: #EF2D5E"
                            onclick="window.location.href='../PHP/logout.php'"></a-text>
                    <!-- Botón para cerrar el menú -->
                    <a-image id="close-btn" src="https://cdn-icons-png.flaticon.com/512/1828/1828778.png"
                             position="0.65 0.32 0.02" width="0.08" height="0.08"
                             class="clickable"></a-image>
                </a-entity>
            </a-entity>
        </a-entity>

        <!-- Resto de tu escena -->
        <a-box position="0 1 -3" rotation="0 45 0" color="#4CC3D9"></a-box>
        <a-sphere position="2 1 -5" radius="1.25" color="#EF2D5E"></a-sphere>
        <a-cylinder position="-2 0.75 -4" radius="0.5" height="1.5" color="#FFC65D"></a-cylinder>
        <a-plane position="0 0 -4" rotation="-90 0 0" width="8" height="8" color="#7BC8A4"></a-plane>
        <a-sky color="#ECECEC"></a-sky>
    </a-scene>

    <script>
      // Detecta si es móvil
      function isMobile() {
        return AFRAME.utils.device.isMobile();
      }

      function simulateKey(key, type = 'keydown') {
        var event = new KeyboardEvent(type, {
          key: key,
          code: 'Key' + key.toUpperCase(),
          keyCode: key.toUpperCase().charCodeAt(0),
          which: key.toUpperCase().charCodeAt(0),
          bubbles: true
        });
        document.dispatchEvent(event);
      }

      function addTouchEvents(btnId, key) {
        var btn = document.getElementById(btnId);
        btn.addEventListener('touchstart', function(e) {
          e.preventDefault();
          simulateKey(key, 'keydown');
        });
        btn.addEventListener('touchend', function(e) {
          e.preventDefault();
          simulateKey(key, 'keyup');
        });
        btn.addEventListener('touchcancel', function(e) {
          e.preventDefault();
          simulateKey(key, 'keyup');
        });
      }

      document.addEventListener('DOMContentLoaded', function () {
        var menuBtn = document.querySelector('#menu-btn');
        var userMenu = document.querySelector('#user-menu');
        var closeBtn = document.querySelector('#close-btn');
        var camera = document.querySelector('#main-camera');
        var touchControls = document.getElementById('touch-controls');

        // Mostrar menú al hacer click en el botón
        menuBtn.addEventListener('click', function () {
          userMenu.setAttribute('visible', true);
        });

        // Ocultar menú al hacer click en el botón de cerrar
        closeBtn.addEventListener('click', function () {
          userMenu.setAttribute('visible', false);
        });

        // Cambiar controles según dispositivo
        if (isMobile()) {
          // Mostrar botones touch y mantener wasd-controls
          touchControls.style.display = 'flex';

          // Simular teclas WASD con botones touch
          addTouchEvents('btn-forward', 'w');
          addTouchEvents('btn-back', 's');
          addTouchEvents('btn-left', 'a');
          addTouchEvents('btn-right', 'd');
        } else {
          // PC o VR: mantener wasd-controls y ocultar botones touch
          camera.setAttribute('wasd-controls', '');
          touchControls.style.display = 'none';
        }

        // Opcional: Detectar entrada/salida de VR para cambiar controles si lo deseas
        var scene = document.querySelector('a-scene');
        scene.addEventListener('enter-vr', function () {
          // Puedes personalizar controles aquí si lo necesitas
        });
        scene.addEventListener('exit-vr', function () {
          // Puedes personalizar controles aquí si lo necesitas
        });

        // Establecer rotación inicial de la cámara
        camera.setAttribute('rotation', '0 0 0');
      });
    </script>
</body>

</html>