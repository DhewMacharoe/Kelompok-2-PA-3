<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HandlesPublicImageUploads
{
    protected function storeImageToPublic(UploadedFile $file, string $folder): string
    {
        $folder = trim(str_replace('\\', '/', $folder), '/');
        $destinationPath = base_path('images/' . $folder);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $fileName = now()->format('YmdHis') . '_' . Str::uuid() . '.' . $extension;

        $file->move($destinationPath, $fileName);

        return $folder . '/' . $fileName;
    }

    protected function deleteImageFromPublic(?string $relativePath): void
    {
        if (empty($relativePath) || Str::startsWith($relativePath, ['http://', 'https://'])) {
            return;
        }

        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');

        if (Str::startsWith($relativePath, 'images/')) {
            $relativePath = Str::after($relativePath, 'images/');
        }

        $absolutePath = base_path('images/' . $relativePath);

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}