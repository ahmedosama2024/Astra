<?php

namespace Tests\Feature\Website;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    public function test_can_get_all_categories()
    {
        $categories = Category::factory()->count(5)->create();
        $response = $this->getJson(route('categories.index'));
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
        $category = Category::factory()->create();
        $response = $this->getJson(route('categories.show', $category->id));
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
}
