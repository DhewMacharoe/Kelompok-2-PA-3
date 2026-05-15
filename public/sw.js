const CACHE_NAME = 'v2_cache';
const urlsToCache = [
    '/manifest.json',
    // Anda bisa menambahkan path ke file CSS atau JS utama di sini
];

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => Promise.all(
            cacheNames.map(cacheName => {
                if (cacheName !== CACHE_NAME) {
                    return caches.delete(cacheName);
                }

                return Promise.resolve();
            })
        )).then(() => self.clients.claim())
    );
});

// Install Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );

    self.skipWaiting();
});

// Fetch/Gunakan Cache jika offline
self.addEventListener('fetch', event => {
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    const responseClone = response.clone();

                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseClone);
                    });

                    return response;
                })
                .catch(() => caches.match(event.request))
        );

        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response; // Gunakan versi cache
                }
                return fetch(event.request); // Ambil dari internet
            })
    );
});
