<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageFileController extends Controller
{
    private const ALLOWED_PREFIXES = ['foto-mobil/', 'foto-supir/', 'bukti-tf/'];

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

        if (! Storage::disk('public')->exists($normalized)) {
            abort(404);
        }

        $mime = Storage::disk('public')->mimeType($normalized);

        return response(Storage::disk('public')->get($normalized))
            ->header('Content-Type', $mime ?: 'application/octet-stream')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
