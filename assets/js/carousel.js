import { $, $$ } from './utils.js';

export function initBannerCarousel() {
   const carousel = $("#bannerCarousel");
   if (!carousel) return;

   const track   = $(".banner-track",    carousel);
   const slides  = $$(".partner-banner", carousel);
   const dots    = $$(".carousel-dot",   carousel);
   const btnPrev = carousel.querySelector(".carousel-btn--prev");
   const btnNext = carousel.querySelector(".carousel-btn--next");

   if (!track || slides.length < 2) {
      slides.forEach(s => s.removeAttribute("tabindex"));
      return;
   }

   const PER_PAGE = 3;
   let current    = 0;
   let autoTimer  = null;
   const INTERVAL = 5000;
   const pageDots = document.getElementById("bannerPageDots");

   const isNarrow = () => window.innerWidth <= 700;

   function pageCount() {
      return isNarrow() ? Math.ceil(slides.length / PER_PAGE) : slides.length;
   }

   function buildPageDots() {
      if (!pageDots) return;
      pageDots.innerHTML = "";
      if (!isNarrow() || slides.length <= PER_PAGE) {
         pageDots.classList.remove("is-visible");
         return;
      }
      pageDots.classList.add("is-visible");
      for (let i = 0; i < pageCount(); i++) {
         const btn = document.createElement("button");
         btn.className = "carousel-pdot" + (i === current ? " is-active" : "");
         btn.setAttribute("aria-label", `Página ${i + 1}`);
         btn.addEventListener("click", () => goTo(i));
         pageDots.appendChild(btn);
      }
   }

   function updatePageDots() {
      if (!pageDots) return;
      pageDots.querySelectorAll(".carousel-pdot").forEach((d, i) => {
         d.classList.toggle("is-active", i === current);
      });
   }

   function goTo(index) {
      const pages = pageCount();
      current = ((index % pages) + pages) % pages;

      if (isNarrow()) {
         track.style.transform = `translateX(-${current * carousel.offsetWidth}px)`;

         const needsArrows = slides.length > PER_PAGE;
         if (btnPrev) btnPrev.style.display = needsArrows ? "" : "none";
         if (btnNext) btnNext.style.display = needsArrows ? "" : "none";

         slides.forEach(s => {
            s.removeAttribute("aria-hidden");
            s.setAttribute("tabindex", "0");
         });
         updatePageDots();
      } else {
         track.style.transform = "";
         if (pageDots) pageDots.classList.remove("is-visible");

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

         if (btnPrev) btnPrev.style.display = "";
         if (btnNext) btnNext.style.display = "";
      }
   }

   function startAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(() => goTo(current + 1), INTERVAL);
   }
   function stopAuto() { clearInterval(autoTimer); }

   buildPageDots();
   goTo(0);
   startAuto();

   btnPrev && btnPrev.addEventListener("click", () => { goTo(current - 1); startAuto(); });
   btnNext && btnNext.addEventListener("click", () => { goTo(current + 1); startAuto(); });

   dots.forEach((dot, i) => dot.addEventListener("click", () => { goTo(i); startAuto(); }));

   carousel.addEventListener("mouseenter", stopAuto);
   carousel.addEventListener("mouseleave", startAuto);

   carousel.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft")  { goTo(current - 1); startAuto(); }
      if (e.key === "ArrowRight") { goTo(current + 1); startAuto(); }
   });

   let touchStartX = 0;
   carousel.addEventListener("touchstart", (e) => {
      touchStartX = e.touches[0].clientX; stopAuto();
   }, { passive: true });
   carousel.addEventListener("touchend", (e) => {
      const dx = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(dx) > 40) goTo(current + (dx < 0 ? 1 : -1));
      startAuto();
   }, { passive: true });

   window.addEventListener("resize", () => { current = 0; buildPageDots(); goTo(0); startAuto(); });
}
