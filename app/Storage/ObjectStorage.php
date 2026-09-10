<?php
declare(strict_types=1);

namespace App\Storage;

use Aws\S3\S3Client;
use RuntimeException;

final class ObjectStorage
{
    private ?S3Client $client = null;

    public function configured(): bool
    {
        return trim((string)getenv('S3_BUCKET')) !== ''
            && trim((string)getenv('S3_ACCESS_KEY')) !== ''
            && trim((string)getenv('S3_SECRET_KEY')) !== ''
            && trim((string)getenv('S3_ENDPOINT')) !== '';
    }

    private function client(): S3Client
    {
        if ($this->client instanceof S3Client) return $this->client;
        if (!$this->configured()) throw new RuntimeException('Object storage is not configured.');
        return $this->client = new S3Client([
            'version' => 'latest',
            'region' => getenv('S3_REGION') ?: 'auto',
            'endpoint' => rtrim((string)getenv('S3_ENDPOINT'), '/'),
            'use_path_style_endpoint' => filter_var(getenv('S3_PATH_STYLE') ?: 'false', FILTER_VALIDATE_BOOLEAN),
            'credentials' => [
                'key' => (string)getenv('S3_ACCESS_KEY'),
                'secret' => (string)getenv('S3_SECRET_KEY'),
            ],
        ]);
    }

    /** @param array<string,mixed> $upload */
    public function putBookCover(array $upload, string $slug): string
    {
        if (($upload['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('The image upload failed.');
        }
        if (!isset($upload['tmp_name'], $upload['size']) || !is_uploaded_file((string)$upload['tmp_name'])) {
            throw new RuntimeException('The uploaded file is invalid.');
        }
        if ((int)$upload['size'] > 5 * 1024 * 1024) {
            throw new RuntimeException('Book covers must be 5MB or smaller.');
        }
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file((string)$upload['tmp_name']);
        $extensions = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if (!isset($extensions[$mime])) {
            throw new RuntimeException('Only JPEG, PNG, and WebP book covers are supported.');
        }
        $safeSlug = preg_replace('/[^a-z0-9-]+/', '-', strtolower($slug)) ?: 'book';
        $key = 'book-covers/'.$safeSlug.'/'.bin2hex(random_bytes(12)).'.'.$extensions[$mime];
        $this->client()->putObject([
            'Bucket' => (string)getenv('S3_BUCKET'),
            'Key' => $key,
            'Body' => fopen((string)$upload['tmp_name'], 'rb'),
            'ContentType' => $mime,
            'CacheControl' => 'public, max-age=31536000, immutable',
        ]);
        $base = trim((string)getenv('S3_PUBLIC_BASE_URL'));
        if ($base === '') throw new RuntimeException('S3_PUBLIC_BASE_URL is not configured.');
        return rtrim($base, '/').'/'.str_replace('%2F', '/', rawurlencode($key));
    }
}
