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

    document.addEventListener('DOMContentLoaded', function() {
      var menuBtn = document.querySelector('#menu-btn');
      var userMenu = document.querySelector('#user-menu');
      var closeBtn = document.querySelector('#close-btn');
      var camera = document.querySelector('#main-camera');
      var touchControls = document.getElementById('touch-controls');

      menuBtn.addEventListener('click', function() {
        userMenu.setAttribute('visible', true);
      });

      closeBtn.addEventListener('click', function() {
        userMenu.setAttribute('visible', false);
      });

      if (isMobile()) {
        touchControls.style.display = 'grid';
        addTouchEvents('btn-forward', 'w');
        addTouchEvents('btn-back', 's');
        addTouchEvents('btn-left', 'a');
        addTouchEvents('btn-right', 'd');
      } else {
        camera.setAttribute('wasd-controls', '');
        touchControls.style.display = 'none';
      }

      camera.setAttribute('rotation', '0 0 0');
    });