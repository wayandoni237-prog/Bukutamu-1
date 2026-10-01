const root = document.documentElement;
const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));

const nav = $('#nav');
const progress = $('#progress');
const toTop = $('#toTop');
const burger = $('#burger');
const navMenu = $('#navMenu');

const SECTIONS = ['home', 'about', 'skills', 'projects', 'experience', 'contact'];
const WA_NUMBER = '6281234567890';
const PHRASES = ['Web Developer', 'Software Engineering Student', 'Laravel & PHP Builder', 'Frontend Enthusiast'];

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function closeMenu() {
  navMenu.classList.remove('is-open');
  burger.classList.remove('is-open');
  burger.setAttribute('aria-expanded', 'false');
}

burger.addEventListener('click', () => {
  const open = navMenu.classList.toggle('is-open');
  burger.classList.toggle('is-open', open);
  burger.setAttribute('aria-expanded', String(open));
});

$$('.nav__link').forEach((link) => link.addEventListener('click', closeMenu));

document.addEventListener('click', (e) => {
  if (!navMenu.classList.contains('is-open')) return;
  if (!navMenu.contains(e.target) && !burger.contains(e.target)) closeMenu();
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMenu();
});

function typingEffect() {
  const el = $('#typing');
  if (!el) return;
  if (reduceMotion) {
    el.textContent = PHRASES[0];
    return;
  }
  let p = 0;
  let c = 0;
  let removing = false;

  const tick = () => {
    const word = PHRASES[p];
    el.textContent = removing ? word.slice(0, --c) : word.slice(0, ++c);
    let delay = removing ? 45 : 90;
    if (!removing && c === word.length) {
      removing = true;
      delay = 1500;
    } else if (removing && c === 0) {
      removing = false;
      p = (p + 1) % PHRASES.length;
      delay = 300;
    }
    setTimeout(tick, delay);
  };
  tick();
}

function onScroll() {
  const y = window.scrollY;
  nav.classList.toggle('is-stuck', y > 20);
  toTop.classList.toggle('is-show', y > 500);

  const max = root.scrollHeight - root.clientHeight;
  progress.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';

  let current = SECTIONS[0];
  SECTIONS.forEach((id) => {
    const el = document.getElementById(id);
    if (el && y >= el.offsetTop - 150) current = id;
  });
  $$('.nav__link').forEach((l) => l.classList.toggle('is-active', l.getAttribute('href') === '#' + current));
}

window.addEventListener('scroll', onScroll, { passive: true });
toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

function countUp(el) {
  const target = parseInt(el.dataset.count, 10) || 0;
  if (reduceMotion) {
    el.textContent = target;
    return;
  }
  const dur = 1200;
  const start = performance.now();
  const step = (now) => {
    const p = Math.min((now - start) / dur, 1);
    el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
    if (p < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

function initReveal() {
  const targets = $$('.sk, .nums');

  const show = (el) => {
    if (el.classList.contains('is-in')) return;
    el.classList.add('is-in');
    $$('[data-count]', el).forEach(countUp);
  };

  if (reduceMotion) {
    targets.forEach(show);
    return;
  }

  let last = 0;
  const check = () => {
    const now = Date.now();
    if (now - last < 80) return;
    last = now;
    const limit = window.innerHeight * 0.85;
    targets.forEach((el) => {
      if (el.getBoundingClientRect().top < limit) show(el);
    });
  };

  window.addEventListener('scroll', check, { passive: true });
  window.addEventListener('resize', check);
  check();
}

function initForm() {
  const form = $('#contactForm');
  const note = $('#formNote');
  if (!form) return;
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const nama = $('#nama').value.trim();
    const email = $('#email').value.trim();
    const pesan = $('#pesan').value.trim();
    if (!nama || !email || !pesan) return;
    const text = encodeURIComponent(`Halo Pak Doni,\n\nNama: ${nama}\nEmail: ${email}\n\n${pesan}`);
    window.open(`https://wa.me/${WA_NUMBER}?text=${text}`, '_blank');
    note.textContent = 'Terima kasih! WhatsApp sedang dibuka.';
    note.classList.add('is-ok');
  });
}

function initPreloader() {
  const pre = $('#preloader');
  if (!pre) return;
  const hide = () => {
    pre.classList.add('is-done');
    setTimeout(() => pre.remove(), 500);
  };
  if (document.readyState === 'complete') setTimeout(hide, 300);
  else window.addEventListener('load', () => setTimeout(hide, 300));
  setTimeout(hide, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
  const year = $('#year');
  if (year) year.textContent = new Date().getFullYear();

  typingEffect();
  onScroll();
  initReveal();
  initForm();
  initPreloader();

  if (window.AOS) {
    AOS.init({ duration: 650, easing: 'ease-out-cubic', once: true, offset: 70 });
  }
});
