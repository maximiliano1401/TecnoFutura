// Sistema de Mostrador Fijo - Filosofía KISS
document.addEventListener('DOMContentLoaded', () => {
  
  // Configuración de productos (usando los 3 cubos originales)
  const productos = [
    { id: 'cube1', color: '#4CC3D9', productId: 1 }, // iPhone 15 Pro Max
    { id: 'cube2', color: '#EF2D5E', productId: 2 }, // JBL TUNE 520
    { id: 'cube3', color: '#FFC65D', productId: 3 }  // Samsung TV 50 4K
  ];
  
  let currentIndex = 0;
  let currentProductData = null;
  
  // Referencias a elementos
  const productDisplay = document.querySelector('#product-display');
  const btnAnterior = document.querySelector('#btn-anterior');
  const btnSiguiente = document.querySelector('#btn-siguiente');
  const detailsBtn = document.querySelector('#fixed-details-btn');
  
  // Referencias al panel fijo
  const fixedName = document.querySelector('#fixed-product-name');
  const fixedPrice = document.querySelector('#fixed-product-price');
  const fixedDesc = document.querySelector('#fixed-product-description');
  const fixedImage = document.querySelector('#fixed-product-image');
  const fixedCounter = document.querySelector('#fixed-product-counter');

  // Función para obtener datos de un producto
  async function getProductData(productId) {
    try {
      const response = await fetch(`get_product.php?id=${productos[productId - 1].id}`);
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error al obtener producto:', error);
      return null;
    }
  }

  // Función para actualizar el cubo mostrado
  function updateProductDisplay() {
    const currentProduct = productos[currentIndex];
    
    if (productDisplay) {
      // Cambiar color del cubo
      productDisplay.setAttribute('color', currentProduct.color);
      
      // Animación de cambio
      productDisplay.emit('change-product');
    }
  }

  // Función para actualizar el panel de información
  async function updateInfoPanel() {
    const currentProduct = productos[currentIndex];
    currentProductData = await getProductData(currentProduct.productId);
    
    if (!currentProductData) return;
    
    // Actualizar contenido del panel
    if (fixedName) fixedName.setAttribute('value', currentProductData.Nombre || 'Producto');
    if (fixedPrice) fixedPrice.setAttribute('value', `$${currentProductData.Precio || '0.00'}`);
    if (fixedImage) fixedImage.setAttribute('src', currentProductData.Ruta1 || '');
    
    // Descripción truncada
    if (fixedDesc) {
      let desc = currentProductData.Descripcion || 'Sin descripción';
      if (desc.length > 150) desc = desc.substring(0, 147) + '...';
      fixedDesc.setAttribute('value', desc);
    }
    
    // Contador
    if (fixedCounter) {
      fixedCounter.setAttribute('value', `${currentIndex + 1} / ${productos.length}`);
    }
  }

  // Función para ir al producto anterior
  function previousProduct() {
    currentIndex = (currentIndex - 1 + productos.length) % productos.length;
    updateProductDisplay();
    updateInfoPanel();
  }

  // Función para ir al producto siguiente
  function nextProduct() {
    currentIndex = (currentIndex + 1) % productos.length;
    updateProductDisplay();
    updateInfoPanel();
  }

  // Función para abrir página de detalles
  function openProductDetails() {
    if (currentProductData && currentProductData.ID_Producto) {
      window.open(`https://tecnofutura.shop/HTML/producto.php?id_producto=${currentProductData.ID_Producto}`, '_blank');
    }
  }

  // Event listeners para los botones
  if (btnAnterior) {
    btnAnterior.addEventListener('click', () => {
      console.log('Clic en anterior');
      previousProduct();
    });
  }

  if (btnSiguiente) {
    btnSiguiente.addEventListener('click', () => {
      console.log('Clic en siguiente');
      nextProduct();
    });
  }

  if (detailsBtn) {
    detailsBtn.addEventListener('click', () => {
      console.log('Clic en ver detalles');
      openProductDetails();
    });
  }

  // Control por teclado
  document.addEventListener('keydown', (event) => {
    switch(event.key) {
      case 'ArrowLeft':
        event.preventDefault();
        previousProduct();
        break;
      case 'ArrowRight':
        event.preventDefault();
        nextProduct();
        break;
    }
  });

  // Agregar animación de cambio al cubo
  if (productDisplay) {
    productDisplay.setAttribute('animation__change', 
      'property: scale; from: 1.2 1.2 1.2; to: 1.4 1.4 1.4; dur: 200; dir: alternate; startEvents: change-product');
  }

  // Inicialización: cargar el primer producto
  setTimeout(() => {
    updateProductDisplay();
    updateInfoPanel();
    console.log('Sistema de mostrador fijo inicializado');
  }, 1000);

});