<?php if (!$project): ?>
<main class="hq-section"><div class="section-label"><span>404</span><span>Project Dossier</span></div><h1 class="dossier-title">Project not found.</h1><p class="dossier-copy">That dossier is not published or the link has moved.</p><a class="hq-button hq-button--primary" href="/case-studies">Back to case studies ↗</a></main>
<?php else: ?>
<main class="hq-section dossier-page">
  <div class="section-label"><span>PROJECT DOSSIER</span><span><?=e(strtoupper($project['category'] ?? 'BUILD'))?></span></div>
  <p class="eyebrow"><span class="signal-dot"></span> <?=e($project['status'] ?? $project['category'] ?? 'Digital build')?></p>
  <h1 class="dossier-title"><?=e($project['name'])?></h1>
  <p class="dossier-lede"><?=e($project['summary'])?></p>
  <div class="dossier-tech"><?php foreach(($project['technologies'] ?? []) as $technology): ?><span><?=e($technology)?></span><?php endforeach; ?></div>
  <div class="dossier-detail-grid">
    <article class="dossier-detail-card"><span class="mono-label">THE PROBLEM</span><h2>Why this exists.</h2><p><?=e($project['problem'] ?? 'The project is shaped around a concrete operational or product problem.')?></p></article>
    <article class="dossier-detail-card"><span class="mono-label">APPROACH</span><h2>How it is being solved.</h2><p><?=e($project['approach'] ?? 'The implementation follows explicit system boundaries and production constraints.')?></p></article>
    <article class="dossier-detail-card"><span class="mono-label">ARCHITECTURE</span><h2>How the pieces connect.</h2><p><?=e($project['architecture'] ?? 'Architecture details are maintained with the project as it evolves.')?></p></article>
    <article class="dossier-detail-card"><span class="mono-label">OUTCOMES</span><h2>What has been made real.</h2><p><?=e($project['outcomes'] ?? 'Results are documented as the implementation is verified.')?></p></article>
  </div>
  <div class="dossier-rule"></div>
  <div class="dossier-actions">
    <a class="hq-text-link" href="/case-studies">← All case studies</a>
    <div class="platform-actions">
      <?php if(!empty($project['repository_url'])):?><a class="hq-text-link" href="<?=e($project['repository_url'])?>" target="_blank" rel="noopener noreferrer">Source / GitHub ↗</a><?php endif;?>
      <?php $liveUrl=$project['live_url']??$project['url']??null; if($liveUrl):?><a class="hq-button hq-button--primary" href="<?=e($liveUrl)?>" target="_blank" rel="noopener noreferrer">Open live project ↗</a><?php endif;?>
    </div>
  </div>
</main>
<?php endif; ?>