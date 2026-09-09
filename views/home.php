<?php
$displayProjects=$projects??[];
?>
<main>
<section class="hero container">
  <div>
    <p class="kicker">Independent software engineer · Tanzania</p>
    <h1>I build <em>useful</em> software for people and businesses.</h1>
    <p class="hero__copy">I'm Yurian, a software engineer and product builder. I design and ship web applications, business systems and digital products with a practical focus on reliability and good user experience.</p>
    <div class="actions"><a class="button button--primary" href="/projects">View selected work</a><a class="button button--light" href="/contact">Get in touch</a></div>
  </div>
  <aside class="portrait-card"><div class="initials">Y.</div><div><strong>Yurian</strong><br><small>Software engineering · Product development · Digital systems</small></div></aside>
</section>

<section class="section">
 <div class="container">
  <div class="section-head"><span class="number">01 / WORK</span><h2>Things I've been building.</h2></div>
  <div class="work-list">
   <?php foreach(array_slice($displayProjects,0,5) as $i=>$project): ?>
   <a class="work" href="/projects">
    <span class="no"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
    <div><h3><?= e($project['name']??'Project') ?></h3><p><?= e($project['summary']??'Digital product development.') ?></p></div>
    <span class="type"><?= e($project['category']??'Project') ?></span>
   </a>
   <?php endforeach; ?>
  </div>
 </div>
</section>

<section class="section">
 <div class="container">
  <div class="section-head"><span class="number">02 / APPROACH</span><h2>Less noise. More useful software.</h2></div>
  <p class="intro">I care about clear interfaces, maintainable code, dependable infrastructure and products that solve an actual problem. Technology is the tool, not the personality.</p>
  <div class="notes">
   <div class="note"><h3>01 — Product thinking</h3><p>Start with the user's problem, then choose the simplest technology that can solve it well.</p></div>
   <div class="note"><h3>02 — Engineering</h3><p>Build systems that are understandable, testable and ready for the boring realities of production.</p></div>
   <div class="note"><h3>03 — Long-term value</h3><p>Prefer useful features and thoughtful details over visual tricks that exist mainly to impress other developers.</p></div>
  </div>
 </div>
</section>
</main>