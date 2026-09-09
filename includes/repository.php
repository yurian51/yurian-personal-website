<?php
declare(strict_types=1);

function profile(): array
{
    try { return db()->query('SELECT * FROM profile ORDER BY id LIMIT 1')->fetch() ?: []; }
    catch (Throwable $e) { return ['name'=>'Yurian','headline'=>'Software Engineer · AI Builder · Technology Creator','intro'=>'Technology-focused builder creating reliable software, intelligent systems and digital products.','bio'=>'I build software products, business systems and AI-powered experiences with a focus on usefulness, reliability and long-term maintainability.','location'=>'Tanzania']; }
}

function projects(int $limit=12): array
{
    try { $s=db()->prepare('SELECT * FROM projects WHERE published=TRUE ORDER BY featured DESC,sort_order ASC,id DESC LIMIT :limit');$s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll(); }
    catch (Throwable $e) { return [
      ['name'=>'YURIAN AI OS','slug'=>'yurian-ai-os','category'=>'AI / Software','summary'=>'An AI-native operating environment for knowledge, projects, documents, workflows and intelligent agents.','url'=>null,'featured'=>true],
      ['name'=>'Altavox Technologies','slug'=>'altavox-technologies','category'=>'Technology','summary'=>'A technology brand and product ecosystem focused on digital business and software systems.','url'=>null,'featured'=>true],
      ['name'=>'Sammena School System','slug'=>'sammena-school-system','category'=>'Education / SaaS','summary'=>'Digital school management and academic operations platform for modern school administration.','url'=>null,'featured'=>true]
    ]; }
}

function services(int $limit=12): array
{
    try { $s=db()->prepare('SELECT * FROM services WHERE published=TRUE ORDER BY sort_order ASC,id DESC LIMIT :limit');$s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll(); }
    catch (Throwable $e) { return [
      ['name'=>'Software Engineering','summary'=>'Custom web applications, APIs and business systems.'],
      ['name'=>'AI Systems','summary'=>'AI agents, automation and intelligent workflows.'],
      ['name'=>'Web Development','summary'=>'Fast, responsive and production-ready websites.'],
      ['name'=>'Business Automation','summary'=>'Digital workflows that reduce repetitive operational work.']
    ]; }
}

function skills(): array
{
    try { return db()->query('SELECT * FROM skills ORDER BY sort_order ASC,id ASC')->fetchAll(); }
    catch (Throwable $e) { return array_map(fn($n)=>['name'=>$n],['PHP','PostgreSQL','JavaScript','HTML5','CSS3','Docker','GitHub','AI Engineering','REST APIs','System Architecture']); }
}