<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use PDO;

final class ProjectRepository
{
    public function published(int $limit = 50): array
    {
        $limit = max(1, min($limit, 100));
        $query = Connection::get()->prepare(
            'SELECT id,name,slug,category,summary,url,featured,sort_order
             FROM projects
             WHERE published = TRUE
             ORDER BY featured DESC, sort_order ASC, id DESC
             LIMIT :limit',
        );
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }
}
