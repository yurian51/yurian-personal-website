<?php
$profile=$profile??profile();$projects=$projects??projects(6);$skills=$skills??skills();
?>
<main>
<section class="hero container">
 <div>
  <div class="eyebrow">Software Engineer · AI Builder · Product Creator</div>
  <h1>Building digital products that <span>actually matter.</span></h1>
  <p class="hero__lead"><?=e($profile['intro']??'I design and build software, AI systems and digital products from idea to production.')?></p>
  <div class="actions"><a class="button button--primary" href="/projects">Explore my work</a><a class="button button--ghost" href="/contact">Start a conversation</a></div>
 </div>
 <aside class="hero-card"><div class="hero-card__mark">Y</div><p class="eyebrow">Currently building</p><h2 style="font-family:'Space Grotesk'">Software · AI · Systems</h2><p style="color:var(--muted)">Focused on useful technology, strong engineering and products built for the real world.</p></aside>
</section>
<section class="section container"><div class="section__heading"><span>01</span><h2>Selected work</h2></div><div class="grid"><?php foreach($projects as $project): ?><article class="card"><span class="tag"><?=e($project['category']??'Project')?></span><h3><?=e($project['name']??'Untitled')?></h3><p><?=e($project['summary']??'')?></p></article><?php endforeach; ?></div></section>
<section class="section container"><div class="section__heading"><span>02</span><h2>Capabilities</h2></div><div class="grid"><?php foreach($skills as $skill): ?><article class="card"><h3><?=e($skill['name']??'Skill')?></h3></article><?php endforeach; ?></div></section>
<section class="section container"><div class="glass-panel"><div class="eyebrow">Have something worth building?</div><h2 style="font:700 clamp(34px,5vw,62px)/1 'Space Grotesk';letter-spacing:-.05em">Let's turn the idea into a working product.</h2><div class="actions"><a class="button button--primary" href="/contact">Get in touch</a></div></div></section>
</main>