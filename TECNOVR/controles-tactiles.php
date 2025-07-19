  <!-------- [[CONTROLES TÁCTILES MODERNOS]] -------->
  <div id="touch-controls" class="touch-controls" style="display: none;">
    <!-- Indicador central -->
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                width: 140px; height: 140px; 
                border: 2px solid rgba(76, 195, 217, 0.2); 
                border-radius: 50%; 
                pointer-events: none;
                background: radial-gradient(circle, rgba(76, 195, 217, 0.05) 0%, transparent 70%);">
    </div>
    
    <!-- Botón superior (Adelante) -->
    <div class="touch-row-top">
      <button class="touch-btn" id="btn-forward" title="Avanzar">
        <span style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">▲</span>
      </button>
    </div>
    
    <!-- Grid de controles direccionales -->
    <div class="touch-grid">
      <button class="touch-btn" id="btn-left" title="Izquierda">
        <span style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">◀</span>
      </button>
      
      <!-- Centro con indicador de posición -->
      <div style="display: flex; align-items: center; justify-content: center;
                  width: 50px; height: 50px; 
                  border-radius: 50%;
                  background: radial-gradient(circle, rgba(78, 205, 196, 0.3) 0%, rgba(76, 195, 217, 0.1) 100%);
                  border: 1px solid rgba(255, 255, 255, 0.2);
                  backdrop-filter: blur(10px);
                  pointer-events: none;">
        <div style="width: 8px; height: 8px; 
                    background: #4ECDC4; 
                    border-radius: 50%;
                    box-shadow: 0 0 10px rgba(78, 205, 196, 0.8);
                    animation: centerPulse 2s ease-in-out infinite;">
        </div>
      </div>
      
      <button class="touch-btn" id="btn-right" title="Derecha">
        <span style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">▶</span>
      </button>
    </div>
    
    <!-- Botón inferior en segunda fila -->
    <div style="display: flex; justify-content: center; margin-top: 10px;">
      <button class="touch-btn" id="btn-back" title="Retroceder">
        <span style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">▼</span>
      </button>
    </div>
    
    <!-- Indicador de estado -->
    <div style="position: absolute; bottom: -35px; left: 50%; transform: translateX(-50%);
                color: rgba(255, 255, 255, 0.6); 
                font-size: 0.8em; 
                font-family: 'Exo 2', sans-serif;
                text-align: center;
                pointer-events: none;
                text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
      Controles de Navegación
    </div>
  </div>

  <style>
    @keyframes centerPulse {
      0%, 100% { 
        transform: scale(1); 
        opacity: 1; 
      }
      50% { 
        transform: scale(1.2); 
        opacity: 0.7; 
      }
    }
    
    /* Efectos hover específicos para cada botón */
    #btn-forward:hover {
      background: linear-gradient(145deg, 
        rgba(76, 195, 217, 0.7), 
        rgba(78, 205, 196, 0.5));
      transform: translateY(-7px) scale(1.05);
    }
    
    #btn-back:hover {
      background: linear-gradient(145deg, 
        rgba(255, 107, 107, 0.6), 
        rgba(255, 149, 149, 0.4));
      transform: translateY(-7px) scale(1.05);
    }
    
    #btn-left:hover, #btn-right:hover {
      background: linear-gradient(145deg, 
        rgba(78, 205, 196, 0.6), 
        rgba(76, 195, 217, 0.4));
      transform: translateY(-7px) scale(1.05);
    }
  </style>