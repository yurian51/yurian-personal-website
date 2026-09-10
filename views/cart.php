<?php
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $message = 'Security token expired. Refresh and try again.';
    } elseif (($_POST['action'] ?? '') === 'add' && addToCart(trim((string)($_POST['slug'] ?? '')))) {
        header('Location: /cart'); exit;
    } elseif (($_POST['action'] ?? '') === 'remove') {
        removeFromCart(trim((string)($_POST['slug'] ?? '')));
        header('Location: /cart'); exit;
    } else {
        $message = 'That title is unavailable right now.';
    }
}
$items = cartItems();
?>
<main class="hq-section store-page">
  <div class="section-label"><span>11</span><span>Your Cart</span></div>
  <div class="section-heading"><h1 class="dossier-title">A shelf,<br><em>in progress.</em></h1><p>Review your titles before sending a reading-room inquiry. Quantities are capped per title and checked against available stock.</p></div>
  <?php if ($message): ?><p class="intake-error"><?= e($message) ?></p><?php endif; ?>
  <?php if (!$items): ?><div class="store-empty"><p>Your cart is empty.</p><a class="hq-button hq-button--primary" href="/books">Browse the reading room ↗</a></div><?php else: ?>
    <div class="cart-list"><?php foreach ($items as $item): ?><div class="cart-row"><div><span class="mono-label">BOOK</span><h2><?= e($item['title']) ?></h2><p><?= (int)$item['quantity'] ?> × <?= e(number_format((float)$item['price'], 2)) ?> <?= e($item['currency'] ?? 'USD') ?></p></div><strong><?= e(number_format((float)$item['line_total'], 2)) ?> <?= e($item['currency'] ?? 'USD') ?></strong><form method="post"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="remove"><input type="hidden" name="slug" value="<?= e($item['slug']) ?>"><button class="hq-text-link" type="submit">Remove</button></form></div><?php endforeach; ?></div>
    <div class="cart-summary"><span>Total / <?= e($items[0]['currency'] ?? 'USD') ?></span><strong><?= e(number_format(cartTotal(), 2)) ?></strong><a class="hq-button hq-button--primary" href="/checkout">Continue to inquiry ↗</a></div>
  <?php endif; ?>
</main>
