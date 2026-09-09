<?php $displayProjects=$projects??[]; ?>
<main>
<section class="hero container">
 <div>
  <div class="eyebrow"><span class="dot"></span> available for selected work · Tanzania</div>
  <h1>I build software.<br><span>Products, systems, and tools that people can actually use.</span></h1>
  <p class="hero__copy">I'm Yurian, a software engineer and product builder. I work from idea to production across web applications, business systems, automation and digital products.</p>
  <div class="actions"><a class="button button--primary" href="/projects">View projects</a><a class="button" href="/contact">Contact me</a></div>
  <div class="status-row"><span class="status">PHP</span><span class="status">PostgreSQL</span><span class="status">JavaScript</span><span class="status">Next.js</span><span class="status">Docker</span></div>
 </div>
 <aside class="terminal">
  <div class="terminal-bar"><i></i><i></i><i></i></div>
  <div class="terminal-body">
   <div><span class="key">$</span> whoami</div>
   <div>yurian</div><br>
   <div><span class="key">role</span>: <span class="str">"software engineer"</span></div>
   <div><span class="key">focus</span>: <span class="str">"products & systems"</span></div>
   <div><span class="key">location</span>: <span class="str">"Tanzania"</span></div>
   <div><span class="key">status</span>: <span class="str">"building"</span></div><br>
   <div><span class="key">$</span> ship --with-care</div>
  </div>
 </aside>
</section>
<section class="section"><div class="container">
 <div class="section-head"><h2>Selected work</h2><span class="number">/ 01</span></div>
 <div class="work-list">
 <?php foreach(array_slice($displayProjects,0,7) as $i=>$project): ?><a class="work" href="/projects"><span class="no"><?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?></span><div><h3><?=e($project['name']??'Project')?></h3><p><?=e($project['summary']??'Digital product development.')?></p></div><span class="type"><?=e($project['category']??'PROJECT')?></span></a><?php endforeach; ?>
 </div>
</div></section>
<section class="section"><div class="container">
 <div class="section-head"><h2>How I work</h2><span class="number">/ 02</span></div>
 <p class="intro">I like software that feels considered, not decorated. Clear interfaces, sensible architecture, useful defaults, and enough engineering behind the scenes that the thing still works after the launch post disappears.</p>
 <div class="notes"><div class="note"><h3>01 — Understand</h3><p>Start with the actual problem, users and constraints before choosing technology.</p></div><div class="note"><h3>02 — Build</h3><p>Design the interface, data model and application as one product rather than three unrelated chores.</p></div><div class="note"><h3>03 — Ship</h3><p>Deploy, test, observe and improve. Production is part of the work, unfortunately for everyone involved.</p></div></div>
</div></section>
</main>