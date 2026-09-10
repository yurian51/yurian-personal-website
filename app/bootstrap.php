<?php
declare(strict_types=1);
if (is_file(__DIR__.'/../vendor/autoload.php')) require_once __DIR__.'/../vendor/autoload.php';
spl_autoload_register(function(string $class): void {
 $prefix='App\\'; if(strncmp($class,$prefix,strlen($prefix))!==0)return;
 $file=__DIR__.'/'.str_replace('\\','/',substr($class,strlen($prefix))).'.php';
 if(is_file($file))require $file;
});
