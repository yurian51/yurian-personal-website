(() => {
  const root = document.querySelector('#main-content');
  const palette = document.querySelector('#command-palette');
  const input = document.querySelector('#command-input');
  const nav = document.querySelector('#site-nav');
  const openPalette = () => { if (!palette) return; palette.hidden = false; document.body.classList.add('palette-open'); input?.focus(); };
  const closePalette = () => { if (!palette) return; palette.hidden = true; document.body.classList.remove('palette-open'); };
  document.querySelector('[data-command-open]')?.addEventListener('click', openPalette);
  document.querySelectorAll('[data-command-target]').forEach((button) => button.addEventListener('click', () => { document.querySelector(button.dataset.commandTarget)?.scrollIntoView({ behavior: 'smooth' }); closePalette(); }));
  document.querySelector('[data-command-close]')?.addEventListener('click', closePalette);
  palette?.addEventListener('click', (event) => { if (event.target === palette) closePalette(); });
  document.addEventListener('keydown', (event) => { if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') { event.preventDefault(); openPalette(); } if (event.key === 'Escape') closePalette(); });
  window.addEventListener('scroll', () => nav?.classList.toggle('is-scrolled', window.scrollY > 32), { passive: true });
  input?.addEventListener('input', () => { const query = input.value.toLowerCase(); document.querySelectorAll('.command-list button').forEach((button) => { button.hidden = !button.textContent.toLowerCase().includes(query); }); });

  const sections = [...document.querySelectorAll('[data-state]')];
  if (root && 'IntersectionObserver' in window) { const observer = new IntersectionObserver((entries) => entries.forEach((entry) => { if (entry.isIntersecting) root.dataset.scrollState = entry.target.dataset.state; }), { rootMargin: '-42% 0px -42% 0px' }); sections.forEach((section) => observer.observe(section)); }

  document.querySelectorAll('[data-filter]').forEach((button) => button.addEventListener('click', () => { document.querySelectorAll('[data-filter]').forEach((item) => item.classList.toggle('active', item === button)); const filter = button.dataset.filter; document.querySelectorAll('[data-category]').forEach((tile) => { tile.hidden = filter !== 'all' && tile.dataset.category !== filter; }); }));

  const easter = document.querySelector('#easter-egg'); const sequence = ['ArrowUp','ArrowUp','ArrowDown','ArrowDown','ArrowLeft','ArrowRight','ArrowLeft','ArrowRight','b','a']; let cursor = 0;
  document.addEventListener('keydown', (event) => { const key = event.key.length === 1 ? event.key.toLowerCase() : event.key; cursor = key === sequence[cursor] ? cursor + 1 : 0; if (cursor === sequence.length) { cursor = 0; if (easter) { easter.hidden = false; window.setTimeout(() => { easter.hidden = true; }, 3600); } } });
})();
