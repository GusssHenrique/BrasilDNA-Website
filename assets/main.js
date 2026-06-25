/**
 * Brasil DNA — main.js  (rebranding 2026 · v2)
 * ─────────────────────────────────────────────────────────────
 *  1.  Header: scroll-state + hide-on-scroll-down
 *  2.  Mobile nav (slide-in panel + overlay)
 *  3.  Scroll-reveal (IntersectionObserver)
 *  4.  Hero parallax
 *  5.  Hero: floating particles (folhas / gotas nas cores BR)
 *  6.  Hero: animated stat counters
 *  7.  Horizontal marquee ticker
 *  8.  Pillar cards 3-D tilt
 *  9.  Destination card image zoom (JS-assisted)
 * 10.  Smooth anchor scroll
 * 11.  Newsletter form UX (validate + success state)
 * 12.  Scroll-progress bar (gradiente bandeira)
 * 13.  Custom cursor (desktop only)
 * 14.  News-card rainbow-border hover
 * 15.  Active nav link via IntersectionObserver
 * 16.  Scroll-down arrow bounce (CSS injected)
 */

/* ─── UTILS ──────────────────────────────────────────────── */
const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];
const pRM = () => window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const isMobile = () => window.matchMedia("(hover: none)").matches;

/* ─────────────────────────────────────────────────────────── *
 *  1 + 2 — HEADER & MOBILE NAV
 * ─────────────────────────────────────────────────────────── */
(function initHeader() {
   const header = $("#siteHeader");
   const toggle = $("#navToggle");
   const nav = $("#mainNav");
   if (!header) return;

   /* Inject header-hide + mobile-nav styles */
   injectStyle(
      "header-styles",
      `
    .site-header {
      transition: transform .35s cubic-bezier(.25,.8,.25,1),
                  background .4s cubic-bezier(.25,.8,.25,1),
                  padding .35s, box-shadow .35s;
    }
    .site-header.is-hidden { transform: translateY(-100%); }

    /* ── Mobile nav panel ── */
    @media (max-width: 768px) {
      .nav-overlay {
        display: block;
        position: fixed; inset: 0;
        background: transparent;
        z-index: 929;
        opacity: 0; pointer-events: none;
        transition: opacity .35s ease;
      }
      .nav-overlay.is-open { opacity: 1; pointer-events: all; }

      #mainNav {
        position: fixed; top: 0; right: 0;
        height: 100dvh; width: min(80vw, 300px);
        z-index: 960;
        background: var(--green-900, #012a15);
        flex-direction: column;
        justify-content: center; align-items: flex-start;
        gap: 28px; padding: 40px 36px;
        transform: translateX(110%);
        transition: transform .42s cubic-bezier(.25,.8,.25,1);
        box-shadow: -8px 0 40px rgba(0,0,0,.4);
        z-index: 940;
        /* override display:flex from desktop */
        display: flex !important;
      }
      #mainNav.is-open { transform: translateX(0); }
      #mainNav > a:not(.nav-cta) {
        color: rgba(255,255,255,.85) !important;
        font-size: 1.15rem;
      }
      #mainNav > a:not(.nav-cta)::after { display: none; }
      .nav-cta { align-self: flex-start; }

      /* Hamburger → X */
      .nav-toggle span {
        display: block; width: 26px; height: 2px;
        background: currentColor; border-radius: 2px;
        transition: transform .3s ease, opacity .25s;
        transform-origin: center;
      }
      .nav-toggle.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
      .nav-toggle.is-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
      .nav-toggle.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
    }
  `,
   );

   /* Create overlay element */
   const overlay = document.createElement("div");
   overlay.className = "nav-overlay";
   document.body.appendChild(overlay);

   /* Scroll handler */
   let lastY = 0;
   const onScroll = () => {
      const y = window.scrollY;
      header.classList.toggle("scrolled", y > 60);
      if (y > 200) {
         header.classList.toggle("is-hidden", y > lastY + 4);
         if (y < lastY - 4) header.classList.remove("is-hidden");
      } else {
         header.classList.remove("is-hidden");
      }
      lastY = y;
   };
   window.addEventListener("scroll", onScroll, { passive: true });
   onScroll();

   /* Mobile toggle */
   function closeNav() {
      toggle?.setAttribute("aria-expanded", "false");
      nav?.classList.remove("is-open");
      toggle?.classList.remove("is-open");
      overlay.classList.remove("is-open");
      document.body.classList.remove("nav-open");
   }
   function openNav() {
      toggle?.setAttribute("aria-expanded", "true");
      nav?.classList.add("is-open");
      toggle?.classList.add("is-open");
      overlay.classList.add("is-open");
      document.body.classList.add("nav-open");
   }

   toggle?.addEventListener("click", () => {
      const isOpen = toggle.getAttribute("aria-expanded") === "true";
      isOpen ? closeNav() : openNav();
   });

   overlay.addEventListener("click", closeNav);
   document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeNav();
   });
   nav?.querySelectorAll("a").forEach((a) => {
      a.addEventListener("click", () => closeNav());
   });
})();

/* ─────────────────────────────────────────────────────────── *
 *  3 — SCROLL REVEAL
 * ─────────────────────────────────────────────────────────── */
(function initReveal() {
   /* CSS already in style.css; we just drive the class toggling */
   const els = $$("[data-reveal]");
   if (!els.length) return;
   if (pRM()) {
      els.forEach((el) => el.classList.add("revealed"));
      return;
   }

   const obs = new IntersectionObserver(
      (entries) => {
         entries.forEach(({ isIntersecting, target: el }) => {
            if (!isIntersecting) return;
            const delay = parseInt(
               el.dataset.revealDelay || el.dataset.reveal_delay || "0",
               10,
            );
            setTimeout(() => el.classList.add("revealed"), delay);
            obs.unobserve(el);
         });
      },
      { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
   );

   els.forEach((el) => obs.observe(el));
})();

/* ─────────────────────────────────────────────────────────── *
 *  4 — HERO PARALLAX
 * ─────────────────────────────────────────────────────────── */
(function initParallax() {
   if (pRM()) return;
   const img = $("#heroImg");
   if (!img) return;
   let raf;
   window.addEventListener(
      "scroll",
      () => {
         if (!raf)
            raf = requestAnimationFrame(() => {
               img.style.transform = `translateY(${window.scrollY * 0.28}px)`;
               raf = null;
            });
      },
      { passive: true },
   );
})();

/* ─────────────────────────────────────────────────────────── *
 *  5 — HERO PARTICLES (folhas & pontos nas cores BR)
 * ─────────────────────────────────────────────────────────── */
(function initParticles() {
   if (pRM() || isMobile()) return;
   const hero = $(".hero");
   if (!hero) return;

   injectStyle(
      "particles",
      `
    .particle {
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
      will-change: transform, opacity;
      z-index: 2;
    }
    @keyframes floatUp {
      0%   { transform: translateY(0) translateX(0) rotate(0deg) scale(1); opacity: .7; }
      50%  { transform: translateY(-45vh) translateX(var(--dx)) rotate(180deg) scale(.85); opacity: .5; }
      100% { transform: translateY(-90vh) translateX(calc(var(--dx) * 2)) rotate(360deg) scale(.6); opacity: 0; }
    }
  `,
   );

   const colors = ["#f9b000", "#c8102e", "#1a7a40", "#ffd14d", "#2d9e58"];
   const sizes = [5, 7, 4, 9, 6];

   function spawnParticle() {
      const p = document.createElement("div");
      p.className = "particle";
      const size = sizes[Math.floor(Math.random() * sizes.length)];
      const color = colors[Math.floor(Math.random() * colors.length)];
      const dx = (Math.random() - 0.5) * 200;
      const dur = 6 + Math.random() * 8;
      const delay = Math.random() * 4;
      const left = Math.random() * 100;

      p.style.cssText = `
      width: ${size}px; height: ${size}px;
      background: ${color};
      left: ${left}%;
      bottom: 10%;
      --dx: ${dx}px;
      animation: floatUp ${dur}s ${delay}s ease-in-out forwards;
      opacity: 0;
    `;
      hero.appendChild(p);
      setTimeout(() => p.remove(), (dur + delay + 0.5) * 1000);
   }

   /* Spawn a batch, then keep a slow trickle */
   for (let i = 0; i < 14; i++) spawnParticle();
   setInterval(spawnParticle, 1400);
})();


/* ─────────────────────────────────────────────────────────── *
 *  7 — HORIZONTAL MARQUEE TICKER
 *      Injects just before the footer
 * ─────────────────────────────────────────────────────────── */
(function initMarquee() {
   const footer = $(".site-footer");
   if (!footer) return;

   const places = [
      "Rio de Janeiro",
      "Salvador",
      "Pantanal",
      "Amazônia",
      "Bonito",
      "Foz do Iguaçu",
      "Lençóis Maranhenses",
      "Fernando de Noronha",
      "Chapada Diamantina",
      "Ouro Preto",
      "Manaus",
      "Recife",
      "Florianópolis",
      "Morro de São Paulo",
      "Jalapão",
      "Serra Gaúcha",
      "Ilhéus",
   ];

   /* Duplicate for seamless loop */
   const all = [...places, ...places];
   const items = all
      .map((p) => `<span class="ticker-item"><em>✦</em> ${p}</span>`)
      .join("");

   const ticker = document.createElement("div");
   ticker.className = "marquee-ticker";
   ticker.setAttribute("aria-hidden", "true");
   ticker.innerHTML = `<div class="marquee-track">${items}</div>`;
   footer.insertAdjacentElement("beforebegin", ticker);

   injectStyle(
      "marquee",
      `
    .marquee-ticker {
      background: var(--green-800, #024022);
      overflow: hidden;
      padding: 18px 0;
      border-top: 2px solid var(--gold, #f9b000);
      border-bottom: 2px solid var(--gold, #f9b000);
    }
    .marquee-track {
      display: flex;
      gap: 0;
      width: max-content;
      animation: marqueeScroll 38s linear infinite;
    }
    .marquee-ticker:hover .marquee-track { animation-play-state: paused; }
    @keyframes marqueeScroll {
      from { transform: translateX(0); }
      to   { transform: translateX(-50%); }
    }
    .ticker-item {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 0 40px;
      font-size: .88rem;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: rgba(255,255,255,.85);
      white-space: nowrap;
    }
    .ticker-item em {
      font-style: normal;
      color: var(--gold, #f9b000);
      font-size: .65rem;
    }
    @media (prefers-reduced-motion: reduce) {
      .marquee-track { animation: none; }
    }
  `,
   );
})();

/* ─────────────────────────────────────────────────────────── *
 *  8 — PILLAR CARDS 3-D TILT
 * ─────────────────────────────────────────────────────────── */
(function initTilt() {
   if (pRM() || isMobile()) return;
   $$(".pillar-card").forEach((card) => {
      card.style.willChange = "transform";
      card.addEventListener("mousemove", (e) => {
         const r = card.getBoundingClientRect();
         const dx = (e.clientX - r.left - r.width / 2) / (r.width / 2);
         const dy = (e.clientY - r.top - r.height / 2) / (r.height / 2);
         card.style.transform = `perspective(900px) rotateX(${-dy * 7}deg) rotateY(${dx * 7}deg) translateZ(6px)`;
         card.style.transition = "transform .1s ease";
      });
      card.addEventListener("mouseleave", () => {
         card.style.transition = "transform .5s cubic-bezier(.34,1.56,.64,1)";
         card.style.transform = "";
      });
   });
})();

/* ─────────────────────────────────────────────────────────── *
 *  9 — DESTINATION CARD image zoom (JS-assisted safety)
 * ─────────────────────────────────────────────────────────── */
(function initDestCards() {
   $$(".dest-card").forEach((card) => {
      /* Ensure overflow hidden on the media wrapper */
      const media = $(".dest-media", card);
      const img = $("img", card);
      if (!media || !img) return;
      img.style.transition = "transform .7s cubic-bezier(.25,.8,.25,1)";
      card.addEventListener("mouseenter", () => {
         img.style.transform = "scale(1.07)";
      });
      card.addEventListener("mouseleave", () => {
         img.style.transform = "";
      });
   });
})();

/* ─────────────────────────────────────────────────────────── *
 * 10 — SMOOTH ANCHOR SCROLL
 * ─────────────────────────────────────────────────────────── */
(function initSmoothScroll() {
   document.addEventListener("click", (e) => {
      const a = e.target.closest('a[href^="#"]');
      if (!a) return;
      const target = document.querySelector(a.getAttribute("href"));
      if (!target) return;
      e.preventDefault();
      const offset = ($("#siteHeader")?.offsetHeight ?? 72) + 8;
      window.scrollTo({
         top: target.getBoundingClientRect().top + window.scrollY - offset,
         behavior: "smooth",
      });
   });
})();

/* ─────────────────────────────────────────────────────────── *
 * 11 — NEWSLETTER FORM
 * ─────────────────────────────────────────────────────────── */
(function initNewsletter() {
   const form = $(".nl-form");
   if (!form) return;

   injectStyle(
      "newsletter-ux",
      `
    .nl-success {
      display: flex; flex-direction: column; align-items: center;
      gap: 16px; padding: 32px 0;
      color: var(--gold-light, #ffd14d); text-align: center;
    }
    .nl-success svg { color: var(--gold-light, #ffd14d); }
    .nl-success p   { font-size: 1.05rem; margin: 0; }
    @keyframes shakeInput {
      0%,100%{ transform:translateX(0); }
      20%    { transform:translateX(-8px); }
      40%    { transform:translateX(8px); }
      60%    { transform:translateX(-5px); }
      80%    { transform:translateX(5px); }
    }
    .shake { animation: shakeInput .45s ease; border-color: var(--red,#c8102e) !important; }
  `,
   );

   form.addEventListener("submit", (e) => {
      e.preventDefault();
      const btn = $('button[type="submit"]', form);
      const email = form.querySelector('[name="email"]');
      const first = form.querySelector('[name="first_name"]')?.value.trim();

      if (!email?.value.includes("@")) {
         email?.classList.add("shake");
         email?.addEventListener("animationend", () => email.classList.remove("shake"), {
            once: true,
         });
         return;
      }
      if (btn) {
         btn.disabled = true;
         btn.textContent = "Subscribing…";
      }

      setTimeout(() => {
         form.innerHTML = `
        <div class="nl-success" role="status">
          <svg width="52" height="52" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
            <path d="M7 12.5l3.5 3.5 6-7" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <p>Obrigado${first ? ", " + first : ""}! Prepare-se para receber histórias direto do coração do Brasil. 🇧🇷</p>
        </div>`;
      }, 800);
   });
})();

/* ─────────────────────────────────────────────────────────── *
 * 12 — SCROLL-PROGRESS BAR (gradiente bandeira)
 * ─────────────────────────────────────────────────────────── */
(function initProgress() {
   const bar = document.createElement("div");
   bar.setAttribute("aria-hidden", "true");
   bar.style.cssText = `
    position:fixed; top:0; left:0; height:3px; width:0%;
    background: linear-gradient(90deg,
      #1a7a40 0%, #f9b000 50%, #c8102e 100%);
    z-index:9999; pointer-events:none;
    transition: width .08s linear;
  `;
   document.body.prepend(bar);
   let raf;
   window.addEventListener(
      "scroll",
      () => {
         if (raf) return;
         raf = requestAnimationFrame(() => {
            const d = document.documentElement;
            bar.style.width =
               ((window.scrollY / (d.scrollHeight - d.clientHeight)) * 100).toFixed(1) +
               "%";
            raf = null;
         });
      },
      { passive: true },
   );
})();

/* ─────────────────────────────────────────────────────────── *
 * 13 — CUSTOM CURSOR (desktop only)
 *       Small circle that follows the mouse in BR colors
 * ─────────────────────────────────────────────────────────── */
(function initCursor() {
   if (pRM() || isMobile()) return;

   injectStyle(
      "cursor",
      `
    .cursor-dot {
      position: fixed; top: 0; left: 0;
      width: 10px; height: 10px;
      border-radius: 50%;
      background: var(--gold, #f9b000);
      pointer-events: none; z-index: 99999;
      transform: translate(-50%, -50%);
      transition: width .2s, height .2s, background .3s, opacity .3s;
      mix-blend-mode: multiply;
    }
    .cursor-ring {
      position: fixed; top: 0; left: 0;
      width: 36px; height: 36px;
      border-radius: 50%;
      border: 2px solid rgba(249,176,0,.5);
      pointer-events: none; z-index: 99998;
      transform: translate(-50%, -50%);
      transition: width .35s cubic-bezier(.25,.8,.25,1),
                  height .35s, border-color .3s, opacity .3s;
    }
    body:has(a:hover) .cursor-ring,
    body:has(button:hover) .cursor-ring {
      width: 52px; height: 52px;
      border-color: var(--red, #c8102e);
    }
    body:has(a:hover) .cursor-dot,
    body:has(button:hover) .cursor-dot {
      background: var(--red, #c8102e);
      width: 8px; height: 8px;
    }
  `,
   );

   const dot = document.createElement("div");
   dot.className = "cursor-dot";
   const ring = document.createElement("div");
   ring.className = "cursor-ring";
   document.body.append(dot, ring);

   let mx = -100,
      my = -100,
      rx = -100,
      ry = -100;
   document.addEventListener("mousemove", (e) => {
      mx = e.clientX;
      my = e.clientY;
   });
   document.addEventListener("mouseleave", () => {
      dot.style.opacity = "0";
      ring.style.opacity = "0";
   });
   document.addEventListener("mouseenter", () => {
      dot.style.opacity = "1";
      ring.style.opacity = "1";
   });

   /* Ring follows with lerp for smooth lag */
   (function loop() {
      dot.style.left = mx + "px";
      dot.style.top = my + "px";
      rx += (mx - rx) * 0.12;
      ry += (my - ry) * 0.12;
      ring.style.left = rx + "px";
      ring.style.top = ry + "px";
      requestAnimationFrame(loop);
   })();
})();

/* ─────────────────────────────────────────────────────────── *
 * 14 — NEWS CARD COLOR-BORDER HOVER
 * ─────────────────────────────────────────────────────────── */
(function initNewsCards() {
   const palette = ["#1a7a40", "#c8102e", "#f9b000", "#036830"];
   $$(".news-card").forEach((card, i) => {
      const color = palette[i % palette.length];
      card.style.setProperty("--card-accent", color);
   });

   injectStyle(
      "news-accent",
      `
    .news-card {
      border-top: 3px solid transparent;
      transition: border-color .3s, transform .35s cubic-bezier(.34,1.56,.64,1), box-shadow .35s;
    }
    .news-card:hover {
      border-top-color: var(--card-accent, var(--green-600));
      transform: translateY(-8px);
    }
  `,
   );
})();

/* ─────────────────────────────────────────────────────────── *
 * 15 — ACTIVE NAV on scroll
 * ─────────────────────────────────────────────────────────── */
(function initActiveNav() {
   const navLinks = $$('.main-nav a[href^="#"]');
   if (!navLinks.length) return;
   const map = new Map(navLinks.map((a) => [a.getAttribute("href").slice(1), a]));

   injectStyle(
      "active-nav",
      `
    .main-nav a.is-active:not(.nav-cta) { color: var(--gold, #f9b000) !important; }
    .main-nav a.is-active:not(.nav-cta)::after { width: 100% !important; background: var(--gold,#f9b000) !important; }
  `,
   );

   const obs = new IntersectionObserver(
      (entries) => {
         entries.forEach(({ isIntersecting, target }) => {
            map.get(target.id)?.classList.toggle("is-active", isIntersecting);
         });
      },
      { threshold: 0.35 },
   );

   $$("section[id], article[id]").forEach((s) => {
      if (map.has(s.id)) obs.observe(s);
   });
})();

/* ─────────────────────────────────────────────────────────── *
 * 16 — SCROLL-DOWN ARROW BOUNCE (CSS via JS)
 * ─────────────────────────────────────────────────────────── */
(function initArrow() {
   if (pRM()) return;
   injectStyle(
      "arrow",
      `
    @keyframes arrowBob {
      0%,100%{ transform: translateX(-50%) translateY(0); }
      50%    { transform: translateX(-50%) translateY(8px); }
    }
    .scroll-arrow { animation: arrowBob 2s ease-in-out infinite; }
    .scroll-arrow:hover { color: var(--gold, #f9b000); }
  `,
   );
})();

/* ─────────────────────────────────────────────────────────── *
 * 17 — PARTNER BANNER CAROUSEL
 * ─────────────────────────────────────────────────────────── */
(function initBannerCarousel() {
   const carousel = $("#bannerCarousel");
   if (!carousel) return;

   const track   = $(".banner-track",      carousel);
   const slides  = $$(".partner-banner",   carousel);
   const dots    = $$(".carousel-dot",     carousel);
   const btnPrev = carousel.querySelector(".carousel-btn--prev");
   const btnNext = carousel.querySelector(".carousel-btn--next");

   if (!track || slides.length < 2) {
      slides.forEach(s => s.removeAttribute("tabindex"));
      return;
   }

   let current   = 0;
   let autoTimer = null;
   const INTERVAL = 5000;

   /* Troca o slide ativo apenas por classe — sem cálculo de posição */
   function goTo(index) {
      current = ((index % slides.length) + slides.length) % slides.length;

      slides.forEach((s, i) => {
         const on = i === current;
         s.classList.toggle("is-active", on);
         s.setAttribute("tabindex", on ? "0" : "-1");
         s.setAttribute("aria-hidden", String(!on));
      });

      dots.forEach((d, i) => {
         const on = i === current;
         d.classList.toggle("is-active", on);
         d.setAttribute("aria-selected", String(on));
      });
   }

   /* Autoplay sempre ativo */
   function startAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(() => goTo(current + 1), INTERVAL);
   }
   function stopAuto() { clearInterval(autoTimer); }

   /* Init — primeiro slide já tem is-active no PHP, só sincroniza o JS */
   goTo(0);
   startAuto();

   /* Prev / Next */
   btnPrev && btnPrev.addEventListener("click", () => { goTo(current - 1); startAuto(); });
   btnNext && btnNext.addEventListener("click", () => { goTo(current + 1); startAuto(); });

   /* Dots */
   dots.forEach((dot, i) => {
      dot.addEventListener("click", () => { goTo(i); startAuto(); });
   });

   /* Pause on hover */
   carousel.addEventListener("mouseenter", stopAuto);
   carousel.addEventListener("mouseleave", startAuto);

   /* Keyboard ← → */
   carousel.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft")  { goTo(current - 1); startAuto(); }
      if (e.key === "ArrowRight") { goTo(current + 1); startAuto(); }
   });

   /* Touch / swipe */
   let touchStartX = 0;
   carousel.addEventListener("touchstart", (e) => {
      touchStartX = e.touches[0].clientX;
      stopAuto();
   }, { passive: true });
   carousel.addEventListener("touchend", (e) => {
      const dx = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(dx) > 40) goTo(current + (dx < 0 ? 1 : -1));
      startAuto();
   }, { passive: true });
})();

/* ─────────────────────────────────────────────────────────── *
 * 18 — CLIENT CARDS MODAL
 * ─────────────────────────────────────────────────────────── */
(function initClientModal() {
   const modal    = document.getElementById("clientModal");
   if (!modal) return;
   const backdrop = modal.querySelector(".client-modal__backdrop");
   const closeBtn = modal.querySelector(".client-modal__close");
   const logoEl    = document.getElementById("clientModalLogo");
   const initials  = document.getElementById("clientModalInitials");
   const nameEl    = document.getElementById("clientModalName");
   const descEl    = document.getElementById("clientModalDesc");
   const linkEl    = document.getElementById("clientModalLink");
   const linkText  = document.getElementById("clientModalLinkText");
   const videoWrap = document.getElementById("clientModalVideo");
   const socialWrap = document.getElementById("clientModalSocial");
   const fbEl      = document.getElementById("clientModalFacebook");
   const igEl      = document.getElementById("clientModalInstagram");
   const liEl      = document.getElementById("clientModalLinkedin");
   const ytEl      = document.getElementById("clientModalYoutube");
   let lastFocused = null;

   function openModal(card) {
      const name   = card.dataset.name || "";
      const logo   = card.dataset.logo || "";
      const desc   = card.dataset.desc || "";
      const site   = card.dataset.site || "";
      const iframe = card.dataset.iframe || "";
      nameEl.textContent = name;
      descEl.innerHTML = desc || "Parceiro estratégico do Brasil DNA.";
      if (linkText) linkText.textContent = "Explore " + name;
      if (logo) {
         logoEl.src = logo;
         logoEl.alt = name;
         logoEl.hidden = false;
         if (initials) initials.hidden = true;
      } else {
         logoEl.hidden = true;
         if (initials) initials.hidden = true;
      }
      if (videoWrap) {
         if (iframe) {
            if (iframe.trimStart().startsWith("<")) {
               videoWrap.innerHTML = iframe;
            } else {
               videoWrap.innerHTML = '<iframe src="' + iframe + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }
            videoWrap.hidden = false;
         } else {
            videoWrap.innerHTML = "";
            videoWrap.hidden = true;
         }
      }
      linkEl.href = site || "#";
      linkEl.hidden = !site;
      const fb = card.dataset.facebook || "";
      const ig = card.dataset.instagram || "";
      const li = card.dataset.linkedin || "";
      const yt = card.dataset.youtube || "";
      if (fbEl) { fbEl.href = fb; fbEl.style.display = fb ? '' : 'none'; }
      if (igEl) { igEl.href = ig; igEl.style.display = ig ? '' : 'none'; }
      if (liEl) { liEl.href = li; liEl.style.display = li ? '' : 'none'; }
      if (ytEl) { ytEl.href = yt; ytEl.style.display = yt ? '' : 'none'; }
      if (socialWrap) socialWrap.style.display = (fb || ig || li || yt) ? '' : 'none';
      lastFocused = document.activeElement;
      modal.removeAttribute("hidden");
      modal.offsetHeight; // força reflow para transição CSS
      modal.classList.add("is-open");
      closeBtn.focus();
      document.body.style.overflow = "hidden";
   }

   function closeModal() {
      modal.classList.remove("is-open");
      if (videoWrap) { videoWrap.innerHTML = ""; videoWrap.hidden = true; }
      setTimeout(() => {
         modal.setAttribute("hidden", "");
         document.body.style.overflow = "";
         lastFocused && lastFocused.focus();
      }, 350);
   }

   document.addEventListener("click", (e) => {
      const card = e.target.closest("[data-modal-trigger]");
      if (card) openModal(card);
   });
   document.addEventListener("keydown", (e) => {
      if ((e.key === "Enter" || e.key === " ") && e.target.closest("[data-modal-trigger]")) {
         e.preventDefault();
         openModal(e.target.closest("[data-modal-trigger]"));
      }
      if (e.key === "Escape" && modal.classList.contains("is-open")) closeModal();
   });
   closeBtn && closeBtn.addEventListener("click", closeModal);
   backdrop && backdrop.addEventListener("click", closeModal);
})();

/* ─── HELPER: deduped style injection ───────────────────────*/
function injectStyle(id, css) {
   if (document.getElementById("bdna-style-" + id)) return;
   const s = document.createElement("style");
   s.id = "bdna-style-" + id;
   s.textContent = css;
   document.head.appendChild(s);
}
