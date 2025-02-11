var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/catalog-offline',
    '/'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    );
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

self.addEventListener("fetch", event => {
    // Check if the request is for a catalog page (including paginated URLs)
    if (event.request.url.includes('/catalog')) {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // If the request is successful, cache the response
                    return caches.open(staticCacheName)
                        .then(cache => {
                            cache.put(event.request.url, response.clone());
                            return response;
                        });
                })
                .catch(() => {
                    // If the request fails (offline), return the catalog-offline page
                    return caches.match('/catalog-offline');
                })
        );
    } else {
        // For other requests, serve from cache first, then fallback to network
        event.respondWith(
            caches.match(event.request)
                .then(response => {
                    return response || fetch(event.request).catch(() => {
                        return caches.match('/offline');
                    });
                })
        );
    }
});

