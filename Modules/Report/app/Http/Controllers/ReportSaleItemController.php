<?php

namespace Modules\Report\Http\Controllers;

use App\Models\Report;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use App\Models\ReportSaleItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseFormatTrait;
use Modules\Report\Transformers\ReportResource;
use Modules\Report\Transformers\ReportSaleItemResource;

class ReportSaleItemController extends Controller
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $reportData = $request->only(['title', 'description', 'type', 'report_date']);
            $reportData['user_id'] = Auth::user()->id; // Assuming the user is authenticated

            $report = Report::create($reportData);

            // generating sale item report
            $saleItems = SaleItem::all();

            foreach ($saleItems as $saleItem) {
                $reportSaleItem = ReportSaleItem::where(['report_id' => $report->id, 'item_id' => $saleItem->id])->first();
                if ($reportSaleItem) {
                    $reportSaleItem->quantity += $saleItem->quantity;
                    $reportSaleItem->total += $saleItem->line_total;
                    $reportSaleItem->save();
                } else {
                    ReportSaleItem::create([
                        'report_id' => $report->id,
                        'item_id' => $saleItem->id,
                        'quantity' => $saleItem->quantity,
                        'price' => $saleItem->price,
                        'total' => $saleItem->line_total,
                    ]);
                }
            }

            return (new ReportResource($report));


            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 400, null);
        }

        


       // create a report
       
        return response()->json([
            'message' => 'Report created successfully',
            'report' => $report
        ], 201);
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
