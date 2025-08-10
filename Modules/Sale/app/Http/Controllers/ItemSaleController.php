<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\ItemSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Modules\Sale\Http\Requests\ItemSaleRequest;
use Modules\Sale\Transformers\ItemSaleResource;

class ItemSaleController extends Controller
{
    use ApiResponseFormatTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function store(ItemSaleRequest $request) {
        $request->validated();

        try {
        
            $itemSale = ItemSale::create($request->all());

            return (new ItemSaleResource($itemSale))
                ->additional($this->preparedResponse('store'));
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
                'status' => 'failed'
            ], 400); 
        }   
    }

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
