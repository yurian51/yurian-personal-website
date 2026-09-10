<?php
$sent = false; $error = null;
$items = cartItems();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $notes = trim((string)($_POST['notes'] ?? ''));
    if (!verify_csrf($_POST['_csrf'] ?? null)) $error = 'Security token expired. Refresh and try again.';
    elseif (!$items) $error = 'Your cart is empty.';
    elseif ($name === '' || strlen($name) > 160 || !filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Please provide a valid name and email.';
    elseif (submitBookOrder($name, $email, $notes, $items)) { clearCart(); $sent = true; }
    else $error = 'The reading-room service is temporarily unavailable. Please try again later.';
}
?>
<main class="hq-section intake-page store-page">
  <div class="section-label"><span>12</span><span>Book Inquiry</span></div>
  <?php if ($sent): ?><div class="intake-panel"><p class="intake-success">Inquiry received. We’ll reply with availability, delivery options, and payment instructions.</p><a class="hq-text-link" href="/books">Return to the reading room ↗</a></div><?php elseif (!$items): ?><div class="intake-panel"><p class="dossier-copy">There are no books in your cart yet.</p><a class="hq-button hq-button--primary" href="/books">Browse books ↗</a></div><?php else: ?>
  <div class="section-heading"><h1 class="dossier-title">Make it<br><em>real.</em></h1><p>This is an inquiry, not a payment form. Share your details and we’ll confirm the order before any charge or dispatch.</p></div>
  <?php if ($error): ?><p class="intake-error"><?= e($error) ?></p><?php endif; ?>
  <div class="checkout-grid"><div class="intake-panel"><form method="post" class="contact-form intake-form"><input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>"><label>Your name<input name="name" maxlength="160" required value="<?= e($_POST['name'] ?? '') ?>"></label><label>Email address<input type="email" name="email" maxlength="255" required value="<?= e($_POST['email'] ?? '') ?>"></label><label>Delivery notes<textarea name="notes" rows="5" maxlength="2000" placeholder="City, preferred format, or anything useful…"><?= e($_POST['notes'] ?? '') ?></textarea></label><button class="hq-button hq-button--primary" type="submit">Send book inquiry ↗</button></form></div><aside class="checkout-aside"><span class="mono-label">YOUR SHELF</span><?php foreach ($items as $item): ?><p><?= e($item['title']) ?> × <?= (int)$item['quantity'] ?></p><?php endforeach; ?><div class="dossier-rule"></div><strong><?= e(number_format(cartTotal(), 2)) ?> <?= e($items[0]['currency'] ?? 'USD') ?></strong></aside></div>
  <?php endif; ?>
</main>
