<?php

declare(strict_types=1);

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\StoreFileRequest;
use App\Interfaces\File\FileServiceInterface;
use Illuminate\View\View;

final class FileController extends Controller
{
    public function list(
        FileServiceInterface $fileService
    ): View
    {
        $files = $fileService->getFilesList();
        return view('file.list', compact('files'));
    }

    public function upload(): View
    {
        return view('file.upload');
    }

    public function store(
        StoreFileRequest $request,
        FileServiceInterface $fileService
    ): void
    {
        $fileService->store($request->validated()['file']);
    }

    public function delete(
        int $fileId,
        FileServiceInterface $fileService
    ): void
    {
        $fileService->delete($fileId);
    }
}
