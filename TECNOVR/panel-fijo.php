<!-- PANELES DE INFORMACIÓN FIJOS PARA LOS 3 MOSTRADORES -->

<!-- PANEL 1: TELÉFONOS -->
<a-entity id="fixed-info-panel-1" position="-8 2.5 -1" rotation="0 0 0">
  <!-- Panel principal -->
  <a-plane width="2" height="1.8" color="#1a1a2e" opacity="0.9" material="transparent: true"></a-plane>
  <a-plane width="2.05" height="1.85" color="#4CC3D9" opacity="0.4" position="0 0 -0.01" material="transparent: true"></a-plane>
  
  <!-- Imagen del producto -->
  <a-plane width="0.8" height="0.8" color="#2a2a3e" opacity="0.8" position="-0.5 0.2 0.01"></a-plane>
  <a-image id="fixed-product-image-1" position="-0.5 0.2 0.02" width="0.75" height="0.75" src=""></a-image>
  
  <!-- Información del producto -->
  <a-text id="fixed-product-name-1" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Producto 1" color="#FFFFFF" position="0.1 0.5 0.01" width="1.3" align="left" baseline="top" wrap-count="20" font-size="0.18"></a-text>
  <a-text id="fixed-product-price-1" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="$0.00" color="#4ECDC4" position="0.1 0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.2"></a-text>
  
  <!-- Línea separadora -->
  <a-plane width="1.5" height="0.005" color="#4CC3D9" opacity="0.6" position="0.1 0.15 0.01"></a-plane>
  
  <!-- Descripción -->
  <a-text id="fixed-product-description-1" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Descripción" color="#E0E0E0" position="0.1 0.05 0.01" width="1" align="left" baseline="top" wrap-count="25" height="0.6" line-height="40" font-size="0.11"></a-text>
  
  <!-- Contador y botón -->
  <a-text id="fixed-product-counter-1" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="1/3" color="#FF6B6B" position="0.1 -0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.15"></a-text>
  <a-plane id="fixed-details-btn-1" class="clickable" width="1.2" height="0.15" color="#4ECDC4" opacity="0.8" position="0.1 -0.5 0.03" animation__detailshover="property: scale; from: 1 1 1; to: 1.05 1.05 1.05; dur: 200; startEvents: mouseenter" animation__detailsleave="property: scale; from: 1.05 1.05 1.05; to: 1 1 1; dur: 200; startEvents: mouseleave">
    <a-text value="Ver detalles" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#FFFFFF" position="0 0 0.01" width="2" align="center" baseline="center" font-size="0.3"></a-text>
  </a-plane>
  
  <!-- Título del panel -->
  <a-text value="TELÉFONOS" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#4CC3D9" position="0 0.7 0.01" width="2" align="center" baseline="center" font-size="0.14"></a-text>
</a-entity>

<!-- PANEL 2: CÓMPUTO -->
<a-entity id="fixed-info-panel-2" position="0 2.5 -1" rotation="0 0 0">
  <!-- Panel principal -->
  <a-plane width="2" height="1.8" color="#1a1a2e" opacity="0.9" material="transparent: true"></a-plane>
  <a-plane width="2.05" height="1.85" color="#EF2D5E" opacity="0.4" position="0 0 -0.01" material="transparent: true"></a-plane>
  
  <!-- Imagen del producto -->
  <a-plane width="0.8" height="0.8" color="#2a2a3e" opacity="0.8" position="-0.5 0.2 0.01"></a-plane>
  <a-image id="fixed-product-image-2" position="-0.5 0.2 0.02" width="0.75" height="0.75" src=""></a-image>
  
  <!-- Información del producto -->
  <a-text id="fixed-product-name-2" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Producto 2" color="#FFFFFF" position="0.1 0.5 0.01" width="1.3" align="left" baseline="top" wrap-count="20" font-size="0.18"></a-text>
  <a-text id="fixed-product-price-2" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="$0.00" color="#4ECDC4" position="0.1 0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.2"></a-text>
  
  <!-- Línea separadora -->
  <a-plane width="1.5" height="0.005" color="#EF2D5E" opacity="0.6" position="0.1 0.15 0.01"></a-plane>
  
  <!-- Descripción -->
  <a-text id="fixed-product-description-2" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Descripción" color="#E0E0E0" position="0.1 0.05 0.01" width="1" align="left" baseline="top" wrap-count="25" height="0.6" line-height="40" font-size="0.11"></a-text>
  
  <!-- Contador y botón -->
  <a-text id="fixed-product-counter-2" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="1/3" color="#FF6B6B" position="0.1 -0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.15"></a-text>
  <a-plane id="fixed-details-btn-2" class="clickable" width="1.2" height="0.15" color="#4ECDC4" opacity="0.8" position="0.1 -0.5 0.03" animation__detailshover="property: scale; from: 1 1 1; to: 1.05 1.05 1.05; dur: 200; startEvents: mouseenter" animation__detailsleave="property: scale; from: 1.05 1.05 1.05; to: 1 1 1; dur: 200; startEvents: mouseleave">
    <a-text value="Ver detalles" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#FFFFFF" position="0 0 0.01" width="2" align="center" baseline="center" font-size="0.3"></a-text>
  </a-plane>
  
  <!-- Título del panel -->
  <a-text value="CÓMPUTO" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#EF2D5E" position="0 0.7 0.01" width="2" align="center" baseline="center" font-size="0.14"></a-text>
</a-entity>

<!-- PANEL 3: TELEVISORES -->
<a-entity id="fixed-info-panel-3" position="8 2.5 -1" rotation="0 0 0">
  <!-- Panel principal -->
  <a-plane width="2" height="1.8" color="#1a1a2e" opacity="0.9" material="transparent: true"></a-plane>
  <a-plane width="2.05" height="1.85" color="#FFC65D" opacity="0.4" position="0 0 -0.01" material="transparent: true"></a-plane>
  
  <!-- Imagen del producto -->
  <a-plane width="0.8" height="0.8" color="#2a2a3e" opacity="0.8" position="-0.5 0.2 0.01"></a-plane>
  <a-image id="fixed-product-image-3" position="-0.5 0.2 0.02" width="0.75" height="0.75" src=""></a-image>
  
  <!-- Información del producto -->
  <a-text id="fixed-product-name-3" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Producto 3" color="#FFFFFF" position="0.1 0.5 0.01" width="1.3" align="left" baseline="top" wrap-count="20" font-size="0.18"></a-text>
  <a-text id="fixed-product-price-3" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="$0.00" color="#4ECDC4" position="0.1 0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.2"></a-text>
  
  <!-- Línea separadora -->
  <a-plane width="1.5" height="0.005" color="#FFC65D" opacity="0.6" position="0.1 0.15 0.01"></a-plane>
  
  <!-- Descripción -->
  <a-text id="fixed-product-description-3" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="Descripción" color="#E0E0E0" position="0.1 0.05 0.01" width="1" align="left" baseline="top" wrap-count="25" height="0.6" line-height="40" font-size="0.11"></a-text>
  
  <!-- Contador y botón -->
  <a-text id="fixed-product-counter-3" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" value="1/3" color="#FF6B6B" position="0.1 -0.3 0.01" width="1.3" align="left" baseline="top" font-size="0.15"></a-text>
  <a-plane id="fixed-details-btn-3" class="clickable" width="1.2" height="0.15" color="#4ECDC4" opacity="0.8" position="0.1 -0.5 0.03" animation__detailshover="property: scale; from: 1 1 1; to: 1.05 1.05 1.05; dur: 200; startEvents: mouseenter" animation__detailsleave="property: scale; from: 1.05 1.05 1.05; to: 1 1 1; dur: 200; startEvents: mouseleave">
    <a-text value="Ver detalles" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#FFFFFF" position="0 0 0.01" width="2" align="center" baseline="center" font-size="0.3"></a-text>
  </a-plane>
  
  <!-- Título del panel -->
  <a-text value="TELEVISORES" font="https://cdn.aframe.io/fonts/Roboto-msdf.json" color="#FFC65D" position="0 0.7 0.01" width="2" align="center" baseline="center" font-size="0.14"></a-text>
</a-entity>