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
     * Test de productaanmaakfunctionaliteit.
     *
     * @return void
     */
    public function test_product_creation()
    {
        // Maak een rol aan als deze nog niet bestaat
        $role = Role::first() ?: Role::create(['name' => 'admin']);

        // Maak een gebruiker aan met een geldig role_id
        $user = User::factory()->create([
            'role_id' => $role->id,  // Zorg ervoor dat de gebruiker een geldig role_id krijgt
        ]);

        // Fake de opslag voor productafbeeldingen
        Storage::fake('public');

        // De gegevens voor het nieuwe product
        $productData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'brand' => $this->faker->word,
            'image' => $this->faker->image('public/storage/img', 640, 480, null, false),
        ];

        // Log de gebruiker in
        $this->actingAs($user);

        // Voer de POST-aanvraag uit naar de route voor het aanmaken van een product
        $response = $this->post(route('products.store'), $productData);

        // Controleer of de productgegevens succesvol zijn opgeslagen in de database
        $this->assertDatabaseHas('products', [
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
            'brand' => $productData['brand'],
        ]);

        // Controleer of de afbeelding is opgeslagen in de juiste directory
        Storage::disk('public')->assertExists('products/' . basename($productData['image']));

        // Controleer of de gebruiker wordt doorgestuurd naar de productenpagina na het aanmaken
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product succesvol toegevoegd!');
    }
}
