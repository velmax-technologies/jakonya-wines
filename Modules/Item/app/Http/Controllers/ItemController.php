<?php

namespace Modules\Item\Http\Controllers;

use App\Models\Item;
use App\Enums\Messages;
use App\Enums\ApiStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Modules\Item\Http\Requests\ItemRequest;
use Modules\Item\Transformers\ItemResource;

class ItemController extends Controller
{
        use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return (ItemResource::collection($items))->additional($this->preparedResponse('index'));

    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request) {
        $request->validated();

        DB::beginTransaction();
        try {
        $item = Item::create($request->all());

        // Attach tags if provided
        if ($request->has('tags')) {
            $tags = array_filter(array_map('trim',  $request->input('tags')));
            $item->syncTagsWithType($tags, 'itemTag');
        }

       

        // stock
        if( $request->has('qty')) {
            $stock = $item->stocks()->create([
                'quantity' => $request->input('qty'),
                'note' => $request->input('note', 'initial stock'),
            ]);

            // stock cost
            if ($request->has('cost')) {
                $item->costs()->create([
                    'cost' => $request->input('cost'),
                    'stock_id' => $stock->id,
                ]);
            }

            // retail price
            if ($request->has('retail') && !empty($request->input('retail'))) {
                $item->item_prices()->create([
                    'price' => $request->input('retail'),
                ])->attachTag('retail', 'priceTag');
            }

            // wholesale price
            if ($request->has('wholesale') && !empty($request->input('wholesale'))) {
                $item->item_prices()->create([
                    'price' => $request->input('wholesale'),
                ])->attachTag('wholesale', 'priceTag');
            }
        }

        

        DB::commit();
        return (new ItemResource($item))
            ->additional($this->preparedResponse('store'))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);   
        } catch (\Exception $e) {
            DB::rollBack();
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
