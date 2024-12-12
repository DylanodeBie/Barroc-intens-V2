<?php

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class ProductEmptyTest extends TestCase
{
    protected $user;
    
    public function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin']);

        $this->user = User::factory()->create([
            'role_id' => $role->id,
        ]);
    
    }
    public function test_name_field_empty()
    {
        $productData = [
            'name' => '',
            'description' => 'Sample description',
            'price' => '19.99',
            'brand' => 'Sample Brand',
            'stock' => '10',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors(['name']);
    }

    public function test_description_field_empty()
    {
        $productData = [
            'name' => 'Sample Product',
            'description' => '',
            'price' => '19.99',
            'brand' => 'Sample Brand',
            'stock' => '10',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors(['description']);
    }

    public function test_price_field_empty()
    {
        $productData = [
            'name' => 'Sample Product',
            'description' => 'Sample description',
            'price' => '',
            'brand' => 'Sample Brand',
            'stock' => '10',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors(['price']);
    }

    public function test_brand_field_empty()
    {
        $productData = [
            'name' => 'Sample Product',
            'description' => 'Sample description',
            'price' => '19.99',
            'brand' => '',
            'stock' => '10',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors(['brand']);
    }

    public function test_stock_field_empty()
    {
        $productData = [
            'name' => 'Sample Product',
            'description' => 'Sample description',
            'price' => '19.99',
            'brand' => 'Sample Brand',
            'stock' => '',
        ];

        $this->actingAs($this->user)
            ->post(route('products.store'), $productData)
            ->assertSessionHasErrors(['stock']);
    }
}