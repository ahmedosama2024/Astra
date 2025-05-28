<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
    ];

    ## Relations

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    ## Getters and Setters

    public function getPriceAttribute()
    {
        $date = now();
        return $this->prices
        ->where('start_date', '<=', $date)
        ->where(function ($query) use ($date) {
            return $query->where('end_date', '>=', $date)
                        ->orWhereNull('end_date');
        })
        ->sortByDesc('start_date')
        ->first();
    }

    ## Other methods

    public function remove(): bool
    {
        $this->categories()->detach();
        $this->prices()->delete();
        $this->delete();
        return true;
    }
}
