<!-- TIENDA -->
<a-entity obj-model="obj: #estructura-obj; mtl: #estructura-mtl" position="-25 -8 2" scale="0.5 0.5 0.5" rotation="0 0 0"></a-entity>

<!-- PRODUCTOS -->
<a-entity id="laptop1"
  obj-model="obj: #laptop1-obj; mtl: #laptop1-mtl"
  position="-33.594 1.084 26.464"
  scale="0.5 0.5 0.5"
  rotation="0 0 0"
  class="clickable product"
  data-product="laptop1"></a-entity>

<a-entity id="celular1"
  obj-model="obj: #celular1-obj; mtl: #celular1-mtl"
  position="65.2 -15.4 36.7"
  scale="0.4 0.4 0.4"
  rotation="0 30 0"
  class="clickable product"
  data-product="celular1"></a-entity>

<a-entity id="monitor1"
  obj-model="obj: #monitor1-obj; mtl: #monitor1-mtl"
  position="-0.2 -36.17 -22.7"
  scale="0.6 0.6 0.6"
  rotation="0 180 0"
  class="clickable product"
  data-product="monitor1"></a-entity>

<a-entity id="monitor2"
  obj-model="obj: #monitor2-obj; mtl: #monitor2-mtl"
  position="15.3 -29.6 97.1"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="monitor2"></a-entity>

<a-entity id="lapgamer"
  obj-model="obj: #laptopgamer-obj; mtl: #laptopgamer-mtl"
  position="15.3 -29.6 97.1"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="lapgamer"></a-entity>

<!---->
<!---->
<!---->

<a-entity id="lapgamer1"
  obj-model="obj: #laptopgamer1-obj; mtl: #laptopgamer1-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="lapgamer1"></a-entity>

<a-entity id="lapgamer2"
  obj-model="obj: #laptopgamer2-obj; mtl: #laptopgamer2-mtl"
  position="-17 46 17"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="lapgamer2"></a-entity>

<a-entity id="lapgamer3"
  obj-model="obj: #laptopgamer3-obj; mtl: #laptopgamer3-mtl"
  position="-64 76.5 61"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="lapgamer3"></a-entity>

<a-entity id="lapgamer5"
  obj-model="obj: #laptopgamer5-obj; mtl: #laptopgamer5-mtl"
  position="-90 108.3 1.3"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="lapgamer5"></a-entity>


<!---->
<!---->
<!---->

<a-entity id="pc1"
  obj-model="obj: #pc1-obj; mtl: #pc1-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc1"></a-entity>

<a-entity id="pc2"
  obj-model="obj: #pc2-obj; mtl: #pc2-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc2"></a-entity>

<a-entity id="pc3"
  obj-model="obj: #pc3-obj; mtl: #pc3-mtl"
  position="-5.3 162.8 1.74"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc3"></a-entity>

<a-entity id="pc4"
  obj-model="obj: #pc4-obj; mtl: #pc4-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc4"></a-entity>

<a-entity id="pc5"
  obj-model="obj: #pc5-obj; mtl: #pc5-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc5"></a-entity>

<a-entity id="pc6"
  obj-model="obj: #pc6-obj; mtl: #pc6-mtl"
  position="0 0 0"
  scale="0.6 0.6 0.6"
  rotation="0 0 0"
  class="clickable product"
  data-product="pc6"></a-entity>


<!---->
<!---->
<!---->
  
<!-- MOSTRADOR FIJO CON SISTEMA DE NAVEGACIÓN -->
<!-- Posición del producto actual (inicialmente cube1) -->
<a-box id="product-display" 
       position="0 1 -4" 
       color="#4CC3D9" 
       scale="1.2 1.2 1.2"
       animation="property: rotation; to: 0 360 0; dur: 8000; loop: true; easing: linear">
</a-box>

<!-- Botón Anterior (izquierda) -->
<a-box id="btn-anterior" 
       class="clickable nav-button" 
       position="-3 1 -4" 
       color="#FF6B6B" 
       scale="0.5 0.8 0.2"
       text="value: ◀ ANTERIOR; position: 0 0 0.15; align: center; color: white; width: 12"
       animation__hover="property: scale; to: 0.55 0.85 0.25; startEvents: mouseenter; dur: 200"
       animation__leave="property: scale; to: 0.5 0.8 0.2; startEvents: mouseleave; dur: 200">
</a-box>

<!-- Botón Siguiente (derecha) -->
<a-box id="btn-siguiente" 
       class="clickable nav-button" 
       position="3 1 -4" 
       color="#4ECDC4" 
       scale="0.5 0.8 0.2"
       text="value: SIGUIENTE ▶; position: 0 0 0.15; align: center; color: white; width: 12"
       animation__hover="property: scale; to: 0.55 0.85 0.25; startEvents: mouseenter; dur: 200"
       animation__leave="property: scale; to: 0.5 0.8 0.2; startEvents: mouseleave; dur: 200">
</a-box>

<!-- Base del mostrador -->
<a-cylinder id="mostrador-base" 
            position="0 0 -4" 
            radius="2" 
            height="0.2" 
            color="#333333">
</a-cylinder>

<!-- PANEL DE INFORMACIÓN FIJO -->
<?php include 'panel-fijo.php' ?>
