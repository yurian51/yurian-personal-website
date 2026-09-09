<?php
declare(strict_types=1);
require_once __DIR__.'/../../config/bootstrap.php';
\App\Http\Response::json(['status'=>'ok','service'=>'yurian-personal-website','version'=>'1.0.0','php'=>PHP_VERSION]);
