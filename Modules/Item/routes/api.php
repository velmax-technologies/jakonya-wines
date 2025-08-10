<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\Http\Controllers\ItemController;
use Modules\Item\Http\Controllers\ItemReturnController;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('items', ItemController::class)->names('item');
    Route::apiResource('item_returns', ItemReturnController::class)->names('item_return');
    
});
