<?php
require_once __DIR__.'/_bootstrap.php';

use App\Storage\ObjectStorage;

$message = null;
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    try {
        if (!verify_csrf($_POST['_csrf'] ?? null)) throw new RuntimeException('Security token expired. Refresh and try again.');
        if (!$bookId) throw new RuntimeException('Select a book first.');
        $query = db()->prepare('SELECT id,slug,title FROM books WHERE id=:id LIMIT 1');
        $query->execute([':id'=>$bookId]);
        $book = $query->fetch();
        if (!$book) throw new RuntimeException('Book not found.');
        $url = (new ObjectStorage())->putBookCover($_FILES['cover'] ?? [], (string)$book['slug']);
        $update = db()->prepare('UPDATE books SET cover_url=:url WHERE id=:id');
        $update->execute([':url'=>$url, ':id'=>$bookId]);
        $message = 'Cover uploaded for '.(string)$book['title'].'.';
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
}
$books = db()->query('SELECT id,title,author,cover_url FROM books ORDER BY sort_order ASC,id DESC')->fetchAll();
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Book covers · Yurian CMS</title><link rel="stylesheet" href="/assets/css/app.css"></head><body><main><section class="section"><div class="section__heading"><span>CMS / READING ROOM</span><h1>Book covers</h1></div><?php if($message): ?><p><?=e($message)?></p><?php endif; ?><?php if($error): ?><p role="alert"><?=e($error)?></p><?php endif; ?><form method="post" enctype="multipart/form-data"><input type="hidden" name="_csrf" value="<?=e(csrf_token())?>"><label>Book<select name="book_id" required><option value="">Choose a title</option><?php foreach($books as $book): ?><option value="<?=e((string)$book['id'])?>"><?=e($book['title'])?> — <?=e($book['author'])?></option><?php endforeach; ?></select></label><label>Cover image<input type="file" name="cover" accept="image/jpeg,image/png,image/webp" required></label><p>JPEG, PNG, or WebP. Maximum 5MB.</p><button type="submit">Upload cover</button></form><h2>Current covers</h2><ul><?php foreach($books as $book): ?><li><?=e($book['title'])?> — <?= $book['cover_url'] ? '<a href="'.e($book['cover_url']).'" target="_blank" rel="noreferrer">View cover</a>' : 'No cover yet' ?></li><?php endforeach; ?></ul><p><a href="/admin/index.php">Back to dashboard</a> · <a href="/admin/logout.php">Sign out</a></p></section></main></body></html>
