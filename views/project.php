<?php if (!$project): ?>
<main class="hq-section"><div class="section-label"><span>404</span><span>Project Dossier</span></div><h1 class="dossier-title">Project not found.</h1><p class="dossier-copy">That dossier is not published or the link has moved.</p><a class="hq-button hq-button--primary" href="/case-studies">Back to case studies ↗</a></main>
<?php else: ?>
<main class="hq-section dossier-page">
  <div class="section-label"><span>PROJECT DOSSIER</span><span><?=e(strtoupper($project['category'] ?? 'BUILD'))?></span></div>
  <?php if(!empty($project['status'])): ?><p class="eyebrow"><span class="signal-dot"></span> <?=e($project['status'])?></p><?php endif; ?>
  <h1 class="dossier-title"><?=e($project['name'])?></h1>
  <p class="dossier-lede"><?=e($project['summary'] ?? '')?></p>
  <?php if(!empty($project['technologies'])): ?><div class="dossier-tech"><?php foreach($project['technologies'] as $technology): ?><span><?=e($technology)?></span><?php endforeach; ?></div><?php endif; ?>
  <?php $sections=[['problem','THE PROBLEM','Why this exists.'],['approach','APPROACH','How it is being solved.'],['architecture','ARCHITECTURE','How the published system description fits together.'],['outcomes','OUTCOME RECORD','What the project record says has been made real.']]; $available=array_filter($sections,fn($section)=>!empty($project[$section[0]])); ?>
  <?php if($available): ?><div class="dossier-detail-grid"><?php foreach($available as $section): ?><article class="dossier-detail-card"><span class="mono-label"><?=e($section[1])?></span><h2><?=e($section[2])?></h2><p><?=e($project[$section[0]])?></p></article><?php endforeach; ?></div><?php endif; ?>
  <?php if(!empty($project['repository_url']) || !empty($project['live_url'])): ?><div class="dossier-rule"></div><div class="dossier-actions"><a class="hq-text-link" href="/case-studies">← All case studies</a><div class="platform-actions"><?php if(!empty($project['repository_url'])):?><a class="hq-text-link" href="<?=e($project['repository_url'])?>" target="_blank" rel="noopener noreferrer">Source / GitHub ↗</a><?php endif;?><?php if(!empty($project['live_url'])):?><a class="hq-button hq-button--primary" href="<?=e($project['live_url'])?>" target="_blank" rel="noopener noreferrer">Open live project ↗</a><?php endif;?></div></div><?php else: ?><div class="dossier-rule"></div><div class="dossier-actions"><a class="hq-text-link" href="/case-studies">← All case studies</a><span class="dossier-copy">No public repository or live URL is published for this project.</span></div><?php endif; ?>
</main>
<?php endif; ?>