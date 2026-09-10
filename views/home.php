<?php
$displayProjects = $projects ?? projects(6);
$displayServices = services(4);
$displayProfile = $profile ?? profile();
$heroName = $displayProfile['name'] ?? 'Arshad Yurian Mwangi';
?>
<main id="main-content" data-scroll-state="ORIGIN">
  <section class="hq-hero" id="top" data-state="ORIGIN">
    <div class="hq-hero__copy">
      <p class="eyebrow"><span class="signal-dot"></span> Nairobi / EAT · 2026</p>
      <h1>BUILDING<br><em>SYSTEMS</em><br>FOR WHAT<br><span>COMES NEXT.</span></h1>
      <p class="hero-intro"><?= e($displayProfile['intro'] ?? 'Software engineer, AI builder, technology entrepreneur, and creator making useful things for an uncertain future.') ?></p>
      <div class="hero-actions">
        <a class="hq-button hq-button--primary" href="#build">Explore the work <span aria-hidden="true">↘</span></a>
        <a class="hq-text-link" href="/contact">Start a conversation <span aria-hidden="true">↗</span></a>
      </div>
    </div>
    <div class="universe-frame" aria-label="The Yurian Universe signal environment">
      <div class="universe-meta"><span>THE YURIAN UNIVERSE</span><span>01 — 05</span></div>
      <div class="signal-ring signal-ring--one"></div><div class="signal-ring signal-ring--two"></div>
      <div class="signal-core"><span>Y</span></div>
      <div class="signal-label">◉ SIGNAL / 001</div>
      <div class="coordinates">-1.2921° S<br>36.8219° E</div>
    </div>
    <div class="hero-foot"><span>© <?= date('Y') ?> YURIAN // DIGITAL HQ</span><span>AVAILABLE FOR SELECT BUILDS <i></i></span></div>
  </section>

  <section class="hq-section hq-identity" id="identity" data-state="IDENTITY FIELD">
    <div class="section-label"><span>01</span><span>Identity</span></div>
    <div class="identity-grid">
      <p class="display-kicker">Not a portfolio.<br><em>A point of view.</em></p>
      <div class="identity-copy"><p class="lede">I build at the intersection of <strong>engineering, intelligence, and culture.</strong> My work is an attempt to make technology feel less like a force acting on us — and more like a material we can shape together.</p><div class="identity-details"><div><span>ROLE</span><p>Engineer / Builder<br>Independent operator</p></div><div><span>BASED IN</span><p><?= e($displayProfile['location'] ?? 'Nairobi, Kenya') ?><br>Working globally</p></div><div><span>CURRENT MODE</span><p><i class="status-pulse"></i> Curious, in motion</p></div></div></div>
    </div><div class="identity-rule"></div><div class="identity-bottom"><span>Software should expand human agency.</span><span>— a working principle</span></div>
  </section>

  <section class="hq-section hq-build" id="build" data-state="SYSTEM MAP">
    <div class="section-label"><span>02</span><span>What I Build</span></div><div class="section-heading"><h2>From first<br><em>principles.</em></h2><p>Projects start with a question, not a feature list. Then they get made carefully, in public where possible.</p></div>
    <div class="build-list">
      <?php foreach ($displayServices as $i => $service): ?><article class="build-row"><span class="row-number"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><h3><?= e($service['name'] ?? 'Digital systems') ?></h3><p><?= e($service['summary'] ?? 'Useful software and reliable infrastructure for ambitious work.') ?></p><span class="build-arrow" aria-hidden="true">↗</span></article><?php endforeach; ?>
      <?php if (!$displayServices): ?><article class="build-row"><span class="row-number">01</span><h3>Applied intelligence</h3><p>Small, legible systems that move from prototype to the edge of useful.</p><span class="build-arrow" aria-hidden="true">↗</span></article><?php endif; ?>
    </div>
  </section>

  <section class="hq-section hq-projects" id="projects" data-state="BLUEPRINT">
    <div class="section-label"><span>03</span><span>Selected Work</span></div><div class="section-heading section-heading--projects"><h2>Built in the<br><em>real world.</em></h2><a class="hq-text-link" href="/projects">View all work <span>↗</span></a></div>
    <div class="project-stack">
      <?php foreach ($displayProjects as $i => $project): $projectUrl = !empty($project['url']) ? $project['url'] : '/projects/'.e($project['slug'] ?? 'project'); ?><article class="project-card"><div class="project-card__top"><span><?= chr(65 + $i) ?> / <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><span><?= e($project['category'] ?? 'PROJECT') ?></span></div><div class="project-card__main"><div class="project-glyph"><span><?= e(strtoupper(substr((string)($project['name'] ?? 'Y'), 0, 1))) ?></span></div><div><h3><?= e($project['name'] ?? 'Project') ?></h3><p><?= e($project['summary'] ?? 'A digital product built with care.') ?></p></div><a href="<?= e($projectUrl) ?>" class="project-arrow" aria-label="Open dossier for <?= e($project['name'] ?? 'project') ?>">↗</a></div><div class="project-card__foot"><span>PROJECT DOSSIER</span><a href="<?= e($projectUrl) ?>">Open case study <span>›</span></a></div></article><?php endforeach; ?>
    </div>
  </section>

  <section class="hq-section hq-activity" id="engineering" data-state="BLUEPRINT">
    <div class="section-label"><span>04</span><span>Engineering Activity</span></div><div class="activity-grid"><div><span class="mono-label">A QUIETLY ACTIVE GRAPH</span><h2>Making,<br><em>measured.</em></h2><p class="activity-copy">A rough signal of what has my attention lately. Open source, private experiments, and the work between the work.</p><div class="activity-legend"><span><i class="legend-dot legend-dot--amber"></i> commits</span><span><i class="legend-dot"></i> notes</span><span><i class="legend-dot legend-dot--clay"></i> releases</span></div></div><div class="activity-graph"><div class="graph-head"><span>LAST 12 WEEKS</span><span>BUILD / SHIP / LEARN</span></div><div class="graph-grid"><span>high</span><span>mid</span><span>low</span><svg viewBox="0 0 600 235" preserveAspectRatio="none" aria-label="Engineering activity trend"><path d="M0 195 C25 188 28 170 51 178 S80 145 106 155 S137 105 164 129 S191 136 216 115 S237 69 263 83 S287 118 313 96 S340 78 364 88 S389 48 416 64 S442 95 470 75 S493 80 515 48 S545 55 600 28" fill="none" stroke="currentColor" stroke-width="2"/></svg></div><div class="graph-x"><span>JUN 15</span><span>JUL 01</span><span>JUL 15</span><span>AUG 01</span><span>AUG 15</span></div></div></div>
    <div class="activity-log"><div><span class="status-line"><i></i> now</span><strong>Building a small evaluation harness for agentic workflows</strong><span>private / in progress</span></div><div><span class="status-line"><i class="done"></i> shipped</span><strong>Designing systems that keep context close to the work</strong><span>field notes / active</span></div></div>
    <div class="github-activity" data-github-activity data-github-user="yurian51"><div><span class="mono-label">PUBLIC SIGNAL / GITHUB</span><strong>Loading recent public work…</strong></div><a href="https://github.com/yurian51" target="_blank" rel="noreferrer">Open profile ↗</a></div>
  </section>

  <section class="hq-section hq-current" id="currently-building" data-state="EXPERIMENT"><div class="section-label"><span>05</span><span>Currently Building</span></div><div class="current-grid"><div><span class="status-chip"><i></i> ACTIVE THREAD</span><h2>Tools for<br><em>thinking out loud.</em></h2><p>Exploring how an AI layer can help independent builders hold onto context, ask better questions, and ship without losing the thread.</p><a class="hq-button hq-button--outline" href="/contact">Build with me <span>↗</span></a></div><div class="terminal-card"><div class="terminal-top"><span><i></i><i></i><i></i></span><span>yurian / active-thread</span><span>⌘</span></div><pre class="terminal-code" aria-label="Live coding environment"><span class="terminal-line" data-terminal-line="01  const context = await remember(">01  const context = await remember(</span>
<span class="terminal-line" data-terminal-line="02    what_matters: true,">02    what_matters: true,</span>
<span class="terminal-line" data-terminal-line="03    noise: &quot;less&quot;,">03    noise: &quot;less&quot;,</span>
<span class="terminal-line" data-terminal-line="04    next_move: &quot;make&quot;">04    next_move: &quot;make&quot;</span>
<span class="terminal-line" data-terminal-line="05  );">05  );</span>

<span class="terminal-output">→ returning signal <i></i></span></pre></div></div></section>

  <section class="hq-section hq-lab" id="lab" data-state="EXPERIMENT"><div class="section-label"><span>06</span><span>Digital Lab</span></div><div class="lab-heading"><h2>A few things<br><em>in orbit.</em></h2><div><p>Experiments are where I keep the edges soft. Some are useful. Some are just useful to have made.</p><div class="filter-list" role="group" aria-label="Digital Lab filters"><button class="active" data-filter="all">all</button><button data-filter="interfaces">interfaces</button><button data-filter="systems">systems</button><button data-filter="experiments">experiments</button></div></div></div><div class="lab-grid"><a class="lab-tile lab-tile--large" href="#notes" data-category="interfaces"><div class="lab-visual visual-orbit"><span class="orbit orbit--one"></span><span class="orbit orbit--two"></span><span class="orbit-dot"></span></div><span class="mono-label">EXPERIMENT / 014</span><h3>Orbital notes</h3><p>A spatial interface for thoughts that refuse to be linear.</p><span class="lab-arrow">↗</span></a><a class="lab-tile" href="#notes" data-category="interfaces"><div class="lab-visual visual-type">AB<br><span>BA</span><br>AB</div><span class="mono-label">TYPE / 003</span><h3>Signal / noise</h3><p>Letters as objects. A study in rhythm.</p><span class="lab-arrow">↗</span></a><a class="lab-tile" href="#notes" data-category="systems"><div class="lab-visual visual-scan">⌁<span>SCANNING</span></div><span class="mono-label">TOOL / 008</span><h3>Context window</h3><p>A command line for the things you almost forgot.</p><span class="lab-arrow">↗</span></a></div></section>

  <section class="hq-section hq-library" id="library" data-state="KNOWLEDGE"><div class="section-label"><span>07</span><span>Publications / Library</span></div><div class="library-heading"><h2>Ideas worth<br><em>keeping.</em></h2><div class="library-aside"><span aria-hidden="true">✎</span><p>Writing is how I debug my own thinking. A small library of notes, essays, and references from the work.</p></div></div><div class="library-list"><a href="/blog" class="library-row"><span>ESSAY / 01</span><h3>Notes from building in public</h3><span>ARCHIVE</span><span>↗</span></a><a href="/blog" class="library-row"><span>FIELD NOTE / 02</span><h3>On building with a longer horizon</h3><span>ARCHIVE</span><span>↗</span></a><a href="/blog" class="library-row"><span>READING LIST / 03</span><h3>Things that changed how I make</h3><span>ARCHIVE</span><span>↗</span></a></div></section>

  <section class="hq-section hq-notes" id="notes" data-state="KNOWLEDGE"><div class="section-label"><span>08</span><span>Field Notes</span></div><div class="notes-heading"><h2>From the<br><em>notebook.</em></h2><a class="hq-text-link" href="/blog">Read the archive <span>↗</span></a></div><div class="notes-list"><a class="note-row" href="/blog"><span>FIELD NOTE</span><div><small>ACTIVE THREAD</small><h3>Making space for the right question</h3></div><span>↗</span></a><a class="note-row" href="/blog"><span>NOTEBOOK</span><div><small>WORKING PRINCIPLE</small><h3>Software should expand human agency</h3></div><span>↗</span></a></div></section>

  <section class="hq-section hq-cta" id="contact" data-state="CONVERGENCE"><div class="cta-mark"><span>Y</span></div><div><p class="eyebrow"><span class="signal-dot"></span> OPEN TO THE RIGHT PROBLEM</p><h2>Let's make<br><em>something matter.</em></h2><p>Have a hard problem, an early signal, or a future you want to make more legible? <a href="/contact">Start a conversation.</a></p><a class="hq-button hq-button--primary" href="/contact">Build with me <span>↗</span></a> <a class="hq-text-link" href="/books">Visit the Reading Room ↗</a></div></section>
</main>
<?php // The command palette and developer easter egg are wired in the shared JS asset. ?>
<div class="command-palette" id="command-palette" hidden role="dialog" aria-modal="true" aria-labelledby="command-title"><div class="command-palette__panel"><div class="command-palette__head"><span id="command-title">DIGITAL HQ / COMMAND</span><button data-command-close aria-label="Close command palette">Esc</button></div><input id="command-input" type="search" placeholder="Jump to a section…" autocomplete="off"><div class="command-list"><button data-command-target="#identity">01 / Identity Field</button><button data-command-target="#build">02 / System Map</button><button data-command-target="#projects">03 / Blueprint</button><button data-command-target="#currently-building">04 / Experiment</button><button data-command-target="#library">05 / Knowledge</button><button data-command-target="#contact">06 / Convergence</button></div><p>Press <kbd>⌘</kbd><kbd>K</kbd> to open · press <kbd>Esc</kbd> to close</p></div></div>
<div class="easter-egg" id="easter-egg" hidden><span>YURIAN // DEVELOPER MODE</span><strong>Make the invisible legible.</strong><small>↑ ↑ ↓ ↓ ← → ← → B A</small></div>
