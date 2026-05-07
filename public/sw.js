const CACHE_NAME = 'v1_cache';
const urlsToCache = [
    '/',
    '/manifest.json',
    // Anda bisa menambahkan path ke file CSS atau JS utama di sini
];

// Install Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch/Gunakan Cache jika offline
self.addEventListener('fetch', event => {
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
