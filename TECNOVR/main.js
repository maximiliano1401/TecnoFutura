 function isMobile() {
      // Verificar si es un dispositivo táctil
      return 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
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
      if (!btn) return;
      
      btn.addEventListener('touchstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        simulateKey(key, 'keydown');
        btn.style.background = 'rgba(44, 195, 217, 0.8)';
      });
      
      btn.addEventListener('touchend', function(e) {
        e.preventDefault();
        e.stopPropagation();
        simulateKey(key, 'keyup');
        btn.style.background = 'rgba(44, 195, 217, 0.5)';
      });
      
      btn.addEventListener('touchcancel', function(e) {
        e.preventDefault();
        e.stopPropagation();
        simulateKey(key, 'keyup');
        btn.style.background = 'rgba(44, 195, 217, 0.5)';
      });

      // También agregar eventos de mouse para pruebas en desktop
      btn.addEventListener('mousedown', function(e) {
        e.preventDefault();
        simulateKey(key, 'keydown');
        btn.style.background = 'rgba(44, 195, 217, 0.8)';
      });
      
      btn.addEventListener('mouseup', function(e) {
        e.preventDefault();
        simulateKey(key, 'keyup');
        btn.style.background = 'rgba(44, 195, 217, 0.5)';
      });
    }

    // Esperar a que A-Frame esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
      // Esperar un momento adicional para asegurar que A-Frame esté listo
      setTimeout(function() {
        var touchControls = document.getElementById('touch-controls');
        var camera = document.querySelector('#main-camera');

        if (isMobile()) {
          console.log('Dispositivo móvil detectado - Mostrando controles táctiles');
          if (touchControls) {
            touchControls.style.display = 'grid';
            
            // Configurar eventos táctiles
            addTouchEvents('btn-forward', 'w');
            addTouchEvents('btn-back', 's');
            addTouchEvents('btn-left', 'a');
            addTouchEvents('btn-right', 'd');
          }
        } else {
          console.log('Dispositivo desktop detectado - Ocultando controles táctiles');
          if (touchControls) {
            touchControls.style.display = 'none';
          }
        }

        if (camera) {
          camera.setAttribute('rotation', '0 0 0');
        }
      }, 100);
    });