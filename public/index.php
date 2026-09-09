<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');

if ($path === '' || $path === 'index.php') {
    $pageTitle = 'Yurian | Software Engineer, AI Builder & Technology Creator';
    $profile = profile(); $projects = projects(6); $skills = skills();
    require __DIR__ . '/../includes/header.php';
    require __DIR__ . '/views/home.php';
    require __DIR__ . '/../includes/footer.php';
    exit;
}

$routes = [
    'projects' => ['Projects | Yurian', 'projects.php'],
    'services' => ['Services | Yurian', 'services.php'],
    'about' => ['About | Yurian', 'about.php'],
    'contact' => ['Contact | Yurian', 'contact.php'],
    'blog' => ['Blog | Yurian', 'blog.php'],
];

if (isset($routes[$path])) {
    [$pageTitle, $view] = $routes[$path];
    require __DIR__ . '/../includes/header.php';
    require __DIR__ . '/views/' . $view;
    require __DIR__ . '/../includes/footer.php';
    exit;
}

http_response_code(404);
$pageTitle = '404 | Yurian';
require __DIR__ . '/../includes/header.php';
echo '<main><section class="section"><div class="glass-panel"><p class="eyebrow">404</p><h1>Page not found.</h1><p class="hero__lead">The requested page does not exist.</p><a class="button button--primary" href="/">Back home</a></div></section></main>';
require __DIR__ . '/../includes/footer.php';
