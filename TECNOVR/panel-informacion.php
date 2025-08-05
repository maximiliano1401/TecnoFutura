<a-entity id="product-info-panel" visible="false" position="0 2.5 -4">
  <!-- Panel principal con efecto glassmorphism -->
  <a-plane width="3.0" height="1.6" 
           color="#1a1a2e" 
           opacity="0.85"
           material="transparent: true"
           geometry="primitive: plane"
           animation__appear="property: scale; from: 0.1 0.1 0.1; to: 1 1 1; dur: 500; easing: easeOutBack; startEvents: panelshow"
           animation__disappear="property: scale; from: 1 1 1; to: 0.1 0.1 0.1; dur: 300; easing: easeInBack; startEvents: panelhide">
  </a-plane>
  
  <!-- Borde brillante -->
  <a-plane width="3.05" height="1.65" 
           color="#4CC3D9" 
           opacity="0.3"
           position="0 0 -0.01"
           material="transparent: true">
  </a-plane>
  
  <!-- Imagen del producto con marco mejorado -->
  <a-plane width="1.0" height="1.0" 
           color="#2a2a3e" 
           opacity="0.8"
           position="-0.85 0.1 0.01">
  </a-plane>
  
  <a-image id="product-image" 
           position="-0.85 0.1 0.02" 
           width="0.9" 
           height="0.9" 
           visible="true"
           animation__imageappear="property: opacity; from: 0; to: 1; dur: 600; delay: 200; startEvents: panelshow">
  </a-image>
  
  <!-- Título del producto con fuente mejorada -->
  <a-text id="product-name" 
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="" 
          color="#FFFFFF" 
          position="0.1 0.45 0.01" 
          width="1.8" 
          align="left"
          baseline="top" 
          wrap-count="28" 
          height="0.35" 
          side="double"
          line-height="55" 
          font-size="0.26"
          animation__textappear="property: opacity; from: 0; to: 1; dur: 600; delay: 300; startEvents: panelshow">
  </a-text>
  
  <!-- Precio con estilo destacado -->
  <a-text id="product-price"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="" 
          color="#4ECDC4" 
          position="0.1 0.2 0.01" 
          width="1.8" 
          align="left"
          baseline="top" 
          wrap-count="28" 
          height="0.25" 
          side="double"
          line-height="55" 
          font-size="0.28"
          animation__priceappear="property: opacity; from: 0; to: 1; dur: 600; delay: 400; startEvents: panelshow">
  </a-text>
  
  <!-- Línea separadora -->
  <a-plane width="1.6" height="0.005" 
           color="#4CC3D9" 
           opacity="0.6"
           position="0.1 0.05 0.01"
           animation__lineappear="property: width; from: 0; to: 1.6; dur: 800; delay: 500; startEvents: panelshow">
  </a-plane>
  
  <!-- Descripción mejorada -->
  <a-text id="product-description"
          font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
          value="" 
          color="#E0E0E0" 
          position="0.1 -0.15 0.01" 
          width="1.4" 
          align="left"
          baseline="top" 
          wrap-count="35" 
          height="0.7" 
          side="double"
          line-height="50" 
          font-size="0.16"
          animation__descappear="property: opacity; from: 0; to: 1; dur: 600; delay: 600; startEvents: panelshow">
  </a-text>
  
  <!-- Botón de cerrar clickeable con A-Frame -->
  <a-plane id="close-panel-btn"
           class="clickable"
           width="0.3" 
           height="0.3" 
           color="#FF6B6B" 
           opacity="0.8"
           position="1.3 0.6 0.03"
           animation__closeappear="property: opacity; from: 0; to: 0.8; dur: 600; delay: 800; startEvents: panelshow"
           animation__closehover="property: scale; from: 1 1 1; to: 1.1 1.1 1.1; dur: 200; startEvents: mouseenter"
           animation__closeleave="property: scale; from: 1.1 1.1 1.1; to: 1 1 1; dur: 200; startEvents: mouseleave">

    <a-text value="X"
            font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
            color="#FFFFFF" 
            position="0 0 0.01" 
            width="2" 
            align="center"
            baseline="center" 
            font-size="0.8">
    </a-text>
  </a-plane>
  
  <!-- Indicadores de interacción -->
  <!-- Botón Ver más detalles -->
  <a-plane id="details-btn"
           class="clickable"
           width="0.8" 
           height="0.15" 
           color="#4ECDC4" 
           opacity="0.7"
           position="0.9 -0.65 0.03"
           animation__detailsappear="property: opacity; from: 0; to: 0.8; dur: 600; delay: 600; startEvents: panelshow"
           animation__detailshover="property: scale; from: 1 1 1; to: 1.05 1.05 1.05; dur: 200; startEvents: mouseenter"
           animation__detailsleave="property: scale; from: 1.05 1.05 1.05; to: 1 1 1; dur: 200; startEvents: mouseleave">
    
    <a-text value="Ver mas detalles"
            font="https://cdn.aframe.io/fonts/Roboto-msdf.json"
            color="#FFFFFF" 
            position="0 0 0.01" 
            width="2" 
            align="center"
            baseline="center" 
            font-size="0.4">
    </a-text>
  </a-plane>
  
  <!-- Efectos de partículas decorativas -->
  <a-sphere position="-1.3 0.6 0.03" 
            radius="0.02" 
            color="#4CC3D9" 
            opacity="0.6"
            animation__float1="property: position; from: -1.3 0.6 0.03; to: -1.2 0.8 0.03; dur: 3000; dir: alternate; loop: true"
            animation__glow1="property: opacity; from: 0.3; to: 0.8; dur: 2000; dir: alternate; loop: true">
  </a-sphere>
  
  <a-sphere position="1.2 0.4 0.03" 
            radius="0.015" 
            color="#4ECDC4" 
            opacity="0.5"
            animation__float2="property: position; from: 1.2 0.4 0.03; to: 1.3 0.6 0.03; dur: 4000; dir: alternate; loop: true"
            animation__glow2="property: opacity; from: 0.2; to: 0.7; dur: 2500; dir: alternate; loop: true">
  </a-sphere>
  
  <a-sphere position="0.8 -0.4 0.03" 
            radius="0.018" 
            color="#FF6B6B" 
            opacity="0.4"
            animation__float3="property: position; from: 0.8 -0.4 0.03; to: 0.9 -0.2 0.03; dur: 3500; dir: alternate; loop: true"
            animation__glow3="property: opacity; from: 0.1; to: 0.6; dur: 1800; dir: alternate; loop: true">
  </a-sphere>
</a-entity>