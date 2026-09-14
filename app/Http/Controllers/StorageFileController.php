<?php

namespace App\Http\Controllers;

use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;

class StorageFileController extends Controller
{
    private const ALLOWED_PREFIXES = ['foto-mobil/', 'foto-supir/', 'bukti-tf/'];

    public function __construct(
        private SupabaseStorageService $storage
    ) {}

    public function show(Request $request, string $path)
    {
        $normalized = str_replace('\\', '/', $path);

        $hasAllowedPrefix = false;
        foreach (self::ALLOWED_PREFIXES as $prefix) {
            if (str_starts_with($normalized, $prefix)) {
                $hasAllowedPrefix = true;
                break;
            }
        }

        if (str_contains($normalized, '..') || ! $hasAllowedPrefix) {
            abort(404);
        }

        $content = $this->storage->get($normalized);
        if ($content === null) {
            abort(404);
        }

        $mime = $this->storage->mimeType($normalized);

        return response($content)
            ->header('Content-Type', $mime)
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
