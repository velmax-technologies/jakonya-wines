<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManager\Http\Controllers\ExcelControlerController;
use Modules\FileManager\Http\Controllers\ExcelController;
use Modules\FileManager\Http\Controllers\FileManagerController;

Route::middleware(['auth:api'])->group(function () {
    Route::post('file_manager/upload', [FileManagerController::class, 'upload']);
    Route::post('file_manager/data/import', [ExcelController::class, 'import']);
});
