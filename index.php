<?php
/**
 * Brasil DNA — Home (Rebranding 2026)
 * Layout estático em PHP para fácil integração futura.
 */
function esc_url_safe($path) {
    return htmlspecialchars($path, ENT_QUOTES, 'UTF-8');
}

$banners_parceiros = [];
try {
    require_once __DIR__ . '/includes/conexao.php';
    $stmt = $pdo->query("SELECT * FROM banners WHERE ativo = 1 ORDER BY ordem ASC, criado_em DESC");
    $banners_parceiros = $stmt->fetchAll();
    if (!empty($banners_parceiros)) {
        $ids = implode(',', array_map('intval', array_column($banners_parceiros, 'id')));
        $pdo->exec("UPDATE banners SET visualizacoes = visualizacoes + 1 WHERE id IN ($ids)");
    }
} catch (\Throwable $e) {
    $banners_parceiros = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Brasil DNA — Experience the Essence of Brazil</title>
<meta name="description" content="Brasil DNA: Where Nature, Culture, and Warmth Create Unforgettable Journeys.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee&family=Playfair+Display:ital,wght@0,700;0,900;1,700;1,900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/style.css?v=4">
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="site-header" id="siteHeader">
  <div class="container header-inner">
    <a href="<?= esc_url_safe('/') ?>" class="logo" aria-label="Brasil DNA — Home">
<svg class="logo-img" aria-label="Brasil DNA" role="img" id="Camada_1" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1847.11 800.51">
  <defs>
    <style>
      .cls-1 {
        letter-spacing: 0em;
      }

      .cls-2 {
        fill: #11723d;
      }

      .cls-3 {
        letter-spacing: 0em;
      }

      .cls-4 {
        fill: #c9423f;
      }

      .cls-5 {
        fill: #f1ab18;
        font-family: Bungee, sans-serif;
        font-size: 270.55px;
      }

      .cls-6 {
        stroke: #fff;
        stroke-miterlimit: 10;
        stroke-width: 6px;
      }
    </style>
  </defs>
  <g>
    <path class="cls-4" d="M623.34,455.11c4.83-.02,7.58,3.94,7.99,7.29.45,3.64-1.94,8.79-6.52,9.01-24.36,1.17-47.42-7.47-65.8-23.26-10.39-8.92-19.37-18.4-27.22-29.56l-22.28-31.65c-17.19-24.42-37.33-53.2-67.36-60.51-.5-.23-1.01-.47-1.51-.7-19.52-5.48-41.57-3.91-59.95,6.29-20.39,11.32-34.49,28.89-47.7,47.78l-23.76,33.98c-9.36,13.39-19.85,25.23-32.35,35.67-18.61,15.55-41.14,22.77-65.36,22.24-45.91-1.01-72.57-29.99-97.19-65.05l-25.74-36.66-9.47-11.18c-1.04-1.33-2.07-2.66-3.11-3.99-17.3-19.76-38.9-32.22-65.92-32.11-4.68.02-7.92-3.35-8.33-7.39-.35-3.51,1.76-8.74,6.46-8.95,23.61-1.02,45.97,7.21,64.18,22.1,33.37,27.29,49.72,67.21,79.39,98.4,9.28,9.76,19.59,17.53,32.69,22.84,3.96,1.23,7.92,2.46,11.88,3.69,11.96,2.21,23.97,2.24,35.89-.02,3.99-1.21,7.98-2.42,11.97-3.62,14.75-6.19,26.33-15.62,36.1-26.6,1.54-1.85,3.07-3.7,4.61-5.55l3.09-4.54,5.05-5.04,24.08-34.59c24.4-35.05,50.21-64.81,95.81-67.24,46.35-2.47,76.6,23.29,101.86,59.42l25.3,36.18c20.55,29.38,45,53.52,83.25,53.33Z"/>
    <path class="cls-4" d="M424.68,454.89c18.13-.9,34.37-8.36,48.36-20.21,12.28-10.78,21.74-23.23,31.88-37.08l10.09,14.38c-23.92,33.28-50.95,59.14-94.44,59.73-45.35.62-73.11-24.75-98.06-59.82l9.99-14.36,17.74,22.94c17.48,20.08,35.54,31.74,62.53,34.61,3.97-.07,7.94-.13,11.9-.2Z"/>
    <path class="cls-4" d="M276.53,350.38c-28.02-29.2-69.26-36.84-104.62-16.02l-1.17,1.05-12.35,8.89c-11.3,10.89-20.75,22.51-30.22,35.93l-10.08-14.35c25.19-35.82,54.78-61.81,101.02-59.76,41.99,1.86,68.17,27.16,91.47,59.77l-10.1,14.4c-7.68-10.93-15.27-20.45-23.95-29.9Z"/>
    <path class="cls-4" d="M569.91,342.77c3.11-2.41,6.23-4.83,9.34-7.24l-13.52,10.36c-11.07,10.15-19.68,21.97-28.84,34.37l-9.97-14.44c9.92-13.76,20.37-26.6,33.58-37.48,18.22-15.01,40.66-23.12,64.34-22,4.59.22,6.96,5.61,6.51,8.92-.66,4.84-4.35,6.97-9.34,7.47l-16.91,1.7c-3.96,1.24-7.92,2.47-11.88,3.71-4.3,2.2-8.6,4.41-12.89,6.61"/>
  </g>
  <path class="cls-4" d="M61.5,433.84c-3.11,2.41-6.23,4.83-9.34,7.24l13.52-10.36c11.07-10.15,19.68-21.97,28.84-34.37l9.97,14.44c-9.92,13.76-20.37,26.6-33.58,37.48-18.22,15.01-40.66,23.12-64.34,22-4.59-.22-6.96-5.61-6.51-8.92.66-4.84,4.35-6.97,9.34-7.47l16.91-1.7c3.96-1.24,7.92-2.47,11.88-3.71,4.3-2.2,8.6-4.41,12.89-6.61"/>
  <path class="cls-4" d="M88.89,477.83c-3.11,2.41-6.23,4.83-9.34,7.24l13.52-10.36c11.07-10.15,19.68-21.97,28.84-34.37l9.97,14.44c-9.92,13.76-20.37,26.6-33.58,37.48-18.22,15.01-40.66,23.12-64.34,22-4.59-.22-6.96-5.61-6.51-8.92.66-4.84,4.35-6.97,9.34-7.47l16.91-1.7c3.96-1.24,7.92-2.47,11.88-3.71,4.3-2.2,8.6-4.41,12.89-6.61"/>
  <path class="cls-4" d="M543.94,483c3.11,2.41,6.23,4.83,9.34,7.24l-13.52-10.36c-11.07-10.15-19.68-21.97-28.84-34.37l-9.97,14.44c9.92,13.76,20.37,26.6,33.58,37.48,18.22,15.01,40.66,23.12,64.34,22,4.59-.22,6.96-5.61,6.51-8.92-.66-4.84-4.35-6.97-9.34-7.47l-16.91-1.7c-3.96-1.24-7.92-2.47-11.88-3.71-4.3-2.2-8.6-4.41-12.89-6.61"/>
  <ellipse class="cls-4" cx="268.06" cy="268.05" rx="22.51" ry="23.2"/>
  <ellipse class="cls-4" cx="369.68" cy="268.24" rx="22.51" ry="23.2"/>
  <path class="cls-6" d="M148.28,387.03c10.83,26.44,36.15,44.11,64.37,44.96,29.62.89,57.03-16.91,68.57-44.64-14.65-28.43-44.57-45-74.72-41.73-38.7,4.2-56.93,38.84-58.22,41.4Z"/>
  <path class="cls-6" d="M354.48,387.6c10.83,26.44,36.15,44.11,64.37,44.96,29.62.89,57.03-16.91,68.57-44.64-14.65-28.43-44.57-45-74.72-41.73-38.7,4.2-56.93,38.84-58.22,41.4Z"/>
  <path class="cls-2" d="M45.5,128.67c13.2,2.92,26.4,5.85,39.6,8.77,22.31,4.1,43.08,12.05,62.35,23.74,15,9.1,26.15,21.6,32.43,38.03,7.36,15.82,10.22,32.63,9.52,50.18-.37,9.27.33,17.5,3.07,26.82-36.6,3.79-83.53-3.23-106.75-30.61-12.95-15.27-20.63-33.68-24.96-53.25-3.7-16.7-10.78-43.62-16.39-54.19-.64-1.21-4.58-8.4-3.25-9.41.15-.12.34-.13.45-.12l3.94.03Z"/>
  <path class="cls-2" d="M587.5,129.95c-13.2,2.92-26.4,5.85-39.6,8.77-22.31,4.1-43.08,12.05-62.35,23.74-15,9.1-26.15,21.6-32.43,38.03-7.36,15.82-10.22,32.63-9.52,50.18.37,9.27-.33,17.5-3.07,26.82,36.6,3.79,83.53-3.23,106.75-30.61,12.95-15.27,20.63-33.68,24.96-53.25,3.7-16.7,10.78-43.62,16.39-54.19.64-1.21,4.58-8.4,3.25-9.41-.15-.12-.34-.13-.45-.12l-3.94.03Z"/>
  <path class="cls-2" d="M316.59,3.05c7.27,11.4,14.53,22.8,21.8,34.2,12.88,18.67,21.94,38.98,27.3,60.87,4.17,17.04,3.22,33.77-3.96,49.82-5.98,16.39-15.85,30.3-28.75,42.22-6.81,6.29-12.14,12.6-16.79,21.14-28.56-23.2-56.78-61.35-53.84-97.13,1.64-19.96,9.23-38.41,20-55.3,9.2-14.43,23.22-38.46,26.72-49.91.4-1.31,2.7-9.17,4.35-8.95.19.03.33.15.41.24l2.76,2.81Z"/>
  <text class="cls-5" transform="translate(712.59 274.13)"><tspan x="0" y="0">BRASI</tspan><tspan class="cls-1" x="934.2" y="0">L</tspan></text>
  <text class="cls-5" transform="translate(710.64 552.69)"><tspan x="0" y="0">dn</tspan><tspan class="cls-3" x="405.55" y="0">a</tspan></text>
</svg>
    </a>

    <nav class="main-nav" id="mainNav" aria-label="Navegação principal">
      <a href="<?= esc_url_safe('about-us.php') ?>">About Us</a>
      <a href="news.php">News</a>
      <a href="#destinos" class="nav-cta">Explore Brazil</a>
    </nav>

    <button class="nav-toggle" id="navToggle" aria-label="Abrir menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<!-- ===== HERO ===== -->
<section class="hero" id="hero">
  <div class="hero-bg">
    <img
      src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=2400&q=80"
      alt="Vista aérea do Rio de Janeiro ao pôr do sol"
      class="hero-img" id="heroImg" fetchpriority="high">
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-flag-stripe" aria-hidden="true">
    <span class="stripe stripe--green"></span>
    <span class="stripe stripe--yellow"></span>
    <span class="stripe stripe--green"></span>
  </div>

  <div class="container hero-body">
    <div class="hero-eyebrow" data-reveal>
      <span class="hashtag">#discoverbrasildna</span>
    </div>
    <h1 data-reveal data-reveal-delay="100">
      Experience the<br><em>Essence of Brazil</em>
    </h1>
    <p class="hero-lead" data-reveal data-reveal-delay="200">
      Where nature, culture, and warmth create unforgettable journeys.
    </p>
    <div class="hero-actions" data-reveal data-reveal-delay="300">
      <a href="#concept" class="btn btn-primary">Discover the DNA</a>
      <a href="#destinos" class="btn btn-ghost">View Destinations</a>
    </div>

    <div class="hero-pillars" data-reveal data-reveal-delay="420">
      <a href="#authenticity" class="pillar-tag"><span>A</span>uthenticity</a>
      <a href="#treasures"    class="pillar-tag"><span>T</span>reasures</a>
      <a href="#gastronomy"   class="pillar-tag"><span>G</span>astronomy</a>
      <a href="#culture"      class="pillar-tag"><span>C</span>ulture</a>
    </div>
  </div>

  <div class="hero-partners" data-reveal data-reveal-delay="520">
    <img src="https://brasildna.com/wp-content/uploads/2025/09/Brasil.png"
         alt="Marca Brasil" loading="lazy">
    <img src="https://brasildna.com/wp-content/uploads/2025/09/Logo-Embratur-2023-Cinza-1024x157-copiar.png"
         alt="Embratur" loading="lazy">
    <img src="https://brasildna.com/wp-content/uploads/2025/09/ministerio-do-turismo.png"
         alt="Ministério do Turismo" loading="lazy">
  </div>

  <a href="#why" class="scroll-arrow" aria-label="Rolar para baixo">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
      <path d="M12 5v14M5 12l7 7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </a>
</section>

<!-- ===== WHY TRAVEL ===== -->
<section class="section why" id="why">
  <div class="container grid-2">
    <div class="why-video" data-reveal>
      <div class="video-wrap">
        <iframe
          src="https://www.youtube.com/watch?v=K7XSoVAnq8E"
          title="Brasil DNA — What do people who visit Brazil have to say?"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
      <p class="video-caption">What do people who visit Brazil have to say?</p>
    </div>

    <div class="why-text" data-reveal data-reveal-delay="120">
      <span class="label-tag">Why Travel to Brazil?</span>
      <h2>A force that touches the heart and <em>awakens the senses</em></h2>
      <p>Brazil is more than a destination — it's the rhythm of samba at twilight, the stillness of a jaguar in the wild, the warmth of a shared moqueca, and the roar of waterfalls that remind us how small we are — yet how connected we can be.</p>
      <p>Through <strong>Brasil DNA</strong>, you're invited to step into a curated journey across four breathtaking regions, each revealing a facet of Brazil's identity rooted in <strong>nature, culture, and purposeful travel</strong>.</p>
    </div>
  </div>
</section>

<!-- ===== DNA CONCEPT ===== -->
<section class="section concept" id="concept">
  <div class="concept-bg" aria-hidden="true"></div>
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="label-tag label-tag--light">The Brasil DNA Concept</span>
      <h2>Four pillars. One <em>genetic code</em>.</h2>
      <p class="section-lead">Just as human DNA is built from four nitrogenous bases — A, G, C, T — Brasil DNA identifies four pillars that define the genetic code of Brazil as a tourism destination.</p>
    </div>

    <div class="pillars-grid">
      <article class="pillar-card" id="authenticity" data-reveal data-reveal-delay="0">
        <div class="pillar-letter-wrap"><span>A</span></div>
        <div class="pillar-body">
          <h3>Authenticity</h3>
          <p>A powerful, intangible quality that can only be understood through experience — the genuine, heartfelt warmth of the Brazilian people, where strangers are greeted like friends, and hospitality is a natural expression of everyday life.</p>
        </div>
      </article>

      <article class="pillar-card" id="gastronomy" data-reveal data-reveal-delay="80">
        <div class="pillar-letter-wrap"><span>G</span></div>
        <div class="pillar-body">
          <h3>Gastronomy</h3>
          <p>A celebration of Brazil's history, biodiversity, and cultural fusion. The flavors, aromas, and stories of Brazilian cuisine make it a journey in itself, inviting visitors to explore the country's stories through its flavors.</p>
        </div>
      </article>

      <article class="pillar-card" id="culture" data-reveal data-reveal-delay="160">
        <div class="pillar-letter-wrap"><span>C</span></div>
        <div class="pillar-body">
          <h3>Culture</h3>
          <p>A dynamic, colorful mosaic of traditions, artistry, and creativity — where history meets innovation and diversity is celebrated as the essence of identity. Culture in Brazil is not static; it is alive and evolving.</p>
        </div>
      </article>

      <article class="pillar-card" id="treasures" data-reveal data-reveal-delay="240">
        <div class="pillar-letter-wrap"><span>T</span></div>
        <div class="pillar-body">
          <h3>Tesouros <em>(Treasures)</em></h3>
          <p>Brazil's natural treasures are unparalleled — ecosystems so vast and diverse they seem otherworldly. Its biodiversity, landscapes, and conservation efforts showcase a commitment to preserving the earth's extraordinary wonders.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ===== FEEL BRASIL ===== -->
<section class="section feel" id="feel">
  <div class="container grid-2 grid-2--reverse">
    <div class="feel-text" data-reveal>
      <span class="label-tag">Feel Brasil</span>
      <h2>Discover Brazil through <em>authentic experiences</em></h2>
      <p>Created by <strong>Embratur</strong>, the <strong>Feel Brasil</strong> initiative highlights authentic travel experiences across the country, showcasing curated journeys that connect visitors with Brazil's nature, culture, communities, and traditions.</p>
      <p>Through Feel Brasil, travelers can discover immersive activities such as exploring protected natural areas, experiencing local gastronomy, and engaging with community-based tourism.</p>
      <a href="https://www.embratur.com.br" target="_blank" rel="noopener" class="btn btn-primary">Learn More</a>
    </div>

    <div class="feel-video" data-reveal data-reveal-delay="120">
      <div class="video-wrap">
        <iframe
          src="https://www.youtube.com/watch?v=ywZe6LAa0oY"
          title="Feel Brasil — Vitrine Brasil"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>

<!-- ===== DESTINATIONS ===== -->
<section class="section destinations" id="destinos">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="label-tag">Brazilian Destinations</span>
      <h2>Places that stay <em>with you forever</em></h2>
    </div>

    <!-- Destination: Bahia -->
    <article class="dest-card" data-reveal>
      <div class="dest-media">
        <img src="https://images.unsplash.com/photo-1583531352515-8884af319dc1?w=1400&q=80"
             alt="Bahia — Salvador" loading="lazy">
      </div>
      <div class="dest-info">
        <span class="dest-region">Nordeste</span>
        <h3>Bahia: Where Brazil's Essence Comes to Life</h3>
        <p>Located in northeastern Brazil, Bahia is one of the country's most iconic and culturally rich destinations — considered the birthplace of Brazil, where history, nature, spirituality, music, and traditions blend into unforgettable travel experiences.</p>
        <p>From the vibrant streets of <strong>Salvador</strong> to paradise beaches, colonial towns, waterfalls, and protected natural areas, Bahia offers extraordinary diversity.</p>
        <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-bahia-2026/" target="_blank" rel="noopener" class="dest-link">
          Explore Bahia
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </article>

    <!-- Destination: Mato Grosso do Sul -->
    <article class="dest-card dest-card--flip" data-reveal>
      <div class="dest-media">
        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=1400&q=80"
             alt="Pantanal — Mato Grosso do Sul" loading="lazy">
      </div>
      <div class="dest-info">
        <span class="dest-region">Centro-Oeste</span>
        <h3>Mato Grosso do Sul: Pantanal & Beyond</h3>
        <p>Home to the world's largest tropical wetland — the <strong>Pantanal</strong> — and the crystal-clear rivers of Bonito, Mato Grosso do Sul is a paradise for nature lovers and adventure seekers alike.</p>
        <p>Two icons. One unforgettable journey. Authentic, sustainable, and truly memorable.</p>
        <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-mato-grosso-do-sul-2026/" target="_blank" rel="noopener" class="dest-link">
          Explore Mato Grosso do Sul
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </article>
  </div>
</section>

<!-- ===== PARTNERS ===== -->
<section class="section partners" id="partners">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="label-tag">Our Partners</span>
      <h2>Trusted voices on the <em>ground</em></h2>
    </div>

    <div class="partners-row">
      <article class="partner-card" data-reveal>
        <div class="partner-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" fill="currentColor"/></svg>
        </div>
        <h3>Compass Brazil</h3>
        <p class="partner-since">Since 1979 · Rio de Janeiro</p>
        <p>Curating journeys that reveal the essence of Brazil through authenticity, creativity, and genuine connection — operating nationwide.</p>
        <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-compass-2026/" target="_blank" rel="noopener" class="partner-link">Explore →</a>
      </article>

      <article class="partner-card" data-reveal data-reveal-delay="120">
        <div class="partner-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M17 8C8 10 5.9 16.17 3.82 21H5.71C6.93 18.08 10 13 17 12v3l4-4-4-4v3z" fill="currentColor"/></svg>
        </div>
        <h3>NEx — Natural Experience</h3>
        <p class="partner-since">Mato Grosso do Sul</p>
        <p>Curated nature-based travel experiences across Bonito and the Pantanal — connecting travelers to authentic encounters with nature and conservation.</p>
        <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-nex-2026/" target="_blank" rel="noopener" class="partner-link">Explore →</a>
      </article>
    </div>
  </div>
</section>

<!-- ===== NEWS ===== -->
<section class="section news" id="news">
  <div class="container">
    <div class="section-head" data-reveal>
      <span class="label-tag">Latest Stories</span>
      <h2>News &amp; <em>Inspiration</em></h2>
    </div>

    <div class="news-grid">
      <article class="news-card" data-reveal>
        <a href="https://brasildna.com/bahia-beyond-carnival/" target="_blank" rel="noopener" class="news-img-link">
          <img src="https://images.unsplash.com/photo-1583531352515-8884af319dc1?w=700&q=80" alt="Bahia" loading="lazy">
        </a>
        <div class="news-body">
          <span class="news-date">06/09/2026</span>
          <h3><a href="https://brasildna.com/bahia-beyond-carnival/" target="_blank" rel="noopener">Beyond the Carnival Parades — Bahia as You've Never Seen It Before</a></h3>
          <a class="news-more" href="https://brasildna.com/bahia-beyond-carnival/" target="_blank" rel="noopener">Read more →</a>
        </div>
      </article>

      <article class="news-card" data-reveal data-reveal-delay="80">
        <a href="https://brasildna.com/far-beyond-the-pantanal-mato-grosso-do-sul/" target="_blank" rel="noopener" class="news-img-link">
          <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=700&q=80" alt="Pantanal" loading="lazy">
        </a>
        <div class="news-body">
          <span class="news-date">05/27/2026</span>
          <h3><a href="https://brasildna.com/far-beyond-the-pantanal-mato-grosso-do-sul/" target="_blank" rel="noopener">Far Beyond the Pantanal — The Riches of Mato Grosso do Sul</a></h3>
          <a class="news-more" href="https://brasildna.com/far-beyond-the-pantanal-mato-grosso-do-sul/" target="_blank" rel="noopener">Read more →</a>
        </div>
      </article>

      <article class="news-card" data-reveal data-reveal-delay="160">
        <a href="https://brasildna.com/foz-do-iguacu-beyond-the-falls/" target="_blank" rel="noopener" class="news-img-link">
          <img src="https://images.unsplash.com/photo-1544731612-de7f96afe55f?w=700&q=80" alt="Foz do Iguaçu" loading="lazy">
        </a>
        <div class="news-body">
          <span class="news-date">05/22/2026</span>
          <h3><a href="https://brasildna.com/foz-do-iguacu-beyond-the-falls/" target="_blank" rel="noopener">Beyond the Falls — The Beauty and Richness of Foz do Iguaçu</a></h3>
          <a class="news-more" href="https://brasildna.com/foz-do-iguacu-beyond-the-falls/" target="_blank" rel="noopener">Read more →</a>
        </div>
      </article>

      <article class="news-card" data-reveal data-reveal-delay="240">
        <a href="https://brasildna.com/mato-grosso-do-sul-fidi-2026-smart-tourism/" target="_blank" rel="noopener" class="news-img-link">
          <img src="https://images.unsplash.com/photo-1543059080358-a20ce2f6c83f?w=700&q=80" alt="FIDI" loading="lazy">
        </a>
        <div class="news-body">
          <span class="news-date">05/22/2026</span>
          <h3><a href="https://brasildna.com/mato-grosso-do-sul-fidi-2026-smart-tourism/" target="_blank" rel="noopener">Mato Grosso do Sul as Host of the 3rd Edition of FIDI</a></h3>
          <a class="news-more" href="https://brasildna.com/mato-grosso-do-sul-fidi-2026-smart-tourism/" target="_blank" rel="noopener">Read more →</a>
        </div>
      </article>
    </div>

    <div class="section-cta" data-reveal>
      <a href="news.php" class="btn btn-outline">See All Publications</a>
    </div>
  </div>
</section>

<!-- ===== PARTNER BANNERS ===== -->
<?php if (!empty($banners_parceiros)): ?>
<section class="partner-banners" id="partner-banners">
  <div class="container">
    <span class="label-tag" data-reveal>Partner Spotlight</span>
    <div class="banner-carousel" id="bannerCarousel">
      <div class="banner-track">
        <?php foreach ($banners_parceiros as $idx => $b):
          $logoUrl  = htmlspecialchars($b['logo_url']     ?? '',          ENT_QUOTES, 'UTF-8');
          $bgUrl    = htmlspecialchars($b['imagem_url']   ?? '',          ENT_QUOTES, 'UTF-8');
          $titulo   = htmlspecialchars($b['titulo']       ?? '');
          $subtexto = htmlspecialchars($b['subtexto']     ?? '');
          $btnTxt   = htmlspecialchars($b['botao_texto']  ?? 'Learn More');
          $partner  = htmlspecialchars($b['nome_parceiro']);
          $activeClass = $idx === 0 ? ' is-active' : '';
        ?>
        <a href="banner-click.php?id=<?= (int)$b['id'] ?>" class="partner-banner<?= $activeClass ?>" target="_blank" rel="noopener noreferrer" tabindex="<?= $idx === 0 ? '0' : '-1' ?>">
          <?php if ($bgUrl): ?>
            <img class="partner-banner__bg" src="<?= $bgUrl ?>" alt="" aria-hidden="true" loading="lazy">
          <?php endif; ?>
          <div class="partner-banner__overlay"></div>

          <div class="partner-banner__left">
            <?php if ($logoUrl): ?>
              <img class="partner-banner__logo" src="<?= $logoUrl ?>" alt="<?= $partner ?>" loading="lazy">
            <?php else: ?>
              <span class="partner-banner__logo-text"><?= $partner ?></span>
            <?php endif; ?>
            <?php if ($subtexto): ?>
              <p class="partner-banner__sub"><?= $subtexto ?></p>
            <?php endif; ?>
          </div>

          <div class="partner-banner__right">
            <?php if ($titulo): ?>
              <p class="partner-banner__title"><?= $titulo ?></p>
            <?php endif; ?>
            <?php if ($btnTxt): ?>
              <span class="partner-banner__btn"><?= $btnTxt ?></span>
            <?php endif; ?>
          </div>
        </a>
        <?php endforeach; ?>
      </div>

      <?php if (count($banners_parceiros) > 1): ?>
      <button class="carousel-btn carousel-btn--prev" aria-label="Banner anterior">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <button class="carousel-btn carousel-btn--next" aria-label="Próximo banner">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="carousel-dots" role="tablist" aria-label="Banners de parceiros">
        <?php foreach ($banners_parceiros as $i => $b): ?>
        <button class="carousel-dot<?= $i === 0 ? ' is-active' : '' ?>" role="tab" aria-label="Banner <?= $i + 1 ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"></button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== NEWSLETTER ===== -->
<section class="newsletter" id="newsletter">
  <div class="nl-bg" aria-hidden="true"></div>
  <div class="container newsletter-inner" data-reveal>
    <div class="nl-text">
      <span class="label-tag label-tag--light">Stay in the Loop</span>
      <h2>Receive <em>Brasil DNA</em> stories directly in your inbox</h2>
      <p>Subscribe and receive news and exclusive content from the heart of Brazil.</p>
    </div>
    <form class="nl-form" action="#" method="post" autocomplete="off">
      <div class="nl-row">
        <input type="text"  name="first_name" placeholder="First Name" required>
        <input type="text"  name="last_name"  placeholder="Last Name"  required>
      </div>
      <div class="nl-row">
        <input type="email" name="email" placeholder="Your e-mail" required>
        <button type="submit" class="btn btn-primary">Subscribe</button>
      </div>
    </form>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="site-footer">
  <div class="container footer-top">
    <div class="footer-brand">
      <img src="https://brasildna.com/wp-content/uploads/2025/09/LOGO-BRASIL-DNA-COLORIDO-e1746120427382.png"
           alt="Brasil DNA" class="footer-logo" height="40" loading="lazy">
      <p>Experience the Essence of Brazil.</p>
      <div class="social-links">
        <a href="https://www.facebook.com/brasildna" target="_blank" rel="noopener" aria-label="Facebook">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M22 12a10 10 0 10-11.6 9.9v-7H8v-2.9h2.4V9.8c0-2.4 1.4-3.7 3.6-3.7 1 0 2.1.2 2.1.2v2.5h-1.2c-1.2 0-1.5.7-1.5 1.5v1.8H16l-.4 2.9h-2.1v7A10 10 0 0022 12z"/></svg>
        </a>
        <a href="https://www.instagram.com/dnabrasil_official" target="_blank" rel="noopener" aria-label="Instagram">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2 0 2 .2 2.6.5.7.2 1.2.6 1.7 1.1.5.5.8 1 1.1 1.7.2.6.4 1.4.5 2.6 0 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c0 1.2-.2 2-.5 2.6-.2.7-.6 1.2-1.1 1.7-.5.5-1 .8-1.7 1.1-.6.2-1.4.4-2.6.5-1.2 0-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2 0-2-.2-2.6-.5-.7-.2-1.2-.6-1.7-1.1-.5-.5-.8-1-1.1-1.7-.2-.6-.4-1.4-.5-2.6 0-1.2-.1-1.6-.1-4.8s0-3.6.1-4.8c0-1.2.2-2 .5-2.6.2-.7.6-1.2 1.1-1.7.5-.5 1-.8 1.7-1.1.6-.2 1.4-.4 2.6-.5C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-1 0-1.6.2-1.9.3-.5.2-.8.4-1.2.7-.3.4-.5.7-.7 1.2-.1.3-.3.9-.3 1.9-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c0 1 .2 1.6.3 1.9.2.5.4.8.7 1.2.4.3.7.5 1.2.7.3.1.9.3 1.9.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1 0 1.6-.2 1.9-.3.5-.2.8-.4 1.2-.7.3-.4.5-.7.7-1.2.1-.3.3-.9.3-1.9.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c0-1-.2-1.6-.3-1.9-.2-.5-.4-.8-.7-1.2-.4-.3-.7-.5-1.2-.7-.3-.1-.9-.3-1.9-.3-1.2-.1-1.6-.1-4.7-.1zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 1.8a3.2 3.2 0 100 6.4 3.2 3.2 0 000-6.4zm5.4-3.4a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
        </a>
        <a href="https://www.linkedin.com/company/global-vision-access/" target="_blank" rel="noopener" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8.3 9.5H5.7V18h2.6V9.5zM7 8.4a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm11 9.6h-2.6v-4.1c0-1 0-2.3-1.4-2.3s-1.6 1.1-1.6 2.2V18H10v-8.5h2.5v1.2h.1c.4-.7 1.3-1.4 2.6-1.4 2.8 0 3.3 1.8 3.3 4.2V18z"/></svg>
        </a>
      </div>
    </div>

    <nav class="footer-nav">
      <h4>Navigate</h4>
      <a href="<?= esc_url_safe('about-us.php') ?>">About Us</a>
      <a href="news.php">News</a>
      <a href="#destinos">Destinations</a>
      <a href="parceiro/login.php" class="footer-partner-link">Be Our Partner</a>
    </nav>

    <div class="footer-presented">
      <h4>Initiative presented by</h4>
      <img src="https://brasildna.com/wp-content/uploads/2025/09/GVA-LOGO-COLORIDO-PREENCHIDO-WHITE-1024x308.png"
           alt="GVA — Global Vision Access" loading="lazy">
    </div>
  </div>

  <div class="footer-partners-bar">
    <div class="container footer-partners-row">
      <img src="https://brasildna.com/wp-content/uploads/2025/09/Brasil.png" alt="Marca Brasil" loading="lazy">
      <img src="https://brasildna.com/wp-content/uploads/2025/09/Logo-Embratur-2023-Cinza-1024x157-copiar.png" alt="Embratur" loading="lazy">
      <img src="https://brasildna.com/wp-content/uploads/2025/09/ministerio-do-turismo.png" alt="Ministério do Turismo" loading="lazy">
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container painel">
      <p>&copy; <?= date('Y') ?> Brasil DNA. All rights reserved.</p>
      <a href="./admin/login.php">administrative panel</a>
    </div>
  </div>
</footer>

<script src="assets/main.js?v=3" defer></script>
</body>
</html>
