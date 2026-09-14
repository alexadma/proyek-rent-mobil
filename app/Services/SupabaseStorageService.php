<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseStorageService
{
    private string $baseUrl;
    private string $apiKey;
    private string $bucket;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.supabase.url', env('SUPABASE_URL')), '/');
        $this->apiKey = config('services.supabase.key', env('SUPABASE_KEY'));
        $this->bucket = config('services.supabase.bucket', env('SUPABASE_BUCKET', 'uploads'));
    }

    /**
     * Upload file to Supabase Storage.
     * Returns the storage path (e.g. "public/foto-mobil/car.jpg").
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = "public/{$folder}/{$filename}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'apikey' => $this->apiKey,
        ])->attach('file', $file->get(), $filename)
          ->post("{$this->baseUrl}/storage/v1/object/{$this->bucket}/{$path}");

        if ($response->failed()) {
            Log::error('Supabase upload failed', [
                'path' => $path,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException('Gagal upload file ke Supabase Storage.');
        }

        return $path;
    }

    /**
     * Delete file from Supabase Storage by its stored path.
     */
    public function delete(string $storagePath): bool
    {
        $path = $this->normalizePath($storagePath);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'apikey' => $this->apiKey,
        ])->delete("{$this->baseUrl}/storage/v1/object/{$this->bucket}/{$path}");

        if ($response->failed()) {
            Log::warning('Supabase delete failed', [
                'path' => $path,
                'status' => $response->status(),
            ]);
            return false;
        }

        return true;
    }

    /**
     * Get public URL for a stored file.
     */
    public function getPublicUrl(string $storagePath): string
    {
        $path = $this->normalizePath($storagePath);

        return "{$this->baseUrl}/storage/v1/object/public/{$this->bucket}/{$path}";
    }

    /**
     * Download file content from Supabase Storage.
     */
    public function get(string $storagePath): ?string
    {
        $path = $this->normalizePath($storagePath);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'apikey' => $this->apiKey,
        ])->get("{$this->baseUrl}/storage/v1/object/{$this->bucket}/{$path}");

        if ($response->failed()) {
            return null;
        }

        return $response->body();
    }

    /**
     * Get MIME type of a file.
     */
    public function mimeType(string $storagePath): string
    {
        $path = $this->normalizePath($storagePath);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'apikey' => $this->apiKey,
        ])->head("{$this->baseUrl}/storage/v1/object/{$this->bucket}/{$path}");

        return $response->header('Content-Type', 'application/octet-stream');
    }

    /**
     * Convert Laravel storage path (e.g. "foto-mobil/car.jpg")
     * to Supabase path (e.g. "public/foto-mobil/car.jpg").
     */
    private function normalizePath(string $storagePath): string
    {
        $storagePath = str_replace('\\', '/', $storagePath);

        // Already has "public/" prefix
        if (str_starts_with($storagePath, 'public/')) {
            return $storagePath;
        }

        // Add "public/" prefix for folders we manage
        return "public/{$storagePath}";
    }
}
