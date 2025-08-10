<?php

use Illuminate\Support\Facades\Route;
use Modules\Sale\Http\Controllers\SaleController;
use Modules\Sale\Http\Controllers\ItemSaleController;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('sales', SaleController::class)->names('sale');
    Route::apiResource('item_sales', ItemSaleController::class)->names('item_sale');
});
