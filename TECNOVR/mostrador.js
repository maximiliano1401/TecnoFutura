// Sistema Modular de 3 Mostradores por Categoría - Filosofía KISS
document.addEventListener('DOMContentLoaded', () => {

  // Configuración de productos por categoría
  const configuracionCategorias = {
    1: { // Teléfonos
      productos: [
        { id: 'cube1', color: '#4CC3D9', productId: 1 }, // iPhone 15 Pro Max
        { id: 'celular1', color: '#00BFFF', productId: 6 }, // Samsung Galaxy S23 Ultra
        { id: 'cube2', color: '#1E90FF', productId: 7 },  // Xiaomi 13T
        { id: 'phone_cube1', color: '#87CEEB', productId: 8 }, // Otro teléfono
        { id: 'phone_cube2', color: '#4169E1', productId: 10 }, // iPhone SE
        { id: 'phone_cube3', color: '#0080FF', productId: 11 }  // Samsung A54
      ]
    },
    2: { // Cómputo  
      productos: [
        { id: 'laptop1', color: '#EF2D5E', productId: 19 }, // HP Pavilion x360
        { id: 'lapgamer1', color: '#FF1493', productId: 20 }, // Dell Inspiron 14
        { id: 'pc1', color: '#DC143C', productId: 5 },  // PC Gamer Fury
        { id: 'comp_cube1', color: '#FF6B6B', productId: 21 }, // Lenovo ThinkPad
        { id: 'comp_cube2', color: '#C44569', productId: 22 }, // MacBook Air
        { id: 'comp_cube3', color: '#F8B500', productId: 23 }, // ASUS ROG
        { id: 'comp_cube4', color: '#FF4757', productId: 24 }  // Acer Aspire
      ]
    },
    3: { // Televisores
      productos: [
        { id: 'cube3', color: '#FFC65D', productId: 3 }, // Samsung TV 50 4K
        { id: 'monitor1', color: '#FFD700', productId: 34 }, // Samsung S90C
        { id: 'monitor2', color: '#FFA500', productId: 38 }, // Sony X90J
        { id: 'tv_cube1', color: '#FFEB3B', productId: 35 }, // LG OLED
        { id: 'tv_cube2', color: '#FF9800', productId: 36 }, // Sony Bravia
        { id: 'tv_cube3', color: '#FF5722', productId: 37 }  // TCL QLED
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
        const data = await response.json();
        console.log(`Datos obtenidos para ${currentProduct.id}:`, data); // Debug
        return data;
      } catch (error) {
        console.error(`Error al obtener producto categoría ${this.categoriaId}:`, error);
        return null;
      }
    }

    updateProductDisplay() {
      const currentProduct = this.productos[this.currentIndex];
      
      if (this.productDisplay) {
        // Cambiar color del cubo display del mostrador
        this.productDisplay.setAttribute('color', currentProduct.color);
        
        // Animación de cambio
        this.productDisplay.emit('change-product');
      }
      
      // NO modificar otros elementos de la escena para evitar cubos duplicados
      console.log(`Mostrador ${this.categoriaId} mostrando: ${currentProduct.id} (${currentProduct.color})`);
    }

    async updateInfoPanel() {
      const currentProduct = this.productos[this.currentIndex];
      this.currentProductData = await this.getProductData(currentProduct);
      
      if (!this.currentProductData) {
        console.error(`No se pudieron obtener datos para el producto: ${currentProduct.id}`);
        return;
      }
      
      console.log(`Actualizando panel ${this.categoriaId} con:`, this.currentProductData); // Debug
      
      // Actualizar contenido del panel
      if (this.fixedName) this.fixedName.setAttribute('value', this.currentProductData.Nombre || 'Producto');
      if (this.fixedPrice) this.fixedPrice.setAttribute('value', `$${this.currentProductData.Precio || '0.00'}`);
      if (this.fixedImage) this.fixedImage.setAttribute('src', this.currentProductData.Ruta1 || '');
      
      // Descripción truncada
      if (this.fixedDesc) {
        let desc = this.currentProductData.Descripcion || 'Sin descripción';
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
        window.open(`https://tecnofutura.shop/HTML/producto.php?id_producto=${this.currentProductData.ID_Producto}`, '_blank');
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
});