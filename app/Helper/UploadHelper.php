<?php


namespace App\Helper;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHelper {
    public static function store($file, string $path){
        if ($file) {
            return basename($file->store($path, 'public'));
        }
        return '';
    }
    public static function storeAs($file, $path, $ext){
        if ($file) return basename($file->storeAs($path, Str::random(40).$ext));
        return '';
    }
    public static function getOriginalName($file){
        return isset($file) ? $file->getClientOriginalName() : '';
    }

    public static function getFilePath(string $configFilePath, ?string $hashId = null): string {
        $basePath = $configFilePath;
        return $hashId ? $basePath . $hashId : $basePath;
    }

    public static function ensureFileDirectory(string $configFilePath, ?string $hashId = null): string {
        $relativePath = self::getFilePath($configFilePath, $hashId);

        if (!Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->makeDirectory($relativePath);
        }
        return $relativePath;
    }
}
