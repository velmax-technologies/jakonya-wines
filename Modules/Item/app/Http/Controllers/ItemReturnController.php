<?php

namespace Modules\Item\Http\Controllers;

use App\Models\ItemReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Modules\Item\Http\Requests\ItemReturnRequest;
use Modules\Item\Transformers\ItemReturnResource;

class ItemReturnController extends Controller
{
    use ApiResponseFormatTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('item::index');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemReturnRequest $request) {
        $request->validated();

        try {
            // Here you would handle the logic for storing an item return
            $itemReturn = ItemReturn::create($request->all());

            return (new ItemReturnResource($itemReturn))
                ->additional($this->preparedResponse('store'));
        } catch (\Exception $e) {
            return response()->json([
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
        return view('item::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('item::edit');
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
