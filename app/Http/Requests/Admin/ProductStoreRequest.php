<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50|unique:products,name',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|min:10|max:2000',
            'categories' => 'required|array|min:1|max:5',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function storeProduct(): Product
    {
        return DB::transaction(function () {
            $product = Product::create([
            'name' => $this->name,
            'image' => $this->image->store('products', 'public'),
            'description' => $this->description,
            ]);
            $product->categories()->sync($this->categories);
        
            return $product->refresh();
        });
    }
}
