<?php

namespace App\Http\Requests\Admin;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;

class PriceStoreRequest extends FormRequest
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
            'price' => 'required|numeric|min:1|max:10000',
            'start_date' => 'required|date|after_or_equal:now|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i:s',
            'product' => 'required|exists:products,id',
        ];
    }

    public function storePrice(): Price
    {
        return Price::create([
            'price' => $this->price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'product_id' => $this->product,
        ]);
    }
}
