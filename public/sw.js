const CACHE_NAME = 'arga-barber-cache-v3';

// File-file yang di-pre-cache saat Service Worker dipasang
const urlsToCache = [
    '/',
    '/manifest.json',
    '/favicon.png',
    '/favicon.ico',
    '/assets/images/logo.png',
    '/offline.html'
];

// Fase Install: Menyimpan asset vital dan langsung skip waiting
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('[Service Worker] Pre-caching offline fallback and key assets');
                return cache.addAll(urlsToCache);
            })
            .then(() => self.skipWaiting())
    );
});

// Fase Activate: Pembersihan cache versi lama dan mengambil kontrol clients
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[Service Worker] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fase Fetch: Intersepsi request network
self.addEventListener('fetch', event => {
    // Abaikan request non-GET (POST, PUT, DELETE tidak bisa dicache)
    if (event.request.method !== 'GET') {
        return;
    }

    const url = new URL(event.request.url);

    // Abaikan request untuk Firebase Auth, live reload (Vite), atau extension browser
    if (
        url.pathname.includes('/firebase') ||
        url.pathname.includes('/test-firebase') ||
        url.pathname.includes('chrome-extension://') ||
        url.origin.includes('chrome-extension') ||
        url.pathname.includes('hot') ||
        url.hostname === 'localhost' && url.port === '5173' // Vite dev server HMR
    ) {
        return;
    }

    // Strategi untuk Navigasi Halaman Utama/HTML (Network-First dengan Fallback Offline)
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Salin respon ke cache untuk kunjungan berikutnya
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseClone);
                    });
                    return response;
                })
                .catch(() => {
                    // Jika offline: coba cari halaman di cache, jika tidak ada tampilkan offline.html
                    return caches.match(event.request)
                        .then(cachedResponse => {
                            if (cachedResponse) {
                                return cachedResponse;
                            }
                            return caches.match('/offline.html');
                        });
                })
        );
        return;
    }

    // Strategi untuk Aset Statis - CSS, JS, Fonts, Images (Stale-While-Revalidate)
    event.respondWith(
        caches.match(event.request)
            .then(cachedResponse => {
                const fetchPromise = fetch(event.request)
                    .then(networkResponse => {
                        // Simpan aset baru ke dalam cache jika responnya valid
                        if (networkResponse && (networkResponse.status === 200 || networkResponse.status === 0)) {
                            const responseClone = networkResponse.clone();
                            caches.open(CACHE_NAME).then(cache => {
                                cache.put(event.request, responseClone);
                            });
                        }
                        return networkResponse;
                    })
                    .catch(() => {
                        // Abaikan error fetch untuk aset statis di background
                    });

                // Tampilkan respon dari cache secepatnya, sementara fetch berjalan di background
                return cachedResponse || fetchPromise;
            })
    );
});
