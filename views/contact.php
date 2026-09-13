<?php
$sent=false;$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!verify_csrf($_POST['_csrf']??null)){$error='Security token expired. Refresh and try again.';}
    else{
        $name=trim((string)($_POST['name']??''));
        $email=trim((string)($_POST['email']??''));
        $stage=trim((string)($_POST['stage']??''));
        $timeline=trim((string)($_POST['timeline']??''));
        $message=trim((string)($_POST['message']??''));
        $allowedStages=['Idea','Prototype','Live product','Internal system'];
        $allowedTimelines=['Exploring','This quarter','Active now','Longer horizon'];
        $subject='Build With Me intake';
        $details="Stage: {$stage}\nTimeline: {$timeline}\n\n{$message}";
        if($name===''||strlen($name)>160||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>255||$message===''||strlen($message)>10000||!in_array($stage,$allowedStages,true)||!in_array($timeline,$allowedTimelines,true)){$error='Please provide valid project details within the allowed limits.';}
        else{
            try{$stmt=db()->prepare('INSERT INTO messages(name,email,subject,message) VALUES(:name,:email,:subject,:message)');$stmt->execute([':name'=>$name,':email'=>$email,':subject'=>$subject,':message'=>$details]);$sent=true;}
            catch(Throwable $e){error_log('[contact] submission failed: '.get_class($e));$error='The intake service is temporarily unavailable. Please try again later.';}
        }
    }
}
?>
<main class="hq-section intake-page"><div class="section-label"><span>06</span><span>Contact & Project Enquiries</span></div><div class="section-heading"><h1 class="dossier-title">Discuss a technology<br><em>project or system.</em></h1><p>Share the problem, current stage, intended outcome, and timing. The information provided through this form is used to understand the enquiry and respond appropriately.</p></div><div class="intake-panel"><?php if($sent): ?><p class="intake-success">Your enquiry has been received. The project brief will be reviewed and the next useful response will follow by email.</p><?php elseif($error): ?><p class="intake-error"><?=e($error)?></p><?php endif; ?><form method="post" class="contact-form intake-form"><input type="hidden" name="_csrf" value="<?=e(csrf_token())?>"><label>Your name<input name="name" maxlength="160" autocomplete="name" placeholder="Your name or organisation" required></label><label>Email address<input type="email" name="email" maxlength="255" autocomplete="email" placeholder="you@example.com" required></label><label>Current project stage<select name="stage"><option value="Idea">Idea / early stage</option><option value="Prototype">Prototype</option><option value="Live product">Live product</option><option value="Internal system">Internal system</option></select></label><label>Expected timeline<select name="timeline"><option value="Exploring">Exploring</option><option value="This quarter">This quarter</option><option value="Active now">Active now</option><option value="Longer horizon">Longer horizon</option></select></label><label>Project brief<textarea name="message" rows="8" maxlength="10000" placeholder="Describe the problem, users, desired outcome, and relevant constraints…" required></textarea></label><button class="hq-button hq-button--primary" type="submit">Submit project enquiry ↗</button></form></div></main>
