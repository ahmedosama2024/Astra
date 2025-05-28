<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public User $user;
    public Role $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::firstOrCreate(['name' => 'admin']);
        $this->user = User::factory()->create();
        $this->user->addRole($this->role);
        $this->actingAs($this->user, 'api');
    }

    public function test_can_get_all_products()
    {
        Permission::firstOrCreate(['name' => 'products-read']);
        $this->role->givePermission('products-read');

        $category = Category::factory()->create();
        $products = Product::factory()->count(5)->create();
        $category->products()->attach($products);
        $response = $this->getJson(route('admin.categories.products.index', $category->id));

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
        Permission::firstOrCreate(['name' => 'products-read']);
        $this->role->givePermission('products-read');

        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product);
        $response = $this->getJson(route('admin.categories.products.show', [$category->id, $product->id]));
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

    public function test_can_create_product()
    {
        Permission::firstOrCreate(['name' => 'products-create']);
        $this->role->givePermission('products-create');

        $category = Category::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'image' => UploadedFile::fake()->image('category.jpg'),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
        $response = $this->postJson(route('admin.categories.products.store', $category->id), $data);
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
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

    public function test_can_update_product()
    {
        Permission::firstOrCreate(['name' => 'products-update']);
        $this->role->givePermission('products-update');

        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product);
        $data = [
            'name' => $this->faker->name,
            'image' => UploadedFile::fake()->image('category.jpg'),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
        $response = $this->putJson(route('admin.categories.products.update', [$category->id, $product->id]), $data);
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
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

    public function test_can_delete_product()
    {
        Permission::firstOrCreate(['name' => 'products-delete']);
        $this->role->givePermission('products-delete');

        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product);
        $response = $this->deleteJson(route('admin.categories.products.destroy', [$category->id, $product->id]));
        $response->assertOk()
                ->assertJsonStructure([
                    'message'
                ]);
        $this->assertModelMissing($product);
    }
}
