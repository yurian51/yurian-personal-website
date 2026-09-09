<?php
declare(strict_types=1);
require_once __DIR__.'/../../config/bootstrap.php';
try { $data=(new \App\Repositories\ProjectRepository())->published(); \App\Http\Response::json(['data'=>$data]); } catch(Throwable $e) { \App\Http\Response::json(['error'=>'Service unavailable'],503); }
