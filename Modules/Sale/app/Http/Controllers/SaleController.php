<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\Sale;
use App\Models\ItemSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseFormatTrait;
use Modules\Sale\Http\Requests\SaleRequest;
use Modules\Sale\Transformers\SaleResource;

class SaleController extends Controller
{
    use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();

            // get the authenticated user
            $user = Auth::user();

            // merge the user_id into the request data
            $request->merge(['user_id' => $user->id]);

            // Create the sale record
            $sale = Sale::create($request->all());

            // Process sale items
            $sale->sale_items()->createMany(
                collect($request->sale_items)->map(function ($item) use ($sale) {
                    return [
                        'item_id' => $item['item_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'line_total' => $item['price'] * $item['quantity'],
                        'sale_id' => $sale->id,
                    ];
                })->toArray()
            );

            // update or create item sale
            foreach ($sale->sale_items as $saleItem) {
                $itemSale = ItemSale::where('item_id', $saleItem->item_id)->first();

                if ($itemSale) {
                    $itemSale->quantity += $saleItem->quantity;
                    $itemSale->save();
                } else {
                    ItemSale::create([
                        'item_id' => $saleItem->item_id,
                        'quantity' => $saleItem->quantity,
                    ]);
                }

            }

            // Commit the transaction
            DB::commit(); 
            return(new SaleResource($sale))
                ->additional($this->preparedResponse('store'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 400, null);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        return response()->json([]);
    }
}
