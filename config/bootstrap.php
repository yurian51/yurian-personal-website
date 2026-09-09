<?php
declare(strict_types=1);

date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'Africa/Dar_es_Salaam');

session_name(getenv('SESSION_NAME') ?: 'yurian_session');
session_start();

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/repository.php';
