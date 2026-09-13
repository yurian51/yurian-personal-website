<?php
$displayProjects = $projects ?? projects(6);
$displayServices = services(4);
$displayProfile = $profile ?? profile();
$heroName = $displayProfile['name'] ?? 'Arshad Yurian Mwangi';
$displayLocation = trim((string)($displayProfile['location'] ?? 'Tanzania')) ?: 'Tanzania';
?>
<main id="main-content" data-scroll-state="ORIGIN">
  <section class="hq-hero" id="top" data-state="ORIGIN">
    <div class="hq-hero__copy">
      <p class="eyebrow"><span class="signal-dot"></span> <?= e($displayLocation) ?> · <?= date('Y') ?></p>
      <h1>BUILDING<br><em>DIGITAL SYSTEMS</em><br>FOR WHAT<br><span>COMES NEXT.</span></h1>
      <p class="hero-intro"><?= e($displayProfile['intro'] ?? 'Software engineer, AI builder, technology entrepreneur, and creator developing reliable digital products and intelligent systems for real-world use.') ?></p>
      <div class="hero-actions">
        <a class="hq-button hq-button--primary" href="#build">Explore capabilities <span aria-hidden="true">↘</span></a>
        <a class="hq-text-link" href="/contact">Start a conversation <span aria-hidden="true">↗</span></a>
      </div>
    </div>
    <div class="universe-frame" aria-label="YURIAN technology systems overview">
      <div class="universe-meta"><span>YURIAN TECHNOLOGY SYSTEMS</span><span>01 — 05</span></div>
      <div class="signal-ring signal-ring--one"></div><div class="signal-ring signal-ring--two"></div>
      <div class="signal-core"><span>Y</span></div>
      <div class="signal-label">◉ SYSTEM / 001</div>
      <div class="coordinates"><?= e($displayLocation) ?><br>GLOBAL / REMOTE</div>
    </div>
    <div class="hero-foot"><span>© <?= date('Y') ?> YURIAN // TECHNOLOGY</span><span>AVAILABLE FOR SELECT BUILDS <i></i></span></div>
  </section>

  <section class="hq-section hq-identity" id="identity" data-state="IDENTITY FIELD">
    <div class="section-label"><span>01</span><span>About</span></div>
    <div class="identity-grid">
      <p class="display-kicker">Independent technology.<br><em>Built with purpose.</em></p>
      <div class="identity-copy"><p class="lede">I work at the intersection of <strong>software engineering, artificial intelligence, and digital products.</strong> The focus is practical: turn complex requirements into systems that are useful, maintainable, secure, and ready for real users.</p><div class="identity-details"><div><span>ROLE</span><p>Software Engineer / Builder<br>Independent technology practice</p></div><div><span>BASED IN</span><p><?= e($displayLocation) ?><br>Working internationally</p></div><div><span>APPROACH</span><p><i class="status-pulse"></i> Research, build, verify</p></div></div></div>
    </div><div class="identity-rule"></div><div class="identity-bottom"><span>Technology should expand human capability.</span><span>— working principle</span></div>
  </section>

  <section class="hq-section hq-build" id="build" data-state="SYSTEM MAP">
    <div class="section-label"><span>02</span><span>Capabilities</span></div><div class="section-heading"><h2>Engineering<br><em>with intent.</em></h2><p>Projects begin with the problem, then move through research, architecture, implementation, verification, and continuous improvement.</p></div>
    <div class="build-list">
      <?php foreach ($displayServices as $i => $service): ?><article class="build-row"><span class="row-number"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><h3><?= e($service['name'] ?? 'Digital systems') ?></h3><p><?= e($service['summary'] ?? 'Reliable software, intelligent systems, and digital infrastructure for ambitious work.') ?></p><span class="build-arrow" aria-hidden="true">↗</span></article><?php endforeach; ?>
      <?php if (!$displayServices): ?><article class="build-row"><span class="row-number">01</span><h3>Applied technology</h3><p>Reliable digital systems that move from validated concept to production use.</p><span class="build-arrow" aria-hidden="true">↗</span></article><?php endif; ?>
    </div>
  </section>

  <section class="hq-section hq-projects" id="projects" data-state="BLUEPRINT">
    <div class="section-label"><span>03</span><span>Portfolio</span></div><div class="section-heading section-heading--projects"><h2>Built for the<br><em>real world.</em></h2><a class="hq-text-link" href="/projects">View portfolio <span>↗</span></a></div>
    <div class="project-stack">
      <?php foreach ($displayProjects as $i => $project): $projectSlug = trim((string)($project['slug'] ?? 'project')); $projectUrl = safe_link(!empty($project['url']) ? (string)$project['url'] : '/projects/' . rawurlencode($projectSlug)) ?? '/projects'; ?><article class="project-card"><div class="project-card__top"><span><?= chr(65 + $i) ?> / <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><span><?= e($project['category'] ?? 'PROJECT') ?></span></div><div class="project-card__main"><div class="project-glyph"><span><?= e(strtoupper(substr((string)($project['name'] ?? 'Y'), 0, 1))) ?></span></div><div><h3><?= e($project['name'] ?? 'Project') ?></h3><p><?= e($project['summary'] ?? 'A digital product engineered for practical use.') ?></p></div><a href="<?= e($projectUrl) ?>" class="project-arrow" aria-label="Open dossier for <?= e($project['name'] ?? 'project') ?>">↗</a></div><div class="project-card__foot"><span>PROJECT DOSSIER</span><a href="<?= e($projectUrl) ?>">Open case study <span>›</span></a></div></article><?php endforeach; ?>
    </div>
  </section>

  <section class="hq-section hq-activity" id="engineering" data-state="BLUEPRINT">
    <div class="section-label"><span>04</span><span>Engineering Activity</span></div><div class="activity-grid"><div><span class="mono-label">PUBLIC ENGINEERING SIGNAL</span><h2>Building,<br><em>measured.</em></h2><p class="activity-copy">A concise view of current engineering attention across public work, private development, experiments, and research.</p><div class="activity-legend"><span><i class="legend-dot legend-dot--amber"></i> commits</span><span><i class="legend-dot"></i> notes</span><span><i class="legend-dot legend-dot--clay"></i> releases</span></div></div><div class="activity-graph"><div class="graph-head"><span>LAST 12 WEEKS</span><span>BUILD / SHIP / LEARN</span></div><div class="graph-grid"><span>high</span><span>mid</span><span>low</span><svg viewBox="0 0 600 235" preserveAspectRatio="none" aria-label="Engineering activity trend"><path d="M0 195 C25 188 28 170 51 178 S80 145 106 155 S137 105 164 129 S191 136 216 115 S237 69 263 83 S287 118 313 96 S340 78 364 88 S389 48 416 64 S442 95 470 75 S493 80 515 48 S545 55 600 28" fill="none" stroke="currentColor" stroke-width="2"/></svg></div><div class="graph-x"><span>JUN 15</span><span>JUL 01</span><span>JUL 15</span><span>AUG 01</span><span>AUG 15</span></div></div></div>
    <div class="activity-log"><div><span class="status-line"><i></i> now</span><strong>Building a small evaluation harness for agentic workflows</strong><span>private / in progress</span></div><div><span class="status-line"><i class="done"></i> shipped</span><strong>Designing systems that keep context close to the work</strong><span>field notes / active</span></div></div>
    <div class="github-activity" data-github-activity data-github-user="yurian51"><div><span class="mono-label">PUBLIC SIGNAL / GITHUB</span><strong>Loading recent public work…</strong></div><a href="https://github.com/yurian51" target="_blank" rel="noreferrer">Open profile ↗</a></div>
  </section>

  <section class="hq-section hq-current" id="currently-building" data-state="EXPERIMENT"><div class="section-label"><span>05</span><span>Current Work</span></div><div class="current-grid"><div><span class="status-chip"><i></i> ACTIVE DEVELOPMENT</span><h2>Tools for<br><em>better decisions.</em></h2><p>Exploring how AI systems can help independent builders preserve context, evaluate options, and move from research to implementation without losing the thread.</p><a class="hq-button hq-button--outline" href="/contact">Discuss a project <span>↗</span></a></div><div class="terminal-card"><div class="terminal-top"><span><i></i><i></i><i></i></span><span>yurian / active-development</span><span>⌘</span></div><pre class="terminal-code" aria-label="Development workflow example"><span class="terminal-line" data-terminal-line="01  const context = await remember(">01  const context = await remember(</span>
<span class="terminal-line" data-terminal-line="02    what_matters: true,">02    what_matters: true,</span>
<span class="terminal-line" data-terminal-line="03    noise: &quot;less&quot;,">03    noise: &quot;less&quot;,</span>
<span class="terminal-line" data-terminal-line="04    next_move: &quot;make&quot;">04    next_move: &quot;make&quot;</span>
<span class="terminal-line" data-terminal-line="05  );">05  );</span>

<span class="terminal-output">→ returning signal <i></i></span></pre></div></div></section>

  <section class="hq-section hq-lab" id="lab" data-state="EXPERIMENT"><div class="section-label"><span>06</span><span>Technology Lab</span></div><div class="lab-heading"><h2>Research,<br><em>experiments.</em></h2><div><p>A working space for interface studies, systems experiments, prototypes, and technical ideas that may become production work.</p><div class="filter-list" role="group" aria-label="Technology Lab filters"><button class="active" data-filter="all">all</button><button data-filter="interfaces">interfaces</button><button data-filter="systems">systems</button><button data-filter="experiments">experiments</button></div></div></div><div class="lab-grid"><a class="lab-tile lab-tile--large" href="#notes" data-category="interfaces"><div class="lab-visual visual-orbit"><span class="orbit orbit--one"></span><span class="orbit orbit--two"></span><span class="orbit-dot"></span></div><span class="mono-label">EXPERIMENT / 014</span><h3>Knowledge interface</h3><p>A spatial interface for organising research, notes, and connected ideas.</p><span class="lab-arrow">↗</span></a><a class="lab-tile" href="#notes" data-category="interfaces"><div class="lab-visual visual-type">AB<br><span>BA</span><br>AB</div><span class="mono-label">TYPE / 003</span><h3>Signal / noise</h3><p>An interface study focused on hierarchy, rhythm, and readable information.</p><span class="lab-arrow">↗</span></a><a class="lab-tile" href="#notes" data-category="systems"><div class="lab-visual visual-scan">⌁<span>SCANNING</span></div><span class="mono-label">TOOL / 008</span><h3>Context window</h3><p>A prototype for retrieving relevant context while keeping work focused.</p><span class="lab-arrow">↗</span></a></div></section>

  <section class="hq-section hq-library" id="library" data-state="KNOWLEDGE"><div class="section-label"><span>07</span><span>Publications / Library</span></div><div class="library-heading"><h2>Research worth<br><em>keeping.</em></h2><div class="library-aside"><span aria-hidden="true">✎</span><p>Writing is part of the engineering process: a way to document decisions, test ideas, and make technical thinking easier to reuse.</p></div></div><div class="library-list"><a href="/blog" class="library-row"><span>ESSAY / 01</span><h3>Notes from building digital systems</h3><span>ARCHIVE</span><span>↗</span></a><a href="/blog" class="library-row"><span>FIELD NOTE / 02</span><h3>Engineering with a longer horizon</h3><span>ARCHIVE</span><span>↗</span></a><a href="/blog" class="library-row"><span>READING LIST / 03</span><h3>Ideas that changed how I build</h3><span>ARCHIVE</span><span>↗</span></a></div></section>

  <section class="hq-section hq-notes" id="notes" data-state="KNOWLEDGE"><div class="section-label"><span>08</span><span>Insights</span></div><div class="notes-heading"><h2>From the<br><em>notebook.</em></h2><a class="hq-text-link" href="/blog">Read the archive <span>↗</span></a></div><div class="notes-list"><a class="note-row" href="/blog"><span>FIELD NOTE</span><div><small>ACTIVE THREAD</small><h3>Making space for the right technical question</h3></div><span>↗</span></a><a class="note-row" href="/blog"><span>NOTEBOOK</span><div><small>WORKING PRINCIPLE</small><h3>Software should expand human capability</h3></div><span>↗</span></a></div></section>

  <section class="hq-section hq-cta" id="contact" data-state="CONVERGENCE"><div class="cta-mark"><span>Y</span></div><div><p class="eyebrow"><span class="signal-dot"></span> OPEN TO SELECT PROJECTS</p><h2>Let's build<br><em>something useful.</em></h2><p>Have a complex technical problem, an early product idea, or a system that needs to become more reliable? <a href="/contact">Start a conversation.</a></p><a class="hq-button hq-button--primary" href="/contact">Discuss a project <span>↗</span></a> <a class="hq-text-link" href="/books">Visit the Publications <span>↗</span></a></div></section>
</main>
<?php // The command palette and developer easter egg are wired in the shared JS asset. ?>
<div class="command-palette" id="command-palette" hidden role="dialog" aria-modal="true" aria-labelledby="command-title"><div class="command-palette__panel"><div class="command-palette__head"><span id="command-title">YURIAN / COMMAND</span><button data-command-close aria-label="Close command palette">Esc</button></div><input id="command-input" type="search" placeholder="Jump to a section…" autocomplete="off"><div class="command-list"><button data-command-target="#identity">01 / About</button><button data-command-target="#build">02 / Capabilities</button><button data-command-target="#projects">03 / Portfolio</button><button data-command-target="#currently-building">04 / Current Work</button><button data-command-target="#library">05 / Publications</button><button data-command-target="#contact">06 / Contact</button></div><p>Press <kbd>⌘</kbd><kbd>K</kbd> to open · press <kbd>Esc</kbd> to close</p></div></div>
<div class="easter-egg" id="easter-egg" hidden><span>YURIAN // DEVELOPER MODE</span><strong>Make the invisible legible.</strong><small>↑ ↑ ↓ ↓ ← → ← → B A</small></div>
