const CACHE_NAME = 'sdawms-v1';

// File statis yang di-cache untuk offline shell
const STATIC_ASSETS = [
    '/assets/css/bootstrap.min.css',
    '/assets/css/main.css',
    '/assets/css/custom.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
];

// Install: cache shell assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(STATIC_ASSETS).catch(() => {});
        })
    );
    self.skipWaiting();
});

// Activate: hapus cache lama
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        )
    );
    self.clients.claim();
});

// Fetch: Network-first untuk semua request (realtime data)
// Static assets: cache-first
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Hanya handle GET
    if (event.request.method !== 'GET') return;

    // Static assets (CSS, JS, gambar) → cache first
    if (
        url.pathname.startsWith('/assets/') ||
        url.pathname.startsWith('/images/') ||
        url.pathname.startsWith('/audio/')
    ) {
        event.respondWith(
            caches.match(event.request).then(cached => {
                return cached || fetch(event.request).then(response => {
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(c => c.put(event.request, clone));
                    }
                    return response;
                });
            })
        );
        return;
    }

    // Semua request lain (halaman, API) → network first (realtime)
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});
