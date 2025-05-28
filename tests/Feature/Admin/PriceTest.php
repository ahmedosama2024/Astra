<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Price;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PriceTest extends TestCase
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

    public function test_can_get_all_prices()
    {
        Permission::create(['name' => 'prices-read']);
        $this->role->givePermission('prices-read');

        $product = Product::factory()->create();
        $prices = Price::factory(5)->create(['product_id' => $product->id]);
        $response = $this->getJson(route('admin.prices.index'));
        $response->assertOk()
                ->assertJsonCount(7, 'data')
                ->assertExactJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'price',
                            'start_date',
                            'end_date',
                            'product_id',
                            'created',
                            'updated',
                        ],
                    ]
                ]);
    }

    public function test_can_get_single_price()
    {
        Permission::create(['name' => 'prices-read']);
        $this->role->givePermission('prices-read');

        $product = Product::factory()->create();
        $price = Price::factory()->create(['product_id' => $product->id]);
        $response = $this->getJson(route('admin.prices.show', $price->id));
        $response->assertOk()
                ->assertExactJsonStructure([
                    'price' => [
                        'id',
                        'price',
                        'start_date',
                        'end_date',
                        'product_id',
                        'created',
                        'updated',
                    ]
                ]);
    }

    public function test_can_create_price()
    {
        Permission::create(['name' => 'prices-create']);
        $this->role->givePermission('prices-create');

        $product = Product::factory()->create();
        $data = [
            'price' => 100,
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(30)->format('Y-m-d H:i:s'),
            'product' => $product->id,
        ];
        $response = $this->postJson(route('admin.prices.store'), $data);
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
                    'price' => [
                        'id',
                        'price',
                        'start_date',
                        'end_date',
                        'product_id',
                        'created',
                        'updated',
                    ]
                ]);
    }

    public function test_can_update_price()
    {
        Permission::create(['name' => 'prices-update']);
        $this->role->givePermission('prices-update');

        $product = Product::factory()->create();
        $price = Price::factory()->create(['product_id' => $product->id]);
        $data = [
            'price_value' => 200,
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(30)->format('Y-m-d H:i:s'),
            'product' => $product->id,
        ];
        $response = $this->putJson(route('admin.prices.update', $price->id), $data);
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
                    'price' => [
                        'id',
                        'price',
                        'start_date',
                        'end_date',
                        'product_id',
                        'created',
                        'updated',
                    ]
                ]);
    }

    public function test_can_delete_price()
    {
        Permission::create(['name' => 'prices-delete']);
        $this->role->givePermission('prices-delete');

        $product = Product::factory()->create();
        $price = Price::factory()->create(['product_id' => $product->id]);
        $response = $this->deleteJson(route('admin.prices.destroy', $price->id));
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
                ]);
        $this->assertModelMissing($price);
    }
}
