// ========== FUNCIONES DE DETECCIÓN Y UTILIDAD ==========
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

// ========== FUNCIÓN DE VIBRACIÓN TÁCTIL ==========
function triggerVibration(duration = 50) {
  // Verificar si el dispositivo soporta vibración
  if ('vibrate' in navigator) {
    try {
      navigator.vibrate(duration);
    } catch (e) {
      console.log('Vibración no disponible:', e);
    }
  }
}

// ========== EFECTOS VISUALES PARA BOTONES ==========
function createRippleEffect(button, x, y) {
  const ripple = document.createElement('div');
  const rect = button.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  
  ripple.style.position = 'absolute';
  ripple.style.width = size + 'px';
  ripple.style.height = size + 'px';
  ripple.style.left = (x - rect.left - size / 2) + 'px';
  ripple.style.top = (y - rect.top - size / 2) + 'px';
  ripple.style.background = 'rgba(255, 255, 255, 0.4)';
  ripple.style.borderRadius = '50%';
  ripple.style.transform = 'scale(0)';
  ripple.style.animation = 'ripple 0.6s ease-out';
  ripple.style.pointerEvents = 'none';
  
  button.style.position = 'relative';
  button.style.overflow = 'hidden';
  button.appendChild(ripple);
  
  setTimeout(() => {
    ripple.remove();
  }, 600);
}

// ========== CONFIGURACIÓN DE EVENTOS TÁCTILES MEJORADOS ==========
function addTouchEvents(btnId, key) {
  var btn = document.getElementById(btnId);
  if (!btn) return;
  
  // Variables para controlar el estado del botón
  let isPressed = false;
  
  // Eventos táctiles con vibración y efectos
  btn.addEventListener('touchstart', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (!isPressed) {
      isPressed = true;
      
      // Vibración táctil para móviles
      triggerVibration(30); // Vibración corta de 30ms
      
      // Crear efecto ripple
      const touch = e.touches[0];
      createRippleEffect(btn, touch.clientX, touch.clientY);
      
      // Simular tecla y cambiar estilo
      simulateKey(key, 'keydown');
      btn.classList.add('btn-pressed');
      
      console.log(`Botón ${btnId} presionado - Vibración activada`);
    }
  });
  
  btn.addEventListener('touchend', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (isPressed) {
      isPressed = false;
      
      // Vibración más suave al soltar
      triggerVibration(20); // Vibración muy corta de 20ms
      
      // Simular liberación de tecla y restaurar estilo
      simulateKey(key, 'keyup');
      btn.classList.remove('btn-pressed');
      
      console.log(`Botón ${btnId} liberado`);
    }
  });
  
  btn.addEventListener('touchcancel', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (isPressed) {
      isPressed = false;
      simulateKey(key, 'keyup');
      btn.classList.remove('btn-pressed');
    }
  });

  // También agregar eventos de mouse para pruebas en desktop
  btn.addEventListener('mousedown', function(e) {
    e.preventDefault();
    if (!isPressed) {
      isPressed = true;
      createRippleEffect(btn, e.clientX, e.clientY);
      simulateKey(key, 'keydown');
      btn.classList.add('btn-pressed');
    }
  });
  
  btn.addEventListener('mouseup', function(e) {
    e.preventDefault();
    if (isPressed) {
      isPressed = false;
      simulateKey(key, 'keyup');
      btn.classList.remove('btn-pressed');
    }
  });

  btn.addEventListener('mouseleave', function(e) {
    if (isPressed) {
      isPressed = false;
      simulateKey(key, 'keyup');
      btn.classList.remove('btn-pressed');
    }
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