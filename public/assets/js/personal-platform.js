(() => {
  'use strict';
  const reduce = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
  if (!reduce && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) { entry.target.classList.add('is-in'); observer.unobserve(entry.target); }
    }), {threshold:.08});
    document.querySelectorAll('.domain-card,.achievement-card,.service-grid article,.case-card,.thread-row,.cv-projects a').forEach((el)=>observer.observe(el));
  }
  const external = document.querySelectorAll('a[target="_blank"]');
  external.forEach((link)=>link.addEventListener('click',()=>{link.setAttribute('rel','noopener noreferrer');}));
})();
