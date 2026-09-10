<?php $catalog = books(24); ?>
<main class="hq-section store-page">
  <div class="section-label"><span>10</span><span>The Reading Room</span></div>
  <div class="section-heading"><h1 class="dossier-title">Ideas worth<br><em>holding.</em></h1><p>A small shelf of books and working notes from the Yurian universe. Choose a title, add it to your cart, and send a reading-room inquiry.</p></div>
  <div class="store-grid">
    <?php foreach ($catalog as $book): ?>
      <article class="store-card">
        <div class="store-cover" aria-hidden="true"><span><?= e(strtoupper(substr((string)$book['title'], 0, 1))) ?></span><small>YURIAN<br>PRESS</small></div>
        <div class="store-card__body">
          <span class="mono-label">BOOK / <?= e(strtoupper($book['currency'] ?? 'USD')) ?></span>
          <h2><?= e($book['title']) ?></h2>
          <p class="store-author">By <?= e($book['author']) ?></p>
          <p><?= e($book['description']) ?></p>
          <div class="store-card__foot"><strong><?= e(number_format((float)$book['price'], 2)) ?> <?= e($book['currency'] ?? 'USD') ?></strong><span><?= (int)($book['stock_quantity'] ?? 0) > 0 ? 'In stock' : 'Sold out' ?></span></div>
          <div class="store-actions"><a class="hq-text-link" href="/books/<?= e($book['slug']) ?>">Read details ↗</a><?php if ((int)($book['stock_quantity'] ?? 0) > 0): ?><form method="post" action="/cart"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="add"><input type="hidden" name="slug" value="<?= e($book['slug']) ?>"><button class="hq-button hq-button--primary" type="submit">Add to cart +</button></form><?php endif; ?></div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</main>
