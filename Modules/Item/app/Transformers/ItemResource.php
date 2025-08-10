<?php

namespace Modules\Item\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->stocks->sum('quantity') ?? 0,
            'cost' => $this->costs()->latest()->first()->cost ?? 0,
            'wholesale_price' => $this->item_prices()->withAnyTags(['wholesale'], 'priceTag')->latest()->first()->price ?? 0,
            'retail_price' => $this->item_prices()->withAnyTags(['retail'], 'priceTag')->latest()->first()->price ?? 0,
            'tags' => $this->tags->pluck('name'),
        ];
    }
}
