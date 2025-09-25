<!-- PANEL DE INFORMACIÓN FIJO PARA MOSTRADOR -->
<a-entity id="fixed-info-panel" position="5 2 -4" rotation="0 -30 0">
  <!-- Panel principal -->
  <a-plane width="2.5" height="2.0" 
           color="#1a1a2e" 
           opacity="0.9"
           material="transparent: true">
  </a-plane>
  
  <!-- Borde brillante -->
  <a-plane width="2.55" height="2.05" 
           color="#4CC3D9" 
           opacity="0.4"
           position="0 0 -0.01"
           material="transparent: true">
  </a-plane>
  
  <!-- Imagen del producto -->
  <a-plane width="1.0" height="1.0" 
           color="#2a2a3e" 
           opacity="0.8"
           position="-0.6 0.3 0.01">
  </a-plane>
  
  <a-image id="fixed-product-image" 
           position="-0.6 0.3 0.02" 
           width="0.9" 
           height="0.9" 
           src="">
  </a-image>
  
  <!-- Título del producto -->
  <a-text id="fixed-product-name" 
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="Producto" 
          color="#FFFFFF" 
          position="0.3 0.7 0.01" 
          width="1.5" 
          align="left"
          baseline="top" 
          wrap-count="25" 
          font-size="0.22">
  </a-text>
  
  <!-- Precio -->
  <a-text id="fixed-product-price"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="$0.00" 
          color="#4ECDC4" 
          position="0.3 0.45 0.01" 
          width="1.5" 
          align="left"
          baseline="top" 
          font-size="0.25">
  </a-text>
  
  <!-- Línea separadora -->
  <a-plane width="1.8" height="0.005" 
           color="#4CC3D9" 
           opacity="0.6"
           position="0.3 0.3 0.01">
  </a-plane>
  
  <!-- Descripción -->
  <a-text id="fixed-product-description"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="Descripción del producto" 
          color="#E0E0E0" 
          position="0.3 0.15 0.01" 
          width="1.2" 
          align="left"
          baseline="top" 
          wrap-count="30" 
          height="0.8" 
          line-height="45" 
          font-size="0.14">
  </a-text>
  
  <!-- Contador de productos -->
  <a-text id="fixed-product-counter"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="1 / 3" 
          color="#FF6B6B" 
          position="0.3 -0.4 0.01" 
          width="1.5" 
          align="left"
          baseline="top" 
          font-size="0.18">
  </a-text>
  
  <!-- Botón Ver detalles -->
  <a-plane id="fixed-details-btn"
           class="clickable"
           width="1.5" 
           height="0.2" 
           color="#4ECDC4" 
           opacity="0.8"
           position="0.3 -0.7 0.03"
           animation__detailshover="property: scale; from: 1 1 1; to: 1.05 1.05 1.05; dur: 200; startEvents: mouseenter"
           animation__detailsleave="property: scale; from: 1.05 1.05 1.05; to: 1 1 1; dur: 200; startEvents: mouseleave">
    
    <a-text value="🔍 Ver detalles completos"
            font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
            color="#FFFFFF" 
            position="0 0 0.01" 
            width="2" 
            align="center"
            baseline="center" 
            font-size="0.35">
    </a-text>
  </a-plane>
  
  <!-- Título del panel -->
  <a-text value="INFORMACIÓN DEL PRODUCTO"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          color="#4CC3D9" 
          position="0 0.9 0.01" 
          width="2" 
          align="center"
          baseline="center" 
          font-size="0.16">
  </a-text>
</a-entity>