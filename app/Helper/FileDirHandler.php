<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

trait FileDirHandler {
    public function getFilePath(string $configFilePath, ?string $hashId = null): string {
        $basePath = $configFilePath;
        return $hashId ? $basePath . $hashId : $basePath;
    }

    public function ensureFileDirectory(string $configFilePath, string $brandId): void {
        $relativePath = $this->getFilePath($configFilePath, $brandId);

        if (!Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->makeDirectory($relativePath);
        }
    }

    public function getFullStoragePath(string $brandId, string $filename): string {
        return storage_path('app/public/' . $this->getFilePath($brandId) . '/' . $filename);
    }

    public function getProjectFilePath(string $configFilePath, ?string $hashId = null): string {
        $basePath = 'public/storage/' . $configFilePath;
        return $hashId ? $basePath . $hashId : $basePath;
    }
}
