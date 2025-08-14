<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Traits\ApiResponseFormatTrait;
use Modules\Sale\Transformers\SaleItemResource;
use Modules\Sale\Transformers\SaleItemSumResource;

class SaleItemController extends Controller
{
    use ApiResponseFormatTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $saleItems = QueryBuilder::for(SaleItem::class)
            ->allowedFilters(['item_id', 'item.name']) // Allow filtering by item_id and item's name
            ->get();
       
        return (SaleItemResource::collection($saleItems))
            ->additional($this->preparedResponse('index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
