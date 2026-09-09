<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Database\Connection;
final class ProjectRepository {
 public function published(int $limit=50): array { $q=Connection::get()->prepare('SELECT id,name,slug,category,summary,url,featured,sort_order FROM projects WHERE published=TRUE ORDER BY featured DESC,sort_order ASC,id DESC LIMIT :limit'); $q->bindValue(':limit',$limit,\PDO::PARAM_INT); $q->execute(); return $q->fetchAll(); }
}