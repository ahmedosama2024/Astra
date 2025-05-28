<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'string',
                'min:3',
                'max:50',
                Rule::unique('products', 'name')->ignore($this->product->id)
            ],
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'sometimes|string|min:10|max:2000',
            'categories' => 'sometimes|array|min:1|max:5',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function updateProduct(): Product
    {
        return DB::transaction(function () {
            if ($this->exists('image')) {
                Storage::disk('public')->delete($this->product->image);

            }

            $this->product->update([
                'name' => $this->exists('name') ? $this->name : $this->product->name,
                'image' => $this->exists('image') ? $this->image->store('products', 'public') : $this->product->image,
                'description' => $this->exists('description') ? $this->description : $this->product->description,
            ]);
            if ($this->exists('categories')) {
                $this->product->categories()->sync($this->categories);
            }

            return $this->product->refresh();
        });
    }
}
