// Script dinámico para todos los productos/cubos
document.addEventListener('DOMContentLoaded', () => {
  const panel = document.querySelector('#product-info-panel');
  const nameText = document.querySelector('#product-name');
  const priceText = document.querySelector('#product-price');
  const descText = document.querySelector('#product-description');
  const imageEl = document.querySelector('#product-image');
  const products = document.querySelectorAll('.product');
  let currentProductId = null; // Variable para almacenar el ID actual del producto

  // Función para mostrar el panel enfrente de la cámara
  // function showPanelInFrontOfCamera(panel) {
  //   const camera = document.querySelector('[camera]');
  //   if (!camera) return;
  //   const cameraObj = camera.object3D;

  //   // Distancia deseada frente a la cámara
  //   const distance = 2;

  //   // Obtén la posición global de la cámara
  //   const cameraWorldPos = new THREE.Vector3();
  //   cameraObj.getWorldPosition(cameraWorldPos);

  //   // Obtén la dirección hacia adelante de la cámara
  //   const cameraWorldDir = new THREE.Vector3();
  //   cameraObj.getWorldDirection(cameraWorldDir);

  //   // Calcula la nueva posición para el panel (enfrente del usuario)
  //   const panelPos = cameraWorldPos.clone().add(cameraWorldDir.multiplyScalar(distance));
  //   panel.setAttribute('position', `${panelPos.x} ${panelPos.y} ${panelPos.z}`);

  //   // Haz que el panel mire hacia la cámara
  //   panel.object3D.lookAt(cameraWorldPos);
  //   panel.object3D.rotation.y += Math.PI; // Gira 180° en Y para que el frente del panel mire al usuario
  // }

  // Función para mostrar el panel detrás de la cámara
  function showPanelBehindCamera(panel) {
    const camera = document.querySelector('[camera]');
    if (!camera) return;
    const cameraObj = camera.object3D;

    // Distancia deseada detrás de la cámara
    const distance = 2;

    // Obtén la posición global de la cámara
    const cameraWorldPos = new THREE.Vector3();
    cameraObj.getWorldPosition(cameraWorldPos);

    // Obtén la dirección hacia adelante de la cámara
    const cameraWorldDir = new THREE.Vector3();
    cameraObj.getWorldDirection(cameraWorldDir);

    // Invierte la dirección para colocar el panel detrás
    const behindDir = cameraWorldDir.clone().negate();

    // Calcula la nueva posición para el panel (detrás del usuario)
    const panelPos = cameraWorldPos.clone().add(behindDir.multiplyScalar(distance));
    panel.setAttribute('position', `${panelPos.x} ${panelPos.y} ${panelPos.z}`);

    // Haz que el panel mire hacia la cámara
    panel.object3D.lookAt(cameraWorldPos);
  }

  products.forEach(product => {
    product.addEventListener('click', () => {
      // Obtiene el id de producto para el fetch
      const productId = product.getAttribute('data-product');
      fetch(`get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
          // Almacenar el ID del producto para el botón de detalles
          currentProductId = data.ID_Producto;
          
          nameText.setAttribute('value', `${data.Nombre || ''}`);
          priceText.setAttribute('value', `Precio: $${data.Precio || ''}`);

          // Recorta la descripción si es muy larga
          let desc = data.Descripcion || '';
          if (desc.length > 180) desc = desc.substring(0, 177) + '...';
          descText.setAttribute('value', `Descripción: ${desc}`);

          imageEl.setAttribute('src', data.Ruta1 || '');
          showPanelBehindCamera(panel); // o la función que uses para mostrar el panel
          panel.setAttribute('visible', true);
          // Disparar animación de aparición
          panel.emit('panelshow');
        })
        .catch(error => {
          nameText.setAttribute('value', 'Error al cargar producto');
          priceText.setAttribute('value', '');
          descText.setAttribute('value', '');
          imageEl.setAttribute('src', '');
          showPanelBehindCamera(panel);
          panel.setAttribute('visible', true);
          // Disparar animación de aparición
          panel.emit('panelshow');
        });
    });

    // Remover el mouseleave que ocultaba el panel
    // product.addEventListener('mouseleave', () => {
    //   panel.setAttribute('visible', false);
    // });
  });

  // Agregar funcionalidad para cerrar el panel
  const closeBtn = document.querySelector('#close-panel-btn');
  const detailsBtn = document.querySelector('#details-btn');
  
  // Cerrar con clic en el botón X
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      panel.emit('panelhide');
      setTimeout(() => {
        panel.setAttribute('visible', false);
      }, 300);
    });
  }

  // Funcionalidad del botón "Ver más detalles"
  if (detailsBtn) {
    detailsBtn.addEventListener('click', () => {
      if (currentProductId) {
        // Abrir la página del producto en una nueva pestaña
        window.open(`https://tecnofutura.shop/HTML/producto.php?id_producto=${currentProductId}`, '_blank');
      }
    });
  }
  
  // Cerrar con clic en el panel mismo (mantener funcionalidad original)
  panel.addEventListener('click', () => {
    panel.emit('panelhide');
    setTimeout(() => {
      panel.setAttribute('visible', false);
    }, 300); // Esperar a que termine la animación
  });

  // Cerrar con tecla Escape
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && panel.getAttribute('visible') === 'true') {
      panel.emit('panelhide');
      setTimeout(() => {
        panel.setAttribute('visible', false);
      }, 300);
    }
  });
});