<?php

namespace App\Services\File;

use App\Enums\File\FileFolderEnum;
use App\Helpers\File\UploadHelper;
use App\Helpers\PaginationHelper;
use App\Interfaces\File\FileServiceInterface;
use App\Models\File\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return void
     * @throws FileNotFoundException
     */
    public function store(UploadedFile $file): void {
        UploadHelper::uploadFile(
            file: $file,
            fileFolderEnum: FileFolderEnum::CONVEY_THIS_FILES
        );
    }

    public function getFilesList(): LengthAwarePaginator
    {
        return File::orderBy('id', 'desc')->paginate(PaginationHelper::getPerPage());
    }

    public function delete(int $id): void
    {
        $file = File::where('id', $id)->firstOrFail();

        Storage::disk('public')->delete($file->publicPath);

        $file->delete();
    }
}
