<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function test_can_get_all_categories()
    {
        Permission::firstOrCreate(['name' => 'categories-read']);
        $this->role->givePermission('categories-read');

        $categories = Category::factory()->count(5)->create();
        $response = $this->getJson(route('admin.categories.index'));
        $response->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertExactJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created',
                        'updated',
                    ]
                ],
            ]);
    }

    public function test_can_get_single_category()
    {
        Permission::firstOrCreate(['name' => 'categories-read']);
        $this->role->givePermission('categories-read');

        $category = Category::factory()->create();
        $response = $this->getJson(route('admin.categories.show', $category->id));
        $response->assertOk()
                ->assertExactJsonStructure([
                    'category' => [
                        'id',
                        'name',
                        'created',
                        'updated',
                    ]
                ]);
    }

    public function test_can_update_category()
    {
        Permission::firstOrCreate(['name' => 'categories-update']);
        $this->role->givePermission('categories-update');

        $category = Category::factory()->create();
        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->putJson(route('admin.categories.update', $category->id), $data);
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message',
                    'category' => [
                        'id',
                        'name',
                        'created',
                        'updated',
                    ]
                ]);
    }

    public function test_can_delete_category()
    {
        Permission::firstOrCreate(['name' => 'categories-delete']);
        $this->role->givePermission('categories-delete');

        $category = Category::factory()->create();
        $response = $this->deleteJson(route('admin.categories.destroy', $category->id));
        $response->assertOk()
                ->assertExactJsonStructure([
                    'message'
                ]); 
        $this->assertModelMissing($category);
    }
}
