(() => {
  'use strict';
  const reduce = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
  const progress = document.createElement('div');
  progress.className = 'hq-progress';
  progress.setAttribute('aria-hidden', 'true');
  progress.innerHTML = '<i></i>';
  document.body.appendChild(progress);
  const bar = progress.firstElementChild;

  const updateProgress = () => {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.transform = `scaleX(${max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0})`;
  };
  updateProgress();
  window.addEventListener('scroll', updateProgress, { passive: true });
  window.addEventListener('resize', updateProgress, { passive: true });

  const presence = document.createElement('aside');
  presence.className = 'hq-presence';
  presence.setAttribute('aria-label', 'Yurian Digital HQ local time');
  presence.innerHTML = '<span class="hq-presence__dot" aria-hidden="true"></span><span>HQ <strong>live view</strong></span><span aria-hidden="true">·</span><span id="hq-clock">--:--</span>';
  document.body.appendChild(presence);

  const clock = presence.querySelector('#hq-clock');
  const updateClock = () => {
    clock.textContent = new Intl.DateTimeFormat(undefined, { hour: '2-digit', minute: '2-digit', hour12: false, timeZoneName: 'short' }).format(new Date());
  };
  updateClock();
  window.setInterval(updateClock, 60000);

  document.querySelectorAll('.hq-section, .project-card, .lab-tile, .library-row, .note-row').forEach((node) => node.dataset.hqReveal = '');
  const revealNodes = document.querySelectorAll('[data-hq-reveal]');
  if (!reduce && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -5% 0px' });
    revealNodes.forEach((node) => observer.observe(node));
  } else {
    revealNodes.forEach((node) => node.classList.add('is-visible'));
  }

  const palette = document.querySelector('#command-palette .command-palette__panel');
  const list = document.querySelector('#command-palette .command-list');
  if (palette && list && !list.querySelector('.hq-command-index')) {
    const index = document.createElement('div');
    index.className = 'hq-command-index';
    const links = [
      ['Projects', '/projects'], ['Services', '/services'], ['About', '/about'],
      ['Books', '/books'], ['Notes', '/blog'], ['Contact', '/contact']
    ];
    links.forEach(([label, href]) => {
      const link = document.createElement('a');
      link.href = href;
      link.textContent = label;
      index.appendChild(link);
    });
    palette.appendChild(index);
  }
})();
