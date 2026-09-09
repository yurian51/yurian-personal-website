<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

$pageTitle = 'Yurian | Software Engineer, AI Builder & Technology Creator';
$profile = profile();
$projects = projects(6);
$services = services(6);
$skills = skills();

require __DIR__ . '/../includes/header.php';
?>
<main>
  <section class="hero">
    <div class="hero__content">
      <p class="eyebrow">SOFTWARE ENGINEER · AI BUILDER · ENTREPRENEUR</p>
      <h1>Building digital products that turn ambitious ideas into reality.</h1>
      <p class="hero__lead"><?= e($profile['intro'] ?? 'I design and build reliable software, intelligent systems and digital products.') ?></p>
      <div class="actions">
        <a class="button button--primary" href="/projects">Explore projects</a>
        <a class="button button--ghost" href="/contact">Start a conversation</a>
      </div>
    </div>
    <div class="hero__orb" aria-hidden="true"><span>Y</span></div>
  </section>

  <section class="section" id="about">
    <div class="section__heading"><span>01</span><h2>About</h2></div>
    <div class="glass-panel about-grid">
      <div><p><?= e($profile['bio'] ?? 'Technology-focused builder creating useful products across software, AI and digital business.') ?></p></div>
      <div class="stats">
        <div><strong><?= count($projects) ?>+</strong><span>Featured projects</span></div>
        <div><strong><?= count($skills) ?>+</strong><span>Core technologies</span></div>
        <div><strong>∞</strong><span>Ideas worth building</span></div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="section__heading"><span>02</span><h2>Selected work</h2></div>
    <div class="card-grid">
      <?php foreach ($projects as $project): ?>
        <article class="card">
          <span class="card__meta"><?= e($project['category']) ?></span>
          <h3><?= e($project['name']) ?></h3>
          <p><?= e($project['summary']) ?></p>
          <a href="/projects#<?= e($project['slug']) ?>">View project →</a>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section">
    <div class="section__heading"><span>03</span><h2>Capabilities</h2></div>
    <div class="tag-list"><?php foreach ($skills as $skill): ?><span><?= e($skill['name']) ?></span><?php endforeach; ?></div>
  </section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
