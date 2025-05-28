<?php

namespace Tests\Feature\Website;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    public function test_can_get_all_products()
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(5)->create();
        $category->products()->attach($products);
        $response = $this->getJson(route('categories.products.index', $category->id));

        $response->assertOk()
                ->assertJsonCount(5, 'data')
                ->assertExactJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'image',
                            'description',
                            'price',
                            'categories',
                            'created',
                            'updated',
                        ]
                    ],
                    'links',
                    'meta',
                ]);
    }

    public function test_can_get_single_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product);
        $response = $this->getJson(route('categories.products.show', [$category->id, $product->id]));
        $response->assertOk()
                ->assertJsonStructure([
                    'product' => [
                        'id',
                        'name',
                        'image',
                        'description',
                        'price',
                        'categories',
                        'created',
                        'updated',
                    ]
                ]);
    }
}
