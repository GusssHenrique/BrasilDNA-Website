<?php
/**
 * Brasil DNA — Home (Rebranding 2026)
 * Layout estático em PHP para fácil integração futura.
 */
function esc_url_safe($path) {
    return htmlspecialchars($path, ENT_QUOTES, 'UTF-8');
}

$banners_parceiros = [];
$clientes_home = [];
try {
    require_once __DIR__ . '/includes/conexao.php';
    $stmt = $pdo->query("SELECT * FROM banners WHERE ativo = 1 ORDER BY ordem ASC, criado_em DESC");
    $banners_parceiros = $stmt->fetchAll();
    if (!empty($banners_parceiros)) {
        $ids = implode(',', array_map('intval', array_column($banners_parceiros, 'id')));
        $pdo->exec("UPDATE banners SET visualizacoes = visualizacoes + 1 WHERE id IN ($ids)");
    }
    $_raw = $pdo->query("SELECT id, titulo, logo, descricao, iframe, video, site, link_guia FROM clientes ORDER BY criado_em ASC")->fetchAll();
    shuffle($_raw);
    $clientes_home = $_raw;
} catch (\Throwable $e) {
    $banners_parceiros = [];
    $clientes_home = [];
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
<img src="assets/images/logo_brasilDNA_preto.webp" alt="Brasil DNA" class="logo-img" height="50" loading="eager">
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
    <img src="assets/images/Logotipo_Brasil.png"
         alt="Marca Brasil" loading="lazy">
    <img src="assets/images/embratur.png"
         alt="Embratur" loading="lazy">
    <img src="assets/images/ministerio-do-turismo.png"
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
          src="https://www.youtube.com/embed/9tVQt1GnIHs"
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
          src="https://www.youtube.com/embed/ywZe6LAa0oY"
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
      <div class="dest-media dest-media--video" style="background: linear-gradient(160deg, #0d5c2e 0%, #1a3a2a 40%, #f3ebda 100%);">
        <div class="dest-video-wrap">
          <iframe title="vimeo-player" src="https://player.vimeo.com/video/1115523494?h=08d4240a02" width="640" height="360" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"   allowfullscreen></iframe>
        </div>
        <div class="dest-social">
          <img src="assets/images/Logo-Bahia.png" alt="Logo Bahia" class="dest-logo" loading="lazy">
          <div class="dest-social__icons-row">
          <a href="https://www.linkedin.com/company/global-vision-access/" target="_blank" rel="noopener" aria-label="LinkedIn" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8.3 9.5H5.7V18h2.6V9.5zM7 8.4a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm11 9.6h-2.6v-4.1c0-1 0-2.3-1.4-2.3s-1.6 1.1-1.6 2.2V18H10v-8.5h2.5v1.2h.1c.4-.7 1.3-1.4 2.6-1.4 2.8 0 3.3 1.8 3.3 4.2V18z"/></svg>
          </a>
          <a href="https://www.facebook.com/brasildna" target="_blank" rel="noopener" aria-label="Facebook" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M22 12a10 10 0 10-11.6 9.9v-7H8v-2.9h2.4V9.8c0-2.4 1.4-3.7 3.6-3.7 1 0 2.1.2 2.1.2v2.5h-1.2c-1.2 0-1.5.7-1.5 1.5v1.8H16l-.4 2.9h-2.1v7A10 10 0 0022 12z"/></svg>
          </a>
          <a href="https://www.instagram.com/dnabrasil_official" target="_blank" rel="noopener" aria-label="Instagram" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2 0 2 .2 2.6.5.7.2 1.2.6 1.7 1.1.5.5.8 1 1.1 1.7.2.6.4 1.4.5 2.6 0 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c0 1.2-.2 2-.5 2.6-.2.7-.6 1.2-1.1 1.7-.5.5-1 .8-1.7 1.1-.6.2-1.4.4-2.6.5-1.2 0-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2 0-2-.2-2.6-.5-.7-.2-1.2-.6-1.7-1.1-.5-.5-.8-1-1.1-1.7-.2-.6-.4-1.4-.5-2.6 0-1.2-.1-1.6-.1-4.8s0-3.6.1-4.8c0-1.2.2-2 .5-2.6.2-.7.6-1.2 1.1-1.7.5-.5 1-.8 1.7-1.1.6-.2 1.4-.4 2.6-.5C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-1 0-1.6.2-1.9.3-.5.2-.8.4-1.2.7-.3.4-.5.7-.7 1.2-.1.3-.3.9-.3 1.9-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c0 1 .2 1.6.3 1.9.2.5.4.8.7 1.2.4.3.7.5 1.2.7.3.1.9.3 1.9.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1 0 1.6-.2 1.9-.3.5-.2.8-.4 1.2-.7.3-.4.5-.7.7-1.2.1-.3.3-.9.3-1.9.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c0-1-.2-1.6-.3-1.9-.2-.5-.4-.8-.7-1.2-.4-.3-.7-.5-1.2-.7-.3-.1-.9-.3-1.9-.3-1.2-.1-1.6-.1-4.7-.1zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 1.8a3.2 3.2 0 100 6.4 3.2 3.2 0 000-6.4zm5.4-3.4a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
          </a>
          <a href="https://www.youtube.com/@brasildna" target="_blank" rel="noopener" aria-label="YouTube" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M21.8 8s-.2-1.4-.8-2c-.8-.8-1.7-.8-2-.9C16.8 5 12 5 12 5s-4.8 0-7 .1c-.4 0-1.2.1-2 .9-.6.6-.8 2-.8 2S2 9.6 2 11.2v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.8 2c.8.8 1.8.8 2.3.9C6.8 19 12 19 12 19s4.8 0 7-.1c.4 0 1.2-.1 2-.9.6-.6.8-2 .8-2s.2-1.6.2-3.2v-1.5C22 9.6 21.8 8 21.8 8zM9.7 14.5V9l5.4 2.8-5.4 2.7z"/></svg>
          </a>
          </div>
        </div>
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
      <div class="dest-media dest-media--video" style="background: linear-gradient(160deg, #0a4a6e 0%, #0d2a3a 40%, #1a6e3a 100%);">
        <div class="dest-video-wrap">
          <iframe width="615" height="346" src="https://www.youtube.com/embed/8LDzOc7fUmA" title="Documentário: Mato Grosso do Sul: Expoente do Ecoturismo para o Mundo - Trailer Versão Estendida" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="dest-social">
          <img src="assets/images/Logo-MS.png" alt="Logo Mato Grosso do Sul" class="dest-logo dest-logo--ms" loading="lazy">
          <div class="dest-social__icons-row">
          <a href="https://www.linkedin.com/company/global-vision-access/" target="_blank" rel="noopener" aria-label="LinkedIn" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8.3 9.5H5.7V18h2.6V9.5zM7 8.4a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm11 9.6h-2.6v-4.1c0-1 0-2.3-1.4-2.3s-1.6 1.1-1.6 2.2V18H10v-8.5h2.5v1.2h.1c.4-.7 1.3-1.4 2.6-1.4 2.8 0 3.3 1.8 3.3 4.2V18z"/></svg>
          </a>
          <a href="https://www.facebook.com/brasildna" target="_blank" rel="noopener" aria-label="Facebook" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M22 12a10 10 0 10-11.6 9.9v-7H8v-2.9h2.4V9.8c0-2.4 1.4-3.7 3.6-3.7 1 0 2.1.2 2.1.2v2.5h-1.2c-1.2 0-1.5.7-1.5 1.5v1.8H16l-.4 2.9h-2.1v7A10 10 0 0022 12z"/></svg>
          </a>
          <a href="https://www.instagram.com/dnabrasil_official" target="_blank" rel="noopener" aria-label="Instagram" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2 0 2 .2 2.6.5.7.2 1.2.6 1.7 1.1.5.5.8 1 1.1 1.7.2.6.4 1.4.5 2.6 0 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c0 1.2-.2 2-.5 2.6-.2.7-.6 1.2-1.1 1.7-.5.5-1 .8-1.7 1.1-.6.2-1.4.4-2.6.5-1.2 0-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2 0-2-.2-2.6-.5-.7-.2-1.2-.6-1.7-1.1-.5-.5-.8-1-1.1-1.7-.2-.6-.4-1.4-.5-2.6 0-1.2-.1-1.6-.1-4.8s0-3.6.1-4.8c0-1.2.2-2 .5-2.6.2-.7.6-1.2 1.1-1.7.5-.5 1-.8 1.7-1.1.6-.2 1.4-.4 2.6-.5C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-1 0-1.6.2-1.9.3-.5.2-.8.4-1.2.7-.3.4-.5.7-.7 1.2-.1.3-.3.9-.3 1.9-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c0 1 .2 1.6.3 1.9.2.5.4.8.7 1.2.4.3.7.5 1.2.7.3.1.9.3 1.9.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1 0 1.6-.2 1.9-.3.5-.2.8-.4 1.2-.7.3-.4.5-.7.7-1.2.1-.3.3-.9.3-1.9.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c0-1-.2-1.6-.3-1.9-.2-.5-.4-.8-.7-1.2-.4-.3-.7-.5-1.2-.7-.3-.1-.9-.3-1.9-.3-1.2-.1-1.6-.1-4.7-.1zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 1.8a3.2 3.2 0 100 6.4 3.2 3.2 0 000-6.4zm5.4-3.4a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
          </a>
          <a href="https://www.youtube.com/@brasildna" target="_blank" rel="noopener" aria-label="YouTube" class="dest-social__btn">
            <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M21.8 8s-.2-1.4-.8-2c-.8-.8-1.7-.8-2-.9C16.8 5 12 5 12 5s-4.8 0-7 .1c-.4 0-1.2.1-2 .9-.6.6-.8 2-.8 2S2 9.6 2 11.2v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.8 2c.8.8 1.8.8 2.3.9C6.8 19 12 19 12 19s4.8 0 7-.1c.4 0 1.2-.1 2-.9.6-.6.8-2 .8-2s.2-1.6.2-3.2v-1.5C22 9.6 21.8 8 21.8 8zM9.7 14.5V9l5.4 2.8-5.4 2.7z"/></svg>
          </a>
          </div>
        </div>
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

<!-- ===== CLIENTS ===== -->
<?php
$_staticClients = [
  [
    'nome' => 'Embratur',
    'img'  => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=900&q=80',
    'yt'   => 'VF8ULR5dkgw',
    'logo' => 'https://brasildna.com/wp-content/uploads/2025/09/Logo-Embratur-2023-Cinza-1024x157-copiar.png',
    'link' => 'https://www.embratur.com.br',
    'desc' => "Brazil's official international tourism promotion agency, driving global awareness of Brazilian destinations.",
  ],
  [
    'nome' => 'Marca Brasil',
    'img'  => 'https://images.unsplash.com/photo-1583531352515-8884af319dc1?w=700&q=80',
    'yt'   => 'dUgCHXzQg6U',
    'logo' => 'https://brasildna.com/wp-content/uploads/2025/09/Brasil.png',
    'link' => '',
    'desc' => "Official brand of Brazilian tourism, promoting the country's cultural diversity and natural beauty worldwide.",
  ],
  [
    'nome' => 'Ministério do Turismo',
    'img'  => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=700&q=80',
    'yt'   => 'yIXW9VQLkkg',
    'logo' => 'https://brasildna.com/wp-content/uploads/2025/09/ministerio-do-turismo.png',
    'link' => '',
    'desc' => 'Brazilian government body responsible for the national tourism policy and development of the tourism sector.',
  ],
];
$_sizePool = ['tall','wide','normal','normal','normal','tall','normal','wide','normal'];
shuffle($_sizePool);
$_si = 0;
$_totalPartners = count($clientes_home) + count($_staticClients);
?>
<section class="section clients" id="clients">

  <!-- Painel esquerdo: vídeo vertical -->
  <div class="clients-video-panel">
    <video autoplay muted loop playsinline preload="none" aria-hidden="true">
      <source src="assets/video/video-horizzo.mp4" type="video/mp4">
    </video>
    <div class="clients-video-panel__overlay"></div>
  </div>

  <!-- Painel direito: conteúdo -->
  <div class="clients-left">
    <div class="clients-left-inner">

      <div class="clients-intro" data-reveal>
        <span class="label-tag label-tag--light">Our Clients</span>
        <h2>Companies that <em>trust Brasil DNA</em></h2>
        <p class="clients-intro__desc">Brasil DNA proudly collaborates with a curated selection of Brazilian tourism companies, offering authentic experiences, exceptional services, and unique opportunities to showcase the best of Brazil.</p>
        <div class="clients-counter-pill">
          <strong><?= $_totalPartners ?>+</strong>
          <span>strategic partners</span>
        </div>
      </div>

      <!-- Mosaico de parceiros -->
      <div class="clients-mosaic">

        <?php
        $sc0 = $_staticClients[0];
        $yt0 = $sc0['yt'] ?? '';
        ?>
        <div class="client-card client-card--mosaic client-card--featured-mosaic"
             role="button" tabindex="0"
             data-modal-trigger
             data-name="<?= htmlspecialchars($sc0['nome']) ?>"
             data-logo="<?= htmlspecialchars($sc0['logo'], ENT_QUOTES, 'UTF-8') ?>"
             data-desc="<?= htmlspecialchars($sc0['desc'], ENT_QUOTES, 'UTF-8') ?>"
             data-site="<?= htmlspecialchars($sc0['link'], ENT_QUOTES, 'UTF-8') ?>">
          <?php if ($yt0): ?>
            <div class="client-card__video-wrap" aria-hidden="true">
              <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($yt0, ENT_QUOTES, 'UTF-8') ?>?autoplay=1&mute=1&loop=1&modestbranding=1&playsinline=1&playlist=<?= htmlspecialchars($yt0, ENT_QUOTES, 'UTF-8') ?>&controls=0&showinfo=0&rel=0&disablekb=1&iv_load_policy=3"
                frameborder="0" allow="autoplay; encrypted-media" loading="lazy"></iframe>
            </div>
          <?php else: ?>
            <img class="client-card__bg" src="<?= htmlspecialchars($sc0['img'], ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy" aria-hidden="true">
          <?php endif; ?>
          <div class="client-card__overlay"></div>
          <span class="client-card__plus" aria-hidden="true">+</span>
          <div class="client-card__body">
            <img class="client-card__logo-img" src="<?= htmlspecialchars($sc0['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($sc0['nome']) ?>">
            <span class="client-card__name"><?= htmlspecialchars($sc0['nome']) ?></span>
          </div>
        </div>

        <?php foreach (array_slice($_staticClients, 1) as $sc):
          $sz  = $_sizePool[$_si % count($_sizePool)]; $_si++;
          $syt = $sc['yt'] ?? '';
        ?>
        <div class="client-card client-card--mosaic client-card--<?= $sz ?>"
             role="button" tabindex="0"
             data-modal-trigger
             data-name="<?= htmlspecialchars($sc['nome']) ?>"
             data-logo="<?= htmlspecialchars($sc['logo'], ENT_QUOTES, 'UTF-8') ?>"
             data-desc="<?= htmlspecialchars($sc['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
             data-site="<?= htmlspecialchars($sc['link'], ENT_QUOTES, 'UTF-8') ?>">
          <?php if ($syt): ?>
            <div class="client-card__video-wrap" aria-hidden="true">
              <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($syt, ENT_QUOTES, 'UTF-8') ?>?autoplay=1&mute=1&loop=1&modestbranding=1&playsinline=1&playlist=<?= htmlspecialchars($syt, ENT_QUOTES, 'UTF-8') ?>&controls=0&showinfo=0&rel=0&disablekb=1&iv_load_policy=3"
                frameborder="0" allow="autoplay; encrypted-media" loading="lazy"></iframe>
            </div>
          <?php else: ?>
            <img class="client-card__bg" src="<?= htmlspecialchars($sc['img'], ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy" aria-hidden="true">
          <?php endif; ?>
          <div class="client-card__overlay"></div>
          <span class="client-card__plus" aria-hidden="true">+</span>
          <div class="client-card__body">
            <img class="client-card__logo-img" src="<?= htmlspecialchars($sc['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($sc['nome']) ?>">
            <span class="client-card__name"><?= htmlspecialchars($sc['nome']) ?></span>
          </div>
        </div>
        <?php endforeach; ?>

        <?php
        function _ytId(string $html): ?string {
            if (preg_match('#(?:youtube\.com[^\'"]*(?:embed/|v=)|youtu\.be/)([a-zA-Z0-9_-]{11})#', $html, $m)) {
                return $m[1];
            }
            return null;
        }
        foreach ($clientes_home as $c):
          $sz     = $_sizePool[$_si % count($_sizePool)]; $_si++;
          $ytId   = !empty($c['iframe']) ? _ytId($c['iframe']) : null;
          $hasVid = !empty($c['video']);
          $solid  = $ytId === null && !$hasVid;
        ?>
        <div class="client-card client-card--mosaic<?= $solid ? ' client-card--solid' : '' ?> client-card--<?= $sz ?>"
             role="button" tabindex="0"
             data-modal-trigger
             data-name="<?= htmlspecialchars($c['titulo']) ?>"
             data-logo="<?= htmlspecialchars($c['logo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
             data-desc="<?= htmlspecialchars($c['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
             data-site="<?= htmlspecialchars($c['link_guia'] ?: $c['site'] ?: '', ENT_QUOTES, 'UTF-8') ?>">
          <?php if ($ytId): ?>
            <div class="client-card__video-wrap" aria-hidden="true">
              <iframe
                src="https://www.youtube.com/embed/<?= htmlspecialchars($ytId, ENT_QUOTES, 'UTF-8') ?>?autoplay=1&mute=1&loop=1&modestbranding=1&playsinline=1&playlist=<?= htmlspecialchars($ytId, ENT_QUOTES, 'UTF-8') ?>&controls=0&showinfo=0&rel=0&disablekb=1&iv_load_policy=3"
                frameborder="0"
                allow="autoplay; encrypted-media"
                loading="lazy">
              </iframe>
            </div>
          <?php elseif ($hasVid): ?>
            <div class="client-card__video-wrap" aria-hidden="true">
              <video autoplay muted loop playsinline>
                <source src="<?= htmlspecialchars($c['video'], ENT_QUOTES, 'UTF-8') ?>" type="video/<?= htmlspecialchars(pathinfo($c['video'], PATHINFO_EXTENSION), ENT_QUOTES, 'UTF-8') ?>">
              </video>
            </div>
          <?php endif; ?>
          <div class="client-card__overlay"></div>
          <span class="client-card__plus" aria-hidden="true">+</span>
          <div class="client-card__body">
            <?php if ($c['logo']): ?>
              <img class="client-card__logo-upload" src="<?= htmlspecialchars($c['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($c['titulo']) ?>" loading="lazy">
            <?php else: ?>
              <div class="client-logo-initials"><?= htmlspecialchars(mb_strtoupper(mb_substr($c['titulo'], 0, 2, 'UTF-8'), 'UTF-8')) ?></div>
            <?php endif; ?>
            <span class="client-card__name"><?= htmlspecialchars($c['titulo']) ?></span>
          </div>
        </div>
        <?php endforeach; ?>

      </div><!-- /.clients-mosaic -->
    </div><!-- /.clients-left-inner -->
  </div><!-- /.clients-left -->


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
      <img src="assets/images/logo_brasilDNA_branco.png"
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
      <!-- <a href="parceiro/login.php" class="footer-partner-link">Be Our Partner</a> -->
    </nav>

    <div class="footer-presented">
      <h4>Initiative presented by</h4>
      <img src="assets/images/globalvisioaccess.svg"
           alt="GVA — Global Vision Access" loading="lazy">
    </div>
  </div>

  <div class="footer-partners-bar">
    <div class="container footer-partners-row">
      <img src="assets/images/Logotipo_Brasil.png" alt="Marca Brasil" loading="lazy">
      <img src="assets/images/embratur.png" alt="Embratur" loading="lazy">
      <img src="assets/images/ministerio-do-turismo.png" alt="Ministério do Turismo" loading="lazy">
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container painel">
      <p>&copy; <?= date('Y') ?> Brasil DNA. All rights reserved.</p>
      <a href="./admin/login.php">administrative panel</a>
    </div>
  </div>
</footer>

<!-- ===== CLIENT MODAL ===== -->
<div id="clientModal" class="client-modal" role="dialog" aria-modal="true"
     aria-labelledby="clientModalName" hidden>
  <div class="client-modal__backdrop"></div>
  <div class="client-modal__panel">
    <button class="client-modal__close" aria-label="Fechar">&#x2715;</button>
    <div class="client-modal__logo-wrap">
      <img id="clientModalLogo" src="" alt="" class="client-modal__logo" hidden>
      <div id="clientModalInitials" class="client-modal__initials" hidden></div>
    </div>
    <span id="clientModalName" class="client-modal__name"></span>
    <p id="clientModalDesc" class="client-modal__desc"></p>
    <a id="clientModalLink" href="#" target="_blank" rel="noopener"
       class="btn btn-primary client-modal__btn">Visitar site</a>
  </div>
</div>

<script src="assets/main.js?v=4" defer></script>
</body>
</html>
