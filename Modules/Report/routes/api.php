<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;
use Modules\Report\Http\Controllers\ReportSaleItemController;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('reports', ReportController::class)->names('report');
    Route::apiResource('report_sale_items', ReportSaleItemController::class)->names('report_sale_item');
});
