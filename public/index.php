<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/bootstrap.php';
$path=trim(parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/','/');
$routes=[
 ''=>['Yurian | Software Engineer & Product Builder','home.php'],
 'index.php'=>['Yurian | Software Engineer & Product Builder','home.php'],
 'projects'=>['Projects | Yurian','projects.php'],
 'services'=>['Services | Yurian','services.php'],
 'about'=>['About | Yurian','about.php'],
 'contact'=>['Contact | Yurian','contact.php'],
 'blog'=>['Notes | Yurian','blog.php'],
 'privacy'=>['Privacy | Yurian','privacy.php'],
 'terms'=>['Terms | Yurian','terms.php']
];
if(isset($routes[$path])){
 [$pageTitle,$view]=$routes[$path];
 if($view==='home.php'){$profile=profile();$projects=projects(6);$skills=skills();}
 require __DIR__.'/../includes/header.php';
 require __DIR__.'/views/'.$view;
 require __DIR__.'/../includes/footer.php';
 exit;
}
http_response_code(404);
$pageTitle='404 | Yurian';
require __DIR__.'/../includes/header.php';
echo '<main class="container section"><div class="section-head"><h2>Page not found.</h2><span class="number">/ 404</span></div><p class="intro">The requested page does not exist.</p><a class="button button--primary" href="/">Back home</a></main>';
require __DIR__.'/../includes/footer.php';