<?php
declare(strict_types=1);

use App\Database\Connection;

function db(): PDO
{
    return Connection::get();
}
