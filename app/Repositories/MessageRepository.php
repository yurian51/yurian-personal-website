<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Database\Connection;
final class MessageRepository {
 public function create(string $name,string $email,string $subject,string $message): int { $q=Connection::get()->prepare('INSERT INTO messages(name,email,subject,message) VALUES(:name,:email,:subject,:message) RETURNING id'); $q->execute([':name'=>$name,':email'=>$email,':subject'=>$subject,':message'=>$message]); return (int)$q->fetchColumn(); }
}