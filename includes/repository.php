<?php
declare(strict_types=1);

function profile(): array
{
    return db()->query('SELECT * FROM profile ORDER BY id LIMIT 1')->fetch() ?: [];
}

function projects(int $limit = 12): array
{
    $stmt = db()->prepare('SELECT * FROM projects WHERE published = TRUE ORDER BY featured DESC, sort_order ASC, id DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function services(int $limit = 12): array
{
    $stmt = db()->prepare('SELECT * FROM services WHERE published = TRUE ORDER BY sort_order ASC, id DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function skills(): array
{
    return db()->query('SELECT * FROM skills ORDER BY sort_order ASC, id ASC')->fetchAll();
}
