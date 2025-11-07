const CACHE_NAME = 'tecnoapk-v1';
const STATIC_CACHE = 'tecnoapk-static-v1';
const DYNAMIC_CACHE = 'tecnoapk-dynamic-v1';

// Archivos esenciales para offline
const STATIC_FILES = [
  '/',
  '/HTML/index.html',
  '/HTML/menu.php',
  '/HTML/carrito.php',
  '/HTML/perfil.php',
  '/CSS/index.css',
  '/CSS/menu.css',
  '/CSS/navbar.css',
  '/IMG/logo.png',
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
  const url = new URL(request.url);

  if (!request.url.startsWith('http')) return;

  // Network only para APIs
  if (NETWORK_ONLY.some(path => url.pathname.includes(path))) {
    event.respondWith(
      fetch(request).catch(() => caches.match('/offline.html'))
    );
    return;
  }

  // Cache first para recursos estáticos
  if (request.destination === 'image' || 
      request.destination === 'style' || 
      request.destination === 'script') {
    event.respondWith(
      caches.match(request).then(cached => {
        if (cached) return cached;
        return fetch(request).then(response => {
          if (response.status === 200) {
            const copy = response.clone();
            caches.open(DYNAMIC_CACHE).then(cache => cache.put(request, copy));
          }
          return response;
        });
      }).catch(() => caches.match('/offline.html'))
    );
    return;
  }

  // Network first para páginas
  event.respondWith(
    fetch(request).then(response => {
      if (response.status === 200) {
        const copy = response.clone();
        caches.open(DYNAMIC_CACHE).then(cache => cache.put(request, copy));
      }
      return response;
    }).catch(() => {
      return caches.match(request).then(cached => {
        return cached || caches.match('/offline.html');
      });
    })
  );
});