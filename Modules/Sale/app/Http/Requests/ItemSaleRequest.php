<?php

namespace Modules\Sale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemSaleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->isMethod('post')) {
            $rules = [
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required|integer|min:1',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'item_id' => 'sometimes|required|exists:items,id',
                'quantity' => 'sometimes|required|integer|min:1',
                'sale_id' => 'sometimes|required|exists:sales,id',
            ];
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
