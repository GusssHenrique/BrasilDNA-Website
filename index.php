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
    $stmt = $pdo->query("SELECT * FROM banners WHERE ativo = 1 ORDER BY criado_em DESC");
    $banners_parceiros = $stmt->fetchAll();
    if (!empty($banners_parceiros)) {
        require_once __DIR__ . '/includes/stats.php';
        $upd = $pdo->prepare('UPDATE banners SET visualizacoes = visualizacoes + 1 WHERE id = :id');
        foreach ($banners_parceiros as $b) {
            $upd->execute([':id' => (int) $b['id']]);
            registrarStat($pdo, 'banner', (int) $b['id'], 'visualizacoes');
        }
    }
    $_raw = $pdo->query("SELECT id, titulo, tipo, regiao, logo, descricao, iframe, imagem_fundo, facebook, instagram, linkedin, site, youtube, link_guia FROM clientes ORDER BY criado_em ASC")->fetchAll();
    $destinos_home  = array_values(array_filter($_raw, fn($r) => ($r['tipo'] ?? 'destino') === 'destino'));
    $parceiros_home = array_values(array_filter($_raw, fn($r) => ($r['tipo'] ?? 'destino') === 'parceiro'));
    $clientes_home  = $_raw;
    if (!empty($_raw)) {
        require_once __DIR__ . '/includes/stats.php';
        foreach ($_raw as $c) {
            registrarStat($pdo, 'cliente', (int) $c['id'], 'visualizacoes');
        }
    }
    $posts_home = $pdo->query(
        "SELECT id, titulo, resumo, imagem, data_publicacao FROM posts WHERE status = 'publicado' ORDER BY data_publicacao DESC LIMIT 4"
    )->fetchAll();
} catch (\Throwable $e) {
    $banners_parceiros = [];
    $clientes_home = [];
    $destinos_home = [];
    $parceiros_home = [];
    $posts_home = [];
}

$currentPage = 'home';
require_once __DIR__ . '/includes/site-header.php';
?>

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

  <!-- Top frieze — a nod to Copacabana's iconic wave-mosaic promenade,
       rendered in the brand palette and gently scrolling -->
  <div class="brasil-wave brasil-wave--why" aria-hidden="true"></div>

  <div class="why-bg" aria-hidden="true">
    <div class="why-bg__blob why-bg__blob--1"></div>
    <div class="why-bg__blob why-bg__blob--2"></div>
    <div class="why-bg__blob why-bg__blob--3"></div>
  </div>

  <div class="container">

    <!-- Top: label + headline centered -->
    <div class="why-header" data-reveal>
      <span class="label-tag">Why Travel to Brazil?</span>
      <h2 class="why-headline">A force that touches the heart<br>and <em>awakens the senses</em></h2>
      <!-- Decorative divider -->
      <div class="why-divider" aria-hidden="true">
        <span class="why-divider__line"></span>
        <span class="why-divider__dot why-divider__dot--green"></span>
        <span class="why-divider__dot why-divider__dot--gold"></span>
        <span class="why-divider__dot why-divider__dot--red"></span>
        <span class="why-divider__line"></span>
      </div>
    </div>

    <!-- Mid: video + text side by side -->
    <div class="why-body">
      <div class="why-video" data-reveal>
        <!-- Floating badge -->
        <div class="why-video__badge" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <span>Travellers' Choice</span>
          <span class="eq-bars"><span></span><span></span><span></span></span>
        </div>
        <div class="why-video__frame">
          <div class="why-video__accent" aria-hidden="true"></div>
          <div class="video-wrap">
            <iframe
              src="https://www.youtube.com/embed/9tVQt1GnIHs"
              title="Brasil DNA — What do people who visit Brazil have to say?"
              loading="lazy"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
        <p class="video-caption">What do people who visit Brazil have to say?</p>
      </div>

      <div class="why-text" data-reveal data-reveal-delay="120">
        <p class="why-lead">Brazil is more than a destination — it's the rhythm of samba at twilight, the stillness of a jaguar in the wild, the warmth of a shared moqueca, and the roar of waterfalls that remind us how small we are — yet how connected we can be.</p>
        <p>Through <strong>Brasil DNA</strong>, you're invited to step into a curated journey across four breathtaking regions, each revealing a facet of Brazil's identity rooted in <strong>nature, culture, and purposeful travel</strong>.</p>

        <!-- Proof points — each with distinct colour accent -->
        <div class="why-proofs">
          <div class="why-proof why-proof--green">
            <div class="why-proof__icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            </div>
            <div>
              <strong>4 Curated Regions</strong>
              <span>Each with its own identity and story</span>
            </div>
          </div>
          <div class="why-proof why-proof--gold">
            <div class="why-proof__icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
              <strong>Authentic Experiences</strong>
              <span>People, culture, and nature in harmony</span>
            </div>
          </div>
          <div class="why-proof why-proof--red">
            <div class="why-proof__icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
              <strong>Purposeful Travel</strong>
              <span>Journeys that leave a lasting impression</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom: stat strip — dark green, rich -->
    <div class="why-stats" data-reveal data-reveal-delay="200">
      <div class="why-stats__bg" aria-hidden="true"></div>
      <div class="why-stat">
        <span class="why-stat__number"><span class="count-up" data-target="215">0</span><em>M</em></span>
        <span class="why-stat__label">People — a mosaic of cultures</span>
      </div>
      <div class="why-stat__divider" aria-hidden="true"></div>
      <div class="why-stat">
        <span class="why-stat__number"><span class="count-up" data-target="8.5" data-decimals="1">0</span><em>M km²</em></span>
        <span class="why-stat__label">Of breathtaking territory</span>
      </div>
      <div class="why-stat__divider" aria-hidden="true"></div>
      <div class="why-stat">
        <span class="why-stat__number"><span class="count-up" data-target="1">0</span><em>st</em></span>
        <span class="why-stat__label">In biodiversity worldwide</span>
      </div>
      <div class="why-stat__divider" aria-hidden="true"></div>
      <div class="why-stat">
        <span class="why-stat__number"><span class="count-up" data-target="22">0</span><em>+</em></span>
        <span class="why-stat__label">UNESCO World Heritage Sites</span>
      </div>
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

  <!-- Subtle background blobs (echo of Why Travel) -->
  <div class="feel-bg" aria-hidden="true">
    <div class="feel-bg__blob feel-bg__blob--1"></div>
    <div class="feel-bg__blob feel-bg__blob--2"></div>
  </div>

  <div class="container">

    <!-- Centered header — mirrors Why Travel's structure -->
    <div class="feel-header" data-reveal>
      <span class="label-tag">Feel Brasil</span>
      <h2 class="feel-headline">Discover Brazil through<br><em>authentic experiences</em></h2>
      <!-- Divider: same dots, reversed colour order for individuality -->
      <div class="feel-divider" aria-hidden="true">
        <span class="feel-divider__line"></span>
        <span class="feel-divider__dot feel-divider__dot--red"></span>
        <span class="feel-divider__dot feel-divider__dot--gold"></span>
        <span class="feel-divider__dot feel-divider__dot--green"></span>
        <span class="feel-divider__line"></span>
      </div>
    </div>

    <!-- Body: text left + framed video right (side-by-side like Why Travel) -->
    <div class="feel-body">

      <!-- Text column -->
      <div class="feel-text" data-reveal>
        <p class="feel-lead">Created by <strong>Embratur</strong>, the <strong>Feel Brasil</strong> initiative highlights authentic travel experiences across the country — curated journeys that connect visitors with Brazil's nature, culture, communities, and traditions.</p>
        <p>Travelers can discover immersive activities such as exploring protected natural areas, experiencing local gastronomy, and engaging with community-based tourism.</p>

        <!-- Feature tags — unique to Feel (pill chips, not proof cards) -->
        <div class="feel-tags">
          <span class="feel-tag feel-tag--green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Nature & Ecosystems
          </span>
          <span class="feel-tag feel-tag--gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            Local Gastronomy
          </span>
          <span class="feel-tag feel-tag--red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Community Tourism
          </span>
        </div>

        <a href="https://www.embratur.com.br" target="_blank" rel="noopener" class="btn btn-primary">Learn More</a>
      </div>

      <!-- Video column — echoes Why's accent frame, badge swapped for Embratur label -->
      <div class="feel-video" data-reveal data-reveal-delay="120">
        <div class="feel-video__label" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
          <span>by Embratur</span>
          <span class="eq-bars eq-bars--light"><span></span><span></span><span></span></span>
        </div>
        <div class="feel-video__frame">
          <div class="feel-video__accent" aria-hidden="true"></div>
          <div class="video-wrap">
            <iframe
              src="https://www.youtube.com/embed/ywZe6LAa0oY"
              title="Feel Brasil — Vitrine Brasil"
              loading="lazy"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
        <p class="feel-video__caption">Meet the Brasil DNA 2026 Partners</p>
      </div>

    </div><!-- /.feel-body -->

  </div>

  <!-- Bottom frieze — mirrors Why's wave, scrolling the opposite way -->
  <div class="brasil-wave brasil-wave--feel" aria-hidden="true"></div>

</section>

<!-- ===== PARTNERS ===== -->
<section class="section partners" id="partners">
  <div class="container">

    <div class="partners-header" data-reveal>
      <div>
        <span class="label-tag">Our Partners</span>
        <h2>Trusted voices on the <em>ground</em></h2>
      </div>
      <p class="partners-lead">Curated destinations and experiences handpicked to reveal the true essence of Brazil — by those who know it best.</p>
    </div>

    <div class="partners-row">

      <!-- NEx – Natural Experience -->
      <article class="partner-card" data-reveal>
        <div class="partner-card__cover">
          <img
            src="https://bureaumundo.com/wp-content/uploads/2024/11/Abismo-Anhumas-Creditos-Site-Abismo-Anhumas-1.jpg"
            alt="Caverna submersa no Abismo de Anhumas, MS"
            loading="lazy"
          >
          <div class="partner-card__cover-overlay"></div>
        </div>
        <div class="partner-card__top">
          <div class="partner-icon">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
              <path d="M17 8C8 10 5.9 16.17 3.82 19.03L5.71 21L7 19C7.66 19.39 8.38 19.68 9.12 19.84C8.42 18.32 8.5 16.5 9.5 15C10.5 13.5 12 12.7 13.6 12.56C12.62 13.88 12.5 15.7 13.5 17C14.5 18.3 16.1 18.83 17.6 18.42C18.27 17.05 18.5 15.44 17.97 13.93C17.44 12.42 16.28 11.28 14.85 10.72C15.86 9.75 17.23 9.21 18.65 9.27L17 8Z" fill="currentColor"/>
            </svg>
          </div>
          <div class="partner-tag-region">Centro-Oeste · Pantanal</div>
        </div>

        <h3>NEx – Natural Experience</h3>
        <p class="partner-tagline">Connecting travelers with the heart of Brazil</p>

        <div class="partner-divider"></div>

        <p class="partner-desc-text">Based in Mato Grosso do Sul, NEx specializes in curated nature-based experiences across Bonito and the Pantanal — from crystal-clear rivers and underwater caves to wildlife safaris and conservation-focused journeys through South America's richest ecosystems.</p>

        <div class="partner-footer">
          <div class="partner-socials">
            <a href="#" class="partner-social-btn" aria-label="Facebook" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="#" class="partner-social-btn" aria-label="Instagram" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
            <a href="#" class="partner-social-btn" aria-label="LinkedIn" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
            </a>
            <a href="#" class="partner-social-btn" aria-label="YouTube" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
            </a>
          </div>
          <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-nex-2026/" target="_blank" rel="noopener" class="partner-link">
            Explore <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </article>

      <!-- Mato Grosso do Sul -->
      <article class="partner-card" data-reveal data-reveal-delay="120">
        <div class="partner-card__cover">
          <img
            src="https://observatorio3setor.org.br/wp-content/uploads/2024/10/AdobeStock_634722462-scaled.jpeg"
            alt="Fauna do Pantanal, Mato Grosso do Sul"
            loading="lazy"
          >
          <div class="partner-card__cover-overlay"></div>
        </div>
        <div class="partner-card__top">
          <div class="partner-icon partner-icon--gold">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
            </svg>
          </div>
          <div class="partner-tag-region">Centro-Oeste · Pantanal &amp; Bonito</div>
        </div>

        <h3>Mato Grosso do Sul</h3>
        <p class="partner-tagline">Where Nature Whispers Power</p>

        <div class="partner-divider"></div>

        <p class="partner-desc-text">One of South America's best-kept secrets — home to the Pantanal, the world's largest tropical wetland, bursting with jaguars, capybaras, and caimans. Bonito offers an underwater world of crystal rivers and caves. A living sanctuary of eco-tourism and natural wonder.</p>

        <div class="partner-footer">
          <div class="partner-socials">
            <a href="#" class="partner-social-btn" aria-label="Facebook" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="#" class="partner-social-btn" aria-label="Instagram" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
            <a href="#" class="partner-social-btn" aria-label="YouTube" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
            </a>
          </div>
          <a href="https://bureaumundo.com/parceiro-brasil-dna/guia-mato-grosso-do-sul-2026/" target="_blank" rel="noopener" class="partner-link">
            Explore <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ===== CLIENTS ===== -->
<?php
$_sizePool = ['tall','wide','normal','normal','normal','tall','normal','wide','normal'];
shuffle($_sizePool);
$_si = 0;
$_totalPartners = count($destinos_home);
?>
<section class="section clients" id="clients">

  <!-- Painel esquerdo: vídeo vertical -->
  <div class="clients-video-panel">
    <video autoplay muted loop playsinline preload="none" aria-hidden="true">
      <source src="assets/video/video-horizzo.mp4" type="video/mp4">
    </video>
    <div class="clients-video-panel__overlay"></div>
    <div class="clients-video-panel__text" data-reveal>
      <span class="label-tag label-tag--light">Brazilian Destinations</span>
      <h2>Companies that <em>trust Brasil DNA</em></h2>
      <p class="clients-intro__desc">Brasil DNA proudly collaborates with a curated selection of Brazilian tourism companies, offering authentic experiences, exceptional services, and unique opportunities to showcase the best of Brazil.</p>
      <div class="clients-counter-pill">
        <strong><?= $_totalPartners ?>+</strong>
        <span>strategic partners</span>
      </div>
    </div>
  </div>

  <!-- Painel direito: conteúdo -->
  <div class="clients-left">
    <div class="clients-left-inner">

      <!-- Mosaico de parceiros -->
      <div class="clients-mosaic">

        <?php
        foreach ($destinos_home as $c):
          $sz       = $_sizePool[$_si % count($_sizePool)]; $_si++;
          $hasFundo = !empty($c['imagem_fundo']);
          $solid    = !$hasFundo;
        ?>
        <div class="client-card client-card--mosaic<?= $solid ? ' client-card--solid' : '' ?> client-card--<?= $sz ?>"
             role="button" tabindex="0"
             data-modal-trigger
             data-name="<?= htmlspecialchars($c['titulo']) ?>"
             data-logo="<?= htmlspecialchars($c['logo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
             data-desc="<?= htmlspecialchars($c['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
             data-site="<?= htmlspecialchars($c['link_guia'] ?: $c['site'] ?: '', ENT_QUOTES, 'UTF-8') ?>"
             <?php if (!empty($c['iframe'])): ?>data-iframe="<?= htmlspecialchars($c['iframe'], ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>
             <?php if (!empty($c['facebook'])): ?>data-facebook="<?= htmlspecialchars($c['facebook'], ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>
             <?php if (!empty($c['instagram'])): ?>data-instagram="<?= htmlspecialchars($c['instagram'], ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>
             <?php if (!empty($c['linkedin'])): ?>data-linkedin="<?= htmlspecialchars($c['linkedin'], ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>
             <?php if (!empty($c['youtube'])): ?>data-youtube="<?= htmlspecialchars($c['youtube'], ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>>
          <?php if ($hasFundo): ?>
            <img class="client-card__bg" src="<?= htmlspecialchars($c['imagem_fundo'], ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy" aria-hidden="true">
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
      <?php foreach ($posts_home as $_pi => $_p):
        $postLink = BASE_URL . 'pages/post.php?id=' . (int) $_p['id'];
        $postDate = !empty($_p['data_publicacao']) ? date('d/m/Y', strtotime($_p['data_publicacao'])) : '';
        $delay    = $_pi * 80;
      ?>
      <article class="news-card" data-reveal<?= $delay ? ' data-reveal-delay="' . $delay . '"' : '' ?>>
        <a href="<?= esc_url_safe($postLink) ?>" class="news-img-link">
          <?php if (!empty($_p['imagem'])): ?>
          <img src="<?= esc_url_safe($_p['imagem']) ?>" alt="<?= htmlspecialchars($_p['titulo']) ?>" loading="lazy">
          <?php else: ?>
          <div style="width:100%;height:180px;background:var(--green-100);"></div>
          <?php endif; ?>
        </a>
        <div class="news-body">
          <?php if ($postDate): ?><span class="news-date"><?= $postDate ?></span><?php endif; ?>
          <h3><a href="<?= esc_url_safe($postLink) ?>"><?= htmlspecialchars($_p['titulo']) ?></a></h3>
          <a class="news-more" href="<?= esc_url_safe($postLink) ?>">Read more →</a>
        </div>
      </article>
      <?php endforeach; ?>

      <?php if (empty($posts_home)): ?>
      <p style="grid-column:1/-1;text-align:center;color:var(--text-sec);padding:40px 0;">Nenhuma publicação ainda.</p>
      <?php endif; ?>
    </div>

    <div class="section-cta" data-reveal>
      <a href="<?= BASE_URL ?>pages/news.php" class="btn btn-outline">See All Publications</a>
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
          $logoUrl  = htmlspecialchars($b['logo_url']             ?? '', ENT_QUOTES, 'UTF-8');
          $bgUrl    = htmlspecialchars($b['imagem_url']           ?? '', ENT_QUOTES, 'UTF-8');
          $bgVert   = htmlspecialchars($b['imagem_vertical_url']  ?? '', ENT_QUOTES, 'UTF-8');
          $titulo   = htmlspecialchars($b['titulo']       ?? '');
          $subtexto = htmlspecialchars($b['subtexto']     ?? '');
          $btnTxt   = htmlspecialchars($b['botao_texto']  ?? 'Learn More');
          $partner  = htmlspecialchars($b['nome_parceiro']);
          $activeClass = $idx === 0 ? ' is-active' : '';
        ?>
        <a href="<?= BASE_URL ?>pages/banner-click.php?id=<?= (int)$b['id'] ?>" class="partner-banner<?= $activeClass ?>" target="_blank" rel="noopener noreferrer" tabindex="<?= $idx === 0 ? '0' : '-1' ?>">
          <?php if ($bgUrl || $bgVert): ?>
            <picture>
              <?php if ($bgVert): ?>
                <source media="(max-width: 768px)" srcset="<?= $bgVert ?>">
              <?php endif; ?>
              <?php if ($bgUrl): ?>
                <img class="partner-banner__bg" src="<?= $bgUrl ?>" alt="" aria-hidden="true" loading="lazy">
              <?php elseif ($bgVert): ?>
                <img class="partner-banner__bg" src="<?= $bgVert ?>" alt="" aria-hidden="true" loading="lazy">
              <?php endif; ?>
            </picture>
          <?php endif; ?>
          <div class="partner-banner__overlay"></div>

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
    <div class="carousel-page-dots-mobile" id="bannerPageDots" aria-label="Páginas de banners"></div>
  </div>
</section>
<?php endif; ?>

<!-- ===== NEWSLETTER ===== -->
<!-- <section class="newsletter" id="newsletter">
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
</section> -->

<!-- ===== CLIENT MODAL ===== -->
<div id="clientModal" class="client-modal" role="dialog" aria-modal="true"
     aria-labelledby="clientModalName" hidden>
  <div class="client-modal__backdrop"></div>
  <div class="client-modal__panel">
    <button class="client-modal__close" aria-label="Fechar">&#x2715;</button>

    <!-- Coluna esquerda: vídeo + logo + redes -->
    <div class="client-modal__left">
      <div id="clientModalVideo" class="client-modal__video-wrap" hidden></div>
      <div class="client-modal__logo-wrap">
        <img id="clientModalLogo" src="" alt="" class="client-modal__logo" hidden>
        <div id="clientModalInitials" class="client-modal__initials" hidden></div>
      </div>
      <div id="clientModalSocial" class="client-modal__social" hidden>
        <a id="clientModalFacebook" href="#" target="_blank" rel="noopener" aria-label="Facebook" class="client-modal__social-btn" hidden>
          <i class="bi bi-facebook"></i>
        </a>
        <a id="clientModalInstagram" href="#" target="_blank" rel="noopener" aria-label="Instagram" class="client-modal__social-btn" hidden>
          <i class="bi bi-instagram"></i>
        </a>
        <a id="clientModalLinkedin" href="#" target="_blank" rel="noopener" aria-label="LinkedIn" class="client-modal__social-btn" hidden>
          <i class="bi bi-linkedin"></i>
        </a>
        <a id="clientModalYoutube" href="#" target="_blank" rel="noopener" aria-label="YouTube" class="client-modal__social-btn" hidden>
          <i class="bi bi-youtube"></i>
        </a>
      </div>
    </div>

    <!-- Coluna direita: título + descrição + link -->
    <div class="client-modal__right">
      <h2 id="clientModalName" class="client-modal__name"></h2>
      <p id="clientModalDesc" class="client-modal__desc"></p>
      <a id="clientModalLink" href="#" target="_blank" rel="noopener"
         class="client-modal__btn">
        <span id="clientModalLinkText">Explore</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/site-footer.php'; ?>
