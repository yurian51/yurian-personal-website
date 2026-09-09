<?php
declare(strict_types=1);
require_once __DIR__.'/../app/bootstrap.php';
require_once __DIR__.'/database.php';
require_once __DIR__.'/../includes/functions.php';
require_once __DIR__.'/../includes/repository.php';
date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'Africa/Dar_es_Salaam');
if(session_status()===PHP_SESSION_NONE){session_name(getenv('SESSION_NAME')?:'yurian_session');session_start();}
