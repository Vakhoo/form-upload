<?php

namespace App\Helpers\File;

use App\Enums\File\FileFolderEnum;
use App\Models\File\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File as LaravelFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHelper
{
    /**
     * @param UploadedFile $file
     * @param FileFolderEnum $fileFolderEnum
     * @param string|null $hash
     * @return File
     * @throws FileNotFoundException
     */
    public static function uploadFile(UploadedFile $file, FileFolderEnum $fileFolderEnum, string $hash = null): File
    {
        $hash = $hash ?: sha1_file($file->getRealPath());
        $folder = self::getFileFolder($fileFolderEnum);
        $filename = self::getUniqueFilename($file->getClientOriginalName());
        $extension = Str::lower($file->guessExtension());
        $realpath = sprintf('%s%s%s.%s', trim($folder, '/\\'), DIRECTORY_SEPARATOR, $filename, $extension);
        Storage::disk('public')->put($realpath, $file->get());
        /** @var File $result */
        $result = File::create([
            'path' => Arr::get(pathinfo($realpath), 'dirname'),
            'extension' => $extension,
            'filename' => $filename,
            'mime' => $file->getMimeType(),
            'size' => intval($file->getSize() / 1024),
            'hash' => $hash,
        ]);
        return $result;
    }

    /**
     * @param FileFolderEnum $folderEnum
     * @return string
     */
    public static function getFileFolder(FileFolderEnum $folderEnum): string
    {
        $folder = $folderEnum->value;
        if (!LaravelFile::exists(public_path($folder))) {
            LaravelFile::makeDirectory(public_path($folder), 0o700, true);
        }
        return $folder;
    }

    /**
     * @param string $originalName
     * @return string
     */
    public static function getUniqueFilename($originalName = ''): string
    {
        do {
            $filename = $originalName . uniqid(Str::random(7));
        } while (File::where('filename', $filename)->count() > 0);
        return $filename;
    }
}
