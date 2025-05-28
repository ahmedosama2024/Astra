<?php

namespace App\Http\Requests\Admin;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;

class PriceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price_value' => 'sometimes|numeric|min:1|max:10000',
            'start_date' => 'sometimes|date|after_or_equal:now|date_format:Y-m-d H:i:s',
            'end_date' => 'sometimes|date|after:start_date|date_format:Y-m-d H:i:s',
            'product' => 'sometimes|exists:products,id'
        ];
    }

    public function updatePrice(): Price
    {
        $this->price->update([
            'price' => $this->exists('price_value') ? $this->price_value : $this->price->price,
            'start_date' => $this->exists('start_date') ? $this->start_date : $this->price->start_date,
            'end_date' => $this->exists('end_date') ? $this->end_date : $this->price->end_date,
            'product_id' => $this->exists('product') ? $this->product : $this->price->product_id,
        ]);

        return $this->price->refresh();
    }
}
