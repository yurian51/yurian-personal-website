(() => {
  const setOnlineState = () => {
    document.documentElement.dataset.connection = navigator.onLine ? 'online' : 'offline';
  };

  setOnlineState();
  window.addEventListener('online', setOnlineState, { passive: true });
  window.addEventListener('offline', setOnlineState, { passive: true });

  if (!('serviceWorker' in navigator)) return;

  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js', { updateViaCache: 'none' })
      .catch(() => {
        document.documentElement.dataset.serviceWorker = 'unavailable';
      });
  }, { once: true });
})();
