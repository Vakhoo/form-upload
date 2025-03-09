<?php

use App\Http\Controllers\File\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('file.upload');
});

Route::group(
    [
        'controller' => FileController::class,
        'prefix' => 'files'
    ],
    function () {
        Route::get('/', 'upload')->name('file.upload');
        Route::post('/upload', 'store')->name('file.store');
        Route::get('/list', 'list')->name('file.list');
        Route::delete('/{fileId}', 'delete')->name('file.delete');
    }
);
