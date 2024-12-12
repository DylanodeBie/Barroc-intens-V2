<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin']);

        $this->user = User::factory()->create([
            'role_id' => $role->id,
        ]);
    }

    /**
     * Test Happy Path: Create a valid product.
     */
    public function test_happy_path_product_creation()
    {
        Storage::fake('public');

        $productData = [
            'name' => 'Espresso Machine',
            'description' => 'A high-quality espresso machine',
            'price' => 249.99,
            'brand' => 'CoffeeCo',
            'stock' => 10,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Product aangemaakt');

        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
            'brand' => $productData['brand'],
        ]);
    }

    /**
     * Edge Case 1: Create a product with a zero stock value.
     */
    public function test_edge_case_zero_stock()
    {
        $productData = [
            'name' => 'Test Zero Stock',
            'description' => 'Product with zero stock',
            'price' => 199.99,
            'brand' => 'TestBrand',
            'stock' => 0,
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Product aangemaakt');

        $this->assertDatabaseHas('products', ['stock' => 0]);
    }

    /**
     * Edge Case 2: Create a product with the maximum allowed price.
     */
    public function test_edge_case_max_price()
    {
        $productData = [
            'name' => 'Max Price Product',
            'description' => 'Product with maximum price',
            'price' => 9999.99,
            'brand' => 'LuxuryBrand',
            'stock' => 5,
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Product aangemaakt');

        $this->assertDatabaseHas('products', ['price' => 9999.99]);
    }

    /**
     * Extreme Case 1: Create a product with an extremely long name.
     */
    public function test_extreme_case_long_name()
    {
        $longName = str_repeat('A', 256);

        $productData = [
            'name' => $longName,
            'description' => 'Product with extremely long name',
            'price' => 149.99,
            'brand' => 'ExtremeBrand',
            'stock' => 2,
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors('name');
    }

    /**
     * Extreme Case 2: Create a product with a negative price.
     */
    public function test_extreme_case_negative_price()
    {
        $productData = [
            'name' => 'Negative Price Product',
            'description' => 'Product with negative price',
            'price' => -50.00, 
            'brand' => 'BadBrand',
            'stock' => 3,
        ];

        // Zorg ervoor dat de test faalt bij het aanmaken van een product met een negatieve prijs
        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors('price'); 
    }

    /**
     * Empty Field Case: Ensure fields cannot be empty.
     */
    public function test_extreme_case_empty_field_validation()
    {
        $productData = [
            'name' => '',
            'description' => '',
            'price' => '',
            'brand' => '',
            'stock' => '',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors([
                'name',
                'description',
                'price',
                'brand',
                'stock',
            ]);
    }
}