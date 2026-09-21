<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/bootstrap.php';
$path=trim(parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/','/');
if (in_array($path, ['robots.txt','sitemap.xml'], true) && is_file(__DIR__.'/'.$path)) { header('Content-Type: '.($path === 'sitemap.xml' ? 'application/xml' : 'text/plain').'; charset=UTF-8'); readfile(__DIR__.'/'.$path); exit; }
$routes=[
 ''=>['Yurian // Digital HQ','home.php'], 'index.php'=>['Yurian // Digital HQ','home.php'],
 'projects'=>['Project Dossiers | Yurian','projects.php'], 'services'=>['Services | Yurian','services.php'],
 'about'=>['About | Yurian','about.php'], 'contact'=>['Build With Me | Yurian','contact.php'],
 'books'=>['The Reading Room | Yurian','books.php'], 'cart'=>['Your Book Cart | Yurian','cart.php'], 'checkout'=>['Book Inquiry | Yurian','checkout.php'],
 'blog'=>['Field Notes | Yurian','blog.php'], 'engineering'=>['Engineering | Yurian','engineering.php'], 'systems'=>['Systems | Yurian','systems.php'],
 'now'=>['Now | Yurian','now.php'], 'under-the-hood'=>['Under the Hood | Yurian','under-the-hood.php'], 'cv'=>['CV | Yurian','cv.php'], 'hire'=>['Work With Yurian | Yurian','hire.php'], 'case-studies'=>['Case Studies | Yurian','case-studies.php'], 'privacy'=>['Privacy | Yurian','privacy.php'], 'terms'=>['Terms | Yurian','terms.php']
];
$projectSlug=null;$noteSlug=null;$bookSlug=null;
if(preg_match('#^projects/([a-z0-9-]+)$#',$path,$m)){$projectSlug=$m[1];$routes[$path]=['Project Dossier | Yurian','project.php'];}
if(preg_match('#^blog/([a-z0-9-]+)$#',$path,$m)){$noteSlug=$m[1];$routes[$path]=['Field Note | Yurian','note.php'];}
if(preg_match('#^books/([a-z0-9-]+)$#',$path,$m)){$bookSlug=$m[1];$routes[$path]=['Book | Yurian','book.php'];}
if(isset($routes[$path])){
 [$pageTitle,$view]=$routes[$path];
 if($view==='home.php'){$profile=profile();$projects=projects(6);$skills=skills();}
 if($view==='project.php'){$project=projectDossier($projectSlug??'');}
 if($view==='note.php'){$note=fieldNoteBySlug($noteSlug??'');}
 if($view==='book.php'){$book=bookBySlug($bookSlug??'');}
 require __DIR__.'/../includes/header.php'; require __DIR__.'/../views/'.$view; require __DIR__.'/../includes/footer.php'; exit;
}
http_response_code(404);$pageTitle='404 | Yurian';require __DIR__.'/../includes/header.php';
echo '<main class="hq-section"><div class="section-label"><span>404</span><span>Not found</span></div><h1 class="dossier-title">The signal moved.</h1><p class="dossier-copy">The requested page does not exist.</p><a class="hq-button hq-button--primary" href="/">Return to Digital HQ ↗</a></main>';
require __DIR__.'/../includes/footer.php';