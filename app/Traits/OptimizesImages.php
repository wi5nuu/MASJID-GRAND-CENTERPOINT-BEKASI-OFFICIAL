<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait OptimizesImages
{
    private function optimizeImage(UploadedFile $file, string $folder = 'uploads', int $maxWidth = 1200, int $quality = 80): string
    {
        $originalPath = $file->getRealPath();
        $info = getimagesize($originalPath);

        if (!$info) {
            return $file->store($folder, 'public');
        }

        $w = $info[0];
        $h = $info[1];
        $mimeType = $info['mime'];

        $src = match ($mimeType) {
            'image/png' => $this->createPng($originalPath),
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($originalPath),
            default => null,
        };

        if (!$src) {
            return $file->store($folder, 'public');
        }

        $newW = $w;
        $newH = $h;
        if ($w > $maxWidth) {
            $ratio = $maxWidth / $w;
            $newW = $maxWidth;
            $newH = (int)($h * $ratio);
        }

        if ($newW !== $w || $newH !== $h) {
            $resized = imagecreatetruecolor($newW, $newH);
            if ($mimeType === 'image/png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);
            imagedestroy($src);
            $src = $resized;
        }

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $name . '_' . time() . '.webp';
        $savedPath = $folder . '/' . $fileName;
        $fullPath = Storage::disk('public')->path($savedPath);

        imagewebp($src, $fullPath, $quality);
        imagedestroy($src);

        return $savedPath;
    }

    private function createPng(string $path)
    {
        $src = imagecreatefrompng($path);
        imagealphablending($src, false);
        imagesavealpha($src, true);
        return $src;
    }
}
