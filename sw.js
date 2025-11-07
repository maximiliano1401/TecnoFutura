const CACHE_NAME = 'tecnoapk-v2';
const STATIC_CACHE = 'tecnoapk-static-v2';
const DYNAMIC_CACHE = 'tecnoapk-dynamic-v2';

// Archivos esenciales para offline (solo los críticos)
const STATIC_FILES = [
  '/',
  '/HTML/index.html',
  '/offline.html'
];

// URLs que siempre requieren red
const NETWORK_ONLY = ['/SESIONES/', '/PHP/', '/API/', '/ADMINISTRACION/'];

// Instalación
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(STATIC_CACHE)
      .then(cache => cache.addAll(STATIC_FILES))
      .catch(err => console.log('Cache error:', err))
  );
  self.skipWaiting();
});

// Activación
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(names => 
      Promise.all(
        names.map(name => {
          if (name !== STATIC_CACHE && name !== DYNAMIC_CACHE) {
            return caches.delete(name);
          }
        })
      )
    )
  );
  self.clients.claim();
});

// Interceptar peticiones
self.addEventListener('fetch', event => {
  const { request } = event;
  
  // Ignorar solicitudes no HTTP/HTTPS
  if (!request.url.startsWith('http')) return;
  
  try {
    const url = new URL(request.url);
    
    // Ignorar recursos externos (CDN, fuentes, etc.) - déjalos pasar sin cache
    if (!url.origin.includes(self.location.hostname) && 
        !url.origin.includes('ngrok-free.dev') &&
        !url.origin.includes('localhost')) {
      return; // No interceptar recursos externos
    }

    // Network only para APIs
    if (NETWORK_ONLY.some(path => url.pathname.includes(path))) {
      event.respondWith(
        fetch(request).catch(() => caches.match('/offline.html'))
      );
      return;
    }

    // Cache first para recursos estáticos (con manejo de errores mejorado)
    if (request.destination === 'image' || 
        request.destination === 'style' || 
        request.destination === 'script') {
      event.respondWith(
        caches.match(request).then(cached => {
          if (cached) return cached;
          return fetch(request).then(response => {
            // Solo cachear respuestas exitosas y completas
            if (response.status === 200 && response.ok && response.type !== 'error') {
              try {
                const copy = response.clone();
                caches.open(DYNAMIC_CACHE).then(cache => {
                  cache.put(request, copy).catch(err => {
                    console.log('Cache put error:', err);
                  });
                });
              } catch (e) {
                console.log('Clone error:', e);
              }
            }
            return response;
          }).catch(err => {
            console.log('Fetch error:', err);
            // No intentar cargar offline.html para imágenes faltantes
            return new Response('', { status: 404, statusText: 'Not Found' });
          });
        })
      );
      return;
    }

    // Network first para páginas HTML
    event.respondWith(
      fetch(request).then(response => {
        if (response.status === 200 && response.ok) {
          try {
            const copy = response.clone();
            caches.open(DYNAMIC_CACHE).then(cache => {
              cache.put(request, copy).catch(err => {
                console.log('Cache put error:', err);
              });
            });
          } catch (e) {
            console.log('Clone error:', e);
          }
        }
        return response;
      }).catch(() => {
        return caches.match(request).then(cached => {
          return cached || caches.match('/offline.html');
        });
      })
    );
  } catch (e) {
    console.log('Service Worker fetch error:', e);
  }
});