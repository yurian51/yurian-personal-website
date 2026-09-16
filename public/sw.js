const CACHE_VERSION = 'yurian-hq-v2';
const SHELL_CACHE = `${CACHE_VERSION}-shell`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;

const SHELL = [
  '/',
  '/projects',
  '/about',
  '/services',
  '/blog',
  '/books',
  '/offline.html',
  '/assets/css/app.css',
  '/assets/css/forms.css',
  '/assets/css/light-theme.css',
  '/assets/css/hybrid-hq.css',
  '/assets/css/realistic-editorial.css',
  '/assets/js/hq.js',
  '/assets/js/hybrid-hq.js',
  '/assets/js/pwa.js',
  '/assets/icons/icon.svg'
];

const PRIVATE_PATHS = ['/api/', '/admin/', '/contact', '/checkout', '/cart'];

const isSameOrigin = (request) => new URL(request.url).origin === self.location.origin;
const isPrivatePath = (pathname) => PRIVATE_PATHS.some((prefix) => pathname === prefix || pathname.startsWith(`${prefix}/`));
const isStaticAsset = (request) => /\.(?:css|js|svg|png|webp|jpg|jpeg|ico|woff2?)$/i.test(new URL(request.url).pathname);

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(SHELL_CACHE)
      .then((cache) => cache.addAll(SHELL))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys
          .filter((key) => !key.startsWith(CACHE_VERSION))
          .map((key) => caches.delete(key))
      ))
      .then(() => self.clients.claim())
  );
});

async function networkFirst(request) {
  try {
    const response = await fetch(request);
    if (response.ok) {
      const cache = await caches.open(RUNTIME_CACHE);
      await cache.put(request, response.clone());
    }
    return response;
  } catch {
    return (await caches.match(request)) || caches.match('/offline.html');
  }
}

async function staleWhileRevalidate(request) {
  const cache = await caches.open(RUNTIME_CACHE);
  const cached = await cache.match(request);
  const network = fetch(request)
    .then((response) => {
      if (response.ok) return cache.put(request, response.clone()).then(() => response);
      return response;
    })
    .catch(() => cached || Response.error());

  return cached || network;
}

self.addEventListener('fetch', (event) => {
  const { request } = event;
  if (request.method !== 'GET' || !isSameOrigin(request)) return;

  const url = new URL(request.url);
  if (isPrivatePath(url.pathname)) return;

  if (request.mode === 'navigate') {
    event.respondWith(networkFirst(request));
    return;
  }

  if (isStaticAsset(request)) {
    event.respondWith(staleWhileRevalidate(request));
  }
});
