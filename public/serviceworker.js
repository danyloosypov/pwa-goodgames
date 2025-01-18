var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/catalog',
    '/catalog-offline',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
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

// Serve from Cache
self.addEventListener("fetch", event => {
    // Check if the request is for a catalog page (including paginated URLs)
    if (event.request.url.includes('/catalog')) {
        event.respondWith(
            caches.match(event.request)
                .then(response => {
                    // If the page is in cache, serve it
                    if (response) {
                        return response;
                    }

                    // Otherwise, fetch it and dynamically cache it
                    return fetch(event.request)
                        .then(fetchResponse => {
                            return caches.open(staticCacheName)
                                .then(cache => {
                                    // Cache the fetched catalog page (paginated or not)
                                    cache.put(event.request.url, fetchResponse.clone());
                                    return fetchResponse;
                                });
                        })
                        .catch(() => {
                            // If offline and the page is not cached, show the offline page
                            return caches.match('/offline');
                        });
                })
        );
    } else {
        // For other requests, try serving from cache first, then fetch from network
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