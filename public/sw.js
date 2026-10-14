const CACHE = 'forest-marker-v2';

self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('activate', event => event.waitUntil(
    caches.keys().then(keys => Promise.all(keys.filter(key => key.startsWith('forest-marker-') && key !== CACHE).map(key => caches.delete(key)))).then(() => self.clients.claim())
));

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);
    const isTile = url.hostname === 'tile.openstreetmap.org';
    const isStaticAsset = url.origin === self.location.origin && (url.pathname.startsWith('/build/') || url.pathname === '/manifest.webmanifest');

    if (isTile || isStaticAsset) {
        event.respondWith(caches.open(CACHE).then(async cache => {
            const cached = await cache.match(event.request);
            if (cached) return cached;
            try {
                const response = await fetch(event.request);
                if (response.ok) cache.put(event.request, response.clone());
                return response;
            } catch (error) {
                return cached || Response.error();
            }
        }));
        return;
    }

    if (event.request.mode === 'navigate' && url.pathname === '/dashboard') {
        event.respondWith(fetch(event.request).then(async response => {
            if (response.ok) (await caches.open(CACHE)).put('/dashboard', response.clone());
            return response;
        }).catch(async () => (await caches.match('/dashboard')) || Response.error()));
    }
});
