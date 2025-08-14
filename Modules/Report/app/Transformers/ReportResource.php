<?php

namespace Modules\Report\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {

        //$resource = [];
        $report =  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'report_date' => $this->report_date,
            'user_name' => $this->user->name ?? null,
        ];

        if($this->has('report_sale_items')) {
            $report['report_sale_items'] = ReportSaleItemResource::collection($this->report_sale_items);
        }

        return $report;
    }
}
