<?php
declare(strict_types=1);

$sent = false;
$error = null;
$allowedStages = ['Idea', 'Prototype', 'Live product', 'Internal system'];
$allowedTimelines = ['Exploring', 'This quarter', 'Active now', 'Longer horizon'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $error = 'Security token expired. Refresh and try again.';
    } else {
        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $stage = trim((string)($_POST['stage'] ?? ''));
        $timeline = trim((string)($_POST['timeline'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));

        if ($name === '' || strlen($name) > 160 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please provide a valid name and email.';
        } elseif (!in_array($stage, $allowedStages, true) || !in_array($timeline, $allowedTimelines, true)) {
            $error = 'Please choose a valid project stage and horizon.';
        } elseif ($message === '' || strlen($message) > 5000) {
            $error = 'Please provide a project brief of 5,000 characters or fewer.';
        } else {
            $subject = 'Build With Me intake';
            $details = "Stage: {$stage}\nTimeline: {$timeline}\n\n{$message}";
            try {
                $stmt = db()->prepare('INSERT INTO messages(name,email,subject,message) VALUES(:name,:email,:subject,:message)');
                $stmt->execute([':name'=>$name,':email'=>$email,':subject'=>$subject,':message'=>$details]);
                $sent = true;
            } catch (Throwable $e) {
                error_log('[contact] '.get_class($e).': '.$e->getMessage());
                $error = 'The intake service is temporarily unavailable. Please try again later.';
            }
        }
    }
}
?>
<main class="hq-section intake-page">
  <div class="section-label"><span>09</span><span>Build With Me</span></div>
  <div class="section-heading"><h1 class="dossier-title">Let's make<br><em>something matter.</em></h1><p>Have a hard problem, an early signal, or a future you want to make more legible? Share enough context to start a useful conversation.</p></div>
  <div class="intake-panel">
    <?php if ($sent): ?><p class="intake-success">Message received. I’ll read the brief and respond with the next useful question.</p><?php elseif ($error): ?><p class="intake-error" role="alert"><?=e($error)?></p><?php endif; ?>
    <form method="post" class="contact-form intake-form">
      <input type="hidden" name="_csrf" value="<?=e(csrf_token())?>">
      <label>Your name<input name="name" placeholder="Arshad / team name" maxlength="160" required></label>
      <label>Email address<input type="email" name="email" placeholder="you@example.com" maxlength="255" autocomplete="email" required></label>
      <label>Where is the project now?<select name="stage"><option value="Idea">Idea / early signal</option><option value="Prototype">Prototype</option><option value="Live product">Live product</option><option value="Internal system">Internal system</option></select></label>
      <label>What is the horizon?<select name="timeline"><option value="Exploring">Exploring</option><option value="This quarter">This quarter</option><option value="Active now">Active now</option><option value="Longer horizon">Longer horizon</option></select></label>
      <label>Tell me what you are building<textarea name="message" rows="8" maxlength="5000" placeholder="The problem, the people, and what you want to make possible…" required><?=e($_POST['message'] ?? '')?></textarea></label>
      <button class="hq-button hq-button--primary" type="submit">Send project brief ↗</button>
    </form>
  </div>
</main>
