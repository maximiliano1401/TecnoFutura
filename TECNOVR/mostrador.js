// Sistema Modular de 3 Mostradores por Categoría - Filosofía KISS
document.addEventListener('DOMContentLoaded', () => {

  // Configuración de productos por categoría
  const configuracionCategorias = {
    1: { // Teléfonos - Modelos 3D reales
      productos: [
        { id: 'mobile1', color: '#4CC3D9', productId: 1 },  // iPhone 15 Pro Max
        { id: 'mobile3', color: '#1E90FF', productId: 7 }   // Xiaomi 13T
      ]
    },
    2: { // Cómputo - Modelos 3D reales
      productos: [
        { id: 'pc1', color: '#EF2D5E', productId: 19 },     // HP Pavilion x360
        { id: 'laptop1', color: '#FF6B6B', productId: 20 }  // Laptop modelo 1
      ]
    },
    3: { // Televisores - Modelos 3D reales
      productos: [
        { id: 'tv1', color: '#FFC65D', productId: 3 },      // Samsung TV 50 4K
        { id: 'tv2', color: '#FFD700', productId: 34 },     // Samsung S90C
        { id: 'tv3', color: '#FFA500', productId: 38 },     // Sony X90J
        { id: 'tv4', color: '#FFEB3B', productId: 35 },     // LG OLED
        { id: 'monitor1', color: '#FF4757', productId: 36 },// Monitor 1
        { id: 'monitor2', color: '#FFB040', productId: 37 } // Monitor 2
      ]
    }
  };

  // Clase para manejar cada mostrador independientemente
  class MostradorCategoria {
    constructor(categoriaId) {
      this.categoriaId = categoriaId;
      this.currentIndex = 0;
      this.productos = configuracionCategorias[categoriaId].productos;
      this.currentProductData = null;
      
      // Referencias a elementos DOM
      this.productDisplay = document.querySelector(`#product-display-${categoriaId}`);
      this.btnAnterior = document.querySelector(`#btn-anterior-${categoriaId}`);
      this.btnSiguiente = document.querySelector(`#btn-siguiente-${categoriaId}`);
      this.detailsBtn = document.querySelector(`#fixed-details-btn-${categoriaId}`);
      
      // Referencias al panel de información
      this.fixedName = document.querySelector(`#fixed-product-name-${categoriaId}`);
      this.fixedPrice = document.querySelector(`#fixed-product-price-${categoriaId}`);
      this.fixedDesc = document.querySelector(`#fixed-product-description-${categoriaId}`);
      this.fixedImage = document.querySelector(`#fixed-product-image-${categoriaId}`);
      this.fixedCounter = document.querySelector(`#fixed-product-counter-${categoriaId}`);
      
      this.init();
    }

    async getProductData(currentProduct) {
      try {
        // Usar el ID del objeto para obtener los datos del producto
        const response = await fetch(`get_product.php?id=${currentProduct.id}`);
        
        // Verificar que la respuesta sea exitosa
        if (!response.ok) {
          console.error(`Error HTTP: ${response.status} para ${currentProduct.id}`);
          return null;
        }
        
        // Obtener el texto de la respuesta primero
        const textData = await response.text();
        
        // Intentar parsear como JSON
        try {
          const data = JSON.parse(textData);
          
          // Verificar si hay error en la respuesta
          if (data.error) {
            console.error(`Error del servidor para ${currentProduct.id}:`, data.error);
            return null;
          }
          
          console.log(`Datos obtenidos para ${currentProduct.id}:`, data);
          return data;
        } catch (parseError) {
          console.error(`Error al parsear JSON para ${currentProduct.id}:`, parseError);
          console.error('Respuesta del servidor:', textData);
          return null;
        }
      } catch (error) {
        console.error(`Error al obtener producto categoría ${this.categoriaId}:`, error);
        return null;
      }
    }

    updateProductDisplay() {
      const currentProduct = this.productos[this.currentIndex];
      
      // Cambiar color del cubo display del mostrador (si existe)
      if (this.productDisplay) {
        this.productDisplay.setAttribute('color', currentProduct.color);
        this.productDisplay.emit('change-product');
      }
      
      // Gestionar visibilidad de modelos 3D
      // Ocultar todos los productos de esta categoría
      this.productos.forEach(producto => {
        const entity = document.querySelector(`#${producto.id}`);
        if (entity) {
          entity.setAttribute('visible', 'false');
        }
      });
      
      // Mostrar solo el producto actual
      const currentEntity = document.querySelector(`#${currentProduct.id}`);
      if (currentEntity) {
        currentEntity.setAttribute('visible', 'true');
        
        // Posicionar el modelo sobre el mostrador
        const mostradorPosition = this.getDisplayPosition();
        currentEntity.setAttribute('position', mostradorPosition);
        
        // Agregar rotación automática
        currentEntity.setAttribute('animation', 
          'property: rotation; to: 0 360 0; dur: 8000; loop: true; easing: linear');
        
        console.log(`Modelo 3D ${currentProduct.id} visible sobre mostrador ${this.categoriaId}`);
      }
      
      console.log(`Mostrador ${this.categoriaId} mostrando: ${currentProduct.id} (${currentProduct.color})`);
    }
    
    getDisplayPosition() {
      // Posiciones sobre cada mostrador según categoría
      const positions = {
        1: '-2.490 2.0 -2.367',  // Teléfonos
        2: '6.171 2.0 3.542',     // Cómputo
        3: '-4.047 2.0 17.205'    // Televisores
      };
      return positions[this.categoriaId] || '0 2 0';
    }

    async updateInfoPanel() {
      const currentProduct = this.productos[this.currentIndex];
      this.currentProductData = await this.getProductData(currentProduct);
      
      if (!this.currentProductData) {
        console.error(`No se pudieron obtener datos para el producto: ${currentProduct.id}`);
        
        // Mostrar información de error en el panel
        if (this.fixedName) this.fixedName.setAttribute('value', 'Producto no disponible');
        if (this.fixedPrice) this.fixedPrice.setAttribute('value', '$0.00');
        if (this.fixedDesc) this.fixedDesc.setAttribute('value', 'No se pudo cargar la información del producto');
        if (this.fixedImage) this.fixedImage.setAttribute('src', '');
        if (this.fixedCounter) {
          this.fixedCounter.setAttribute('value', `${this.currentIndex + 1}/${this.productos.length}`);
        }
        return;
      }
      
      console.log(`Actualizando panel ${this.categoriaId} con:`, this.currentProductData);
      
      // Actualizar contenido del panel solo si hay datos válidos
      if (this.fixedName && this.currentProductData.Nombre) {
        this.fixedName.setAttribute('value', this.currentProductData.Nombre);
      }
      
      if (this.fixedPrice && this.currentProductData.Precio) {
        this.fixedPrice.setAttribute('value', `$${this.currentProductData.Precio}`);
      }
      
      if (this.fixedImage && this.currentProductData.Ruta1) {
        // Ajustar ruta de imagen para que funcione desde TECNOVR/
        let imagePath = this.currentProductData.Ruta1;
        if (imagePath.startsWith('../')) {
          imagePath = imagePath.substring(3); // Remover '../'
        }
        this.fixedImage.setAttribute('src', `../${imagePath}`);
      }
      
      // Descripción truncada
      if (this.fixedDesc && this.currentProductData.Descripcion) {
        let desc = this.currentProductData.Descripcion;
        if (desc.length > 120) desc = desc.substring(0, 117) + '...';
        this.fixedDesc.setAttribute('value', desc);
      }
      
      // Contador
      if (this.fixedCounter) {
        this.fixedCounter.setAttribute('value', `${this.currentIndex + 1}/${this.productos.length}`);
      }
    }

    previousProduct() {
      this.currentIndex = (this.currentIndex - 1 + this.productos.length) % this.productos.length;
      this.updateProductDisplay();
      this.updateInfoPanel();
    }

    nextProduct() {
      this.currentIndex = (this.currentIndex + 1) % this.productos.length;
      this.updateProductDisplay();
      this.updateInfoPanel();
    }

    openProductDetails() {
      if (this.currentProductData && this.currentProductData.ID_Producto) {
        // Usar ruta relativa en lugar de URL hardcodeada para compatibilidad con desarrollo local
        const baseUrl = window.location.origin;
        const productUrl = `${baseUrl}/HTML/producto.php?id_producto=${this.currentProductData.ID_Producto}`;
        window.open(productUrl, '_blank');
      }
    }

    init() {
      // Verificar que todos los elementos existen
      console.log(`=== Inicializando Mostrador Categoría ${this.categoriaId} ===`);
      console.log(`Product Display: ${this.productDisplay ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      console.log(`Panel Name: ${this.fixedName ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      console.log(`Panel Price: ${this.fixedPrice ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      console.log(`Panel Desc: ${this.fixedDesc ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      console.log(`Botón Anterior: ${this.btnAnterior ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      console.log(`Botón Siguiente: ${this.btnSiguiente ? 'ENCONTRADO' : 'NO ENCONTRADO'}`);
      
      // Event listeners para botones
      if (this.btnAnterior) {
        this.btnAnterior.addEventListener('click', () => {
          console.log(`Anterior - Categoría ${this.categoriaId}`);
          this.previousProduct();
        });
      }

      if (this.btnSiguiente) {
        this.btnSiguiente.addEventListener('click', () => {
          console.log(`Siguiente - Categoría ${this.categoriaId}`);
          this.nextProduct();
        });
      }

      if (this.detailsBtn) {
        this.detailsBtn.addEventListener('click', () => {
          console.log(`Ver detalles - Categoría ${this.categoriaId}`);
          this.openProductDetails();
        });
      }

      // Agregar animación de cambio
      if (this.productDisplay) {
        this.productDisplay.setAttribute('animation__change', 
          'property: scale; from: 1.2 1.2 1.2; to: 1.4 1.4 1.4; dur: 200; dir: alternate; startEvents: change-product');
      }

      // Inicialización del primer producto
      setTimeout(() => {
        this.updateProductDisplay();
        this.updateInfoPanel();
        console.log(`Mostrador categoría ${this.categoriaId} inicializado completamente`);
      }, 500 * this.categoriaId); // Delay escalonado para evitar sobrecargas
    }
  }

  // Crear las 3 instancias de mostradores
  const mostradorTelefonos = new MostradorCategoria(1);
  const mostradorComputo = new MostradorCategoria(2);
  const mostradorTelevisores = new MostradorCategoria(3);

  // Control global por teclado (opcional)
  let selectedMostrador = 1; // Por defecto teléfonos

  document.addEventListener('keydown', (event) => {
    const mostradores = [mostradorTelefonos, mostradorComputo, mostradorTelevisores];
    const current = mostradores[selectedMostrador - 1];
    
    switch(event.key) {
      case 'ArrowLeft':
        event.preventDefault();
        current.previousProduct();
        break;
      case 'ArrowRight':
        event.preventDefault();
        current.nextProduct();
        break;
      case '1':
        selectedMostrador = 1;
        console.log('Mostrador Teléfonos seleccionado');
        break;
      case '2':
        selectedMostrador = 2;
        console.log('Mostrador Cómputo seleccionado');
        break;
      case '3':
        selectedMostrador = 3;
        console.log('Mostrador Televisores seleccionado');
        break;
    }
  });

  console.log('Sistema de 3 mostradores inicializado completamente');
  
  // ========== CONTROLES TÁCTILES PARA MÓVILES ==========
  
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

  function addTouchEvents(btnId, key) {
    var btn = document.getElementById(btnId);
    if (!btn) {
      console.warn(`Botón ${btnId} no encontrado`);
      return;
    }
    
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

  // Inicializar controles táctiles
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
      } else {
        console.warn('Elemento touch-controls no encontrado en el DOM');
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
  }, 500); // Esperar medio segundo para que A-Frame esté listo
  
});