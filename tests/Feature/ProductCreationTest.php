<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     *
     *
     * @return void
     */
    public function test_product_creation()
    {
        $role = Role::first() ?: Role::create(['name' => 'admin']);

        $user = User::factory()->create([
            'role_id' => $role->id, 
        ]);

        Storage::fake('public');

        $productData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'brand' => $this->faker->word,
            'image' => $this->faker->image('public/storage/img', 640, 480, null, false),
        ];

        $this->actingAs($user);

        $response = $this->post(route('products.store'), $productData);

        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
            'brand' => $productData['brand'],
        ]);

        Storage::disk('public')->assertExists('products/' . basename($productData['image']));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product succesvol toegevoegd!');
    }
}
