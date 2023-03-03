var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    'offline',
    'assets/vendor/fonts/boxicons.css',
    'assets/vendor/css/core.css',
    'assets/vendor/css/theme-default.css',
    'assets/css/demo.css',
    'libs/select2/select2.css',
    'assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css',
    'assets/vendor/js/helpers.js',
    'assets/js/config.js',
    'assets/vendor/libs/jquery/jquery.js',
    'assets/vendor/libs/moment/moment.js',
    'assets/vendor/libs/popper/popper.js',
    'assets/vendor/js/bootstrap.js',
    'assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
    'assets/vendor/js/menu.js',
    'assets/js/main.js',
    'assets/js/state.js',
    'assets/js/mclue.js',
    'libs/select2/select2.js',
    'images/icons/icon-48x48.png',
    'images/icons/icon-72x72.png',
    'images/icons/icon-96x96.png',
    'images/icons/icon-128x128.png',
    'images/icons/icon-144x144.png',
    'images/icons/icon-152x152.png',
    'images/icons/icon-192x192.png',
    'images/icons/icon-384x384.png',
    'images/icons/icon-512x512.png',
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
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});