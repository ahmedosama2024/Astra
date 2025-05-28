<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    ## Relations

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    ## Other methods

    public function remove(): bool
    {
        $products = $this->products()->get();
        $this->products()->detach();
        $this->delete();
        foreach ($products as $product) {
            if ($product->categories()->count() == 0) {
                $product->delete();
            }
        }
        return true;
    }
}
