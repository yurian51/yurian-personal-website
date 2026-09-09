<?php
declare(strict_types=1);
assert(PHP_VERSION_ID>=80300);
assert(is_dir(__DIR__.'/../public'));
assert(is_file(__DIR__.'/../Dockerfile'));
echo "Smoke tests passed.\n";
