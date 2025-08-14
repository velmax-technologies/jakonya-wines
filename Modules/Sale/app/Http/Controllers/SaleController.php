<?php

namespace Modules\Sale\Http\Controllers;

use Exception;
use App\Models\Sale;
use App\Models\ItemSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
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
        $sales = Sale::all();

    $sales = QueryBuilder::for(Sale::class)
        ->allowedFilters(['user.name', 'customer.name'])
        ->get();


        
        return SaleResource::collection($sales)
            ->additional($this->preparedResponse('index'));
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
        try {
            $sale = Sale::findOrFail($id);
            return (new SaleResource($sale))
                ->additional($this->preparedResponse('show'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404, null);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, $id)
    {
        $request->validated();
        
        try {
            DB::beginTransaction();

            // Find the sale record
            $sale = Sale::findOrFail($id);


            // Completed sale status cannot be changed to any other status
            if($sale->status == 'completed' && $request->status != 'completed') {
                return $this->errorResponse('Cannot change status from completed to another status', 400, null);
            }

            // Cancelled sale status cannot be changed to any other status
            if($sale->status == 'cancelled' && $request->status != 'cancelled') {
                return $this->errorResponse('Cannot change status from cancelled to another status', 400, null);
            }



            // Canecel the sale if the status is set to 'cancelled'
            if ($request->status == 'cancelled') {
                $sale->status = 'cancelled';
                
                // Update item sales
                foreach ($sale->sale_items as $saleItem) {
                    $itemSale = ItemSale::where('item_id', $saleItem->item_id)->first();

                    if ($itemSale) {
                        $itemSale->quantity -= $saleItem->quantity;
                        $itemSale->save();
                    }
                }
            
            
            }
            else
                {
                // Update the sale record
                $sale->update($request->all());

                // Update item sales
                foreach ($sale->sale_items as $saleItem) {
                    $itemSale = ItemSale::where('item_id', $saleItem->item_id)->first();

                    if ($itemSale) {
                        $itemSale->quantity -= $saleItem->quantity;
                        $itemSale->save();
                    }
                }

                // Update or create new sale items
                $sale->sale_items()->delete();
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
            }
           

            // Commit the transaction
            DB::commit(); 
            return(new SaleResource($sale))
                ->additional($this->preparedResponse('update'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 400, null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Find the sale record
            $sale = Sale::findOrFail($id);

            // If the sale is completed, we cannot delete it
            if ($sale->status == 'completed') {
                return $this->errorResponse('Cannot delete a completed sale', 400, null);
            }

            // update item sales
            foreach ($sale->sale_items as $saleItem) {
                $itemSale = ItemSale::where('item_id', $saleItem->item_id)->first();

                if ($itemSale) {
                    $itemSale->quantity -= $saleItem->quantity;
                    $itemSale->save();
                }
            }

            // Delete the sale items
            $sale->sale_items()->delete();

            // Delete the sale record
            $sale->delete();

            // Commit the transaction
            DB::commit(); 
            return (new SaleResource($sale))
                ->additional($this->preparedResponse('destroy'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 400, null);
        }
    }
}

