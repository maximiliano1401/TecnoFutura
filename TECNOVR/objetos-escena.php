<!-- TIENDA -->
<a-entity obj-model="obj: #estructura-obj; mtl: #estructura-mtl" position="0.403 -0.665 2.000" scale="0.300 0.300 0.300" rotation="0 0 0"></a-entity>

<!-- PRODUCTOS -->
<!-- MODELOS 3D REALES DE PRODUCTOS -->

<!-- MÓVILES -->
<a-entity id="mobile1"
  obj-model="obj: #mobile1-obj; mtl: #mobile1-mtl"
  position="-2.490 2.0 -2.367"
  scale="0.010 0.010 0.010"
  rotation="0 0 0"
  class="clickable product"
  data-product="mobile1"
  visible="false"></a-entity>

<a-entity id="mobile3"
  obj-model="obj: #mobile3-obj; mtl: #mobile3-mtl"
  position="-2.490 2.0 -2.367"
  scale="0.005 0.005 0.005"
  rotation="0 0 0"
  class="clickable product"
  data-product="mobile3"
  visible="false"></a-entity>

<!-- COMPUTADORAS / PCs -->
<a-entity id="pc1"
  obj-model="obj: #pc1-obj; mtl: #pc1-mtl"
  position="6.171 2.0 3.542"
  scale="0.500 0.500 0.250"
  rotation="0 -90 0"
  class="clickable product"
  data-product="pc1"
  visible="false"></a-entity>

<a-entity id="laptop1"
  obj-model="obj: #laptop1-obj; mtl: #laptop1-mtl"
  position="6.171 2.0 3.542"
  scale="0.500 0.500 0.500"
  rotation="0 -90 0"
  class="clickable product"
  data-product="laptop1"
  visible="false"></a-entity>


<!-- TELEVISORES -->
<a-entity id="tv1"
  obj-model="obj: #tv1-obj; mtl: #tv1-mtl"
  position="-4.047 2.0 17.205"
  scale="0.100 0.100 0.400"
  rotation="0 180 0"
  class="clickable product"
  data-product="tv1"
  visible="false"></a-entity>

<a-entity id="tv2"
  obj-model="obj: #tv2-obj; mtl: #tv2-mtl"
  position="-4.047 2.0 17.205"
  scale="0.200 0.200 1.000"
  rotation="0 180 0"
  class="clickable product"
  data-product="tv2"
  visible="false"></a-entity>

<a-entity id="tv3"
  obj-model="obj: #tv3-obj; mtl: #tv3-mtl"
  position="-4.047 2.0 17.205"
  scale="0.250 0.250 0.400"
  rotation="0 180 0"
  class="clickable product"
  data-product="tv3"
  visible="false"></a-entity>

<a-entity id="tv4"
  obj-model="obj: #tv4-obj; mtl: #tv4-mtl"
  position="-4.047 2.0 17.205"
  scale="0.250 0.250 0.400"
  rotation="0 180 0"
  class="clickable product"
  data-product="tv4"
  visible="false"></a-entity>

<a-entity id="monitor1"
  obj-model="obj: #monitor1-obj; mtl: #monitor1-mtl"
  position="-4.047 2.0 17.205"
  scale="0.600 0.600 0.600"
  rotation="0 180 0"
  class="clickable product"
  data-product="monitor1"
  visible="false"></a-entity>

<a-entity id="monitor2"
  obj-model="obj: #monitor2-obj; mtl: #monitor2-mtl"
  position="-4.047 2.0 17.205"
  scale="0.600 0.600 0.600"
  rotation="0 180 0"
  class="clickable product"
  data-product="monitor2"
  visible="false"></a-entity>
  
<!-- SISTEMA DE 3 MOSTRADORES POR CATEGORÍAS -->

<!-- MOSTRADOR 1: TELÉFONOS -->
<a-entity id="mostrador-telefonos" position="-2.490 0.000 -2.367">
  <!-- Botón Anterior -->
  <a-box id="btn-anterior-1" 
         class="clickable nav-button" 
         position="-2.5 1 0" 
         color="#FF6B6B" 
         scale="0.4 0.6 0.15"
         text="value: ◀; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Botón Siguiente -->
  <a-box id="btn-siguiente-1" 
         class="clickable nav-button" 
         position="2.5 1 0" 
         color="#4ECDC4" 
         scale="0.4 0.6 0.15"
         text="value: ▶; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Base del mostrador -->
  <a-cylinder position="0 0 0" radius="1.5" height="0.2" color="#333333"></a-cylinder>
  
  <!-- Etiqueta de categoría -->
  <a-text value="TELÉFONOS" 
          position="0 2 0" 
          align="center" 
          color="#4CC3D9" 
          width="8">
  </a-text>
</a-entity>

<!-- MOSTRADOR 2: CÓMPUTO -->
<a-entity id="mostrador-computo" position="6.171 0.000 3.542" rotation="0.000 -90.0 0.000">
  <!-- Botón Anterior -->
  <a-box id="btn-anterior-2" 
         class="clickable nav-button" 
         position="-2.5 1 0" 
         color="#FF6B6B" 
         scale="0.4 0.6 0.15"
         text="value: ◀; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Botón Siguiente -->
  <a-box id="btn-siguiente-2" 
         class="clickable nav-button" 
         position="2.5 1 0" 
         color="#4ECDC4" 
         scale="0.4 0.6 0.15"
         text="value: ▶; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Base del mostrador -->
  <a-cylinder position="0 0 0" radius="1.5" height="0.2" color="#333333"></a-cylinder>
  
  <!-- Etiqueta de categoría -->
  <a-text value="CÓMPUTO" 
          position="0 2 0" 
          align="center" 
          color="#EF2D5E" 
          width="8">
  </a-text>
</a-entity>

<!-- MOSTRADOR 3: TELEVISORES -->
<a-entity id="mostrador-televisores" position="-4.047 0.000 17.205" rotation="0.000 180.00 0.000">
  <!-- Botón Anterior -->
  <a-box id="btn-anterior-3" 
         class="clickable nav-button" 
         position="-2.5 1 0" 
         color="#FF6B6B" 
         scale="0.4 0.6 0.15"
         text="value: ◀; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Botón Siguiente -->
  <a-box id="btn-siguiente-3" 
         class="clickable nav-button" 
         position="2.5 1 0" 
         color="#4ECDC4" 
         scale="0.4 0.6 0.15"
         text="value: ▶; align: center; color: white; width: 15"
         animation__hover="property: scale; to: 0.45 0.65 0.2; startEvents: mouseenter; dur: 200"
         animation__leave="property: scale; to: 0.4 0.6 0.15; startEvents: mouseleave; dur: 200">
  </a-box>
  
  <!-- Base del mostrador -->
  <a-cylinder position="0 0 0" radius="1.5" height="0.2" color="#333333"></a-cylinder>
  
  <!-- Etiqueta de categoría -->
  <a-text value="TELEVISORES" 
          position="0 2 0" 
          align="center" 
          color="#FFC65D" 
          width="8">
  </a-text>
</a-entity>

<!-- PANEL DE INFORMACIÓN FIJO -->
<?php include 'panel-fijo.php' ?>
