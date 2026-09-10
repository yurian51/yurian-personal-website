<?php
declare(strict_types=1);

namespace App\Http;

use JsonException;

final class Response
{
    public static function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        try {
            echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            http_response_code(500);
            echo '{"error":"Unable to encode response"}';
        }
        exit;
    }

    public static function redirect(string $location, int $status = 302): never
    {
        header('Location: ' . $location, true, $status);
        exit;
    }
}
