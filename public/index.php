<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');

if ($path === 'robots.txt') {
    header('Content-Type: text/plain; charset=UTF-8');
    echo "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n";
    exit;
}

if ($path === 'sitemap.xml') {
    header('Content-Type: application/xml; charset=UTF-8');
    $urls = ['/', '/about', '/projects', '/services', '/blog', '/books', '/contact', '/privacy', '/terms'];
    foreach (projects(100) as $project) {
        if (!empty($project['slug'])) $urls[] = '/projects/' . $project['slug'];
    }
    foreach (fieldNotes() as $note) {
        if (!empty($note['slug'])) $urls[] = '/blog/' . $note['slug'];
    }
    foreach (books(100) as $book) {
        if (!empty($book['slug'])) $urls[] = '/books/' . $book['slug'];
    }
    $urls = array_values(array_unique($urls));
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach ($urls as $urlPath) {
        echo '  <url><loc>' . htmlspecialchars(url($urlPath), ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc></url>\n";
    }
    echo "</urlset>\n";
    exit;
}

$routes = [
 ''=>['Yurian // Digital HQ','home.php'], 'index.php'=>['Yurian // Digital HQ','home.php'],
 'projects'=>['Project Dossiers | Yurian','projects.php'], 'services'=>['Services | Yurian','services.php'],
 'about'=>['Identity | Yurian','about.php'], 'contact'=>['Build With Me | Yurian','contact.php'],
 'books'=>['The Reading Room | Yurian','books.php'], 'cart'=>['Your Book Cart | Yurian','cart.php'], 'checkout'=>['Book Inquiry | Yurian','checkout.php'],
 'blog'=>['Field Notes | Yurian','blog.php'], 'privacy'=>['Privacy | Yurian','privacy.php'], 'terms'=>['Terms | Yurian','terms.php']
];
$projectSlug = null; $noteSlug = null; $bookSlug = null;
if (preg_match('#^projects/([a-z0-9-]+)$#', $path, $match)) { $projectSlug=$match[1]; $routes[$path]=['Project Dossier | Yurian','project.php']; }
if (preg_match('#^blog/([a-z0-9-]+)$#', $path, $match)) { $noteSlug=$match[1]; $routes[$path]=['Field Note | Yurian','note.php']; }
if (preg_match('#^books/([a-z0-9-]+)$#', $path, $match)) { $bookSlug=$match[1]; $routes[$path]=['Book | Yurian','book.php']; }

if (isset($routes[$path])) {
    [$pageTitle,$view] = $routes[$path];
    if ($view === 'home.php') {$profile=profile();$projects=projects(6);$skills=skills();}
    if ($view === 'project.php') {$project=projectBySlug($projectSlug ?? '');}
    if ($view === 'note.php') {$note=fieldNoteBySlug($noteSlug ?? '');}
    if ($view === 'book.php') {$book=bookBySlug($bookSlug ?? '');}
    require __DIR__.'/../includes/header.php'; require __DIR__.'/../views/'.$view; require __DIR__.'/../includes/footer.php'; exit;
}

http_response_code(404); $pageTitle='404 | Yurian'; require __DIR__.'/../includes/header.php';
echo '<main class="hq-section"><div class="section-label"><span>404</span><span>Not found</span></div><h1 class="dossier-title">The signal moved.</h1><p class="dossier-copy">The requested page does not exist.</p><a class="hq-button hq-button--primary" href="/">Return to Digital HQ ↗</a></main>';
require __DIR__.'/../includes/footer.php';
