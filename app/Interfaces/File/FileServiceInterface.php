<?php

namespace App\Interfaces\File;

use Illuminate\Http\UploadedFile;

interface FileServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return void
     */
    public function store(UploadedFile $file): void;
}
