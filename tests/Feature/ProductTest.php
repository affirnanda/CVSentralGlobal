<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
{
    parent::setUp();

    Gate::define('manage products', function () {
        return true;
    });
}

    protected function adminUser()
    {
        return User::factory()->create();
    }

    public function test_can_view_products_page()
    {
        Product::factory()->count(5)->create();

        $response = $this->get(route('katalog.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    public function test_can_create_product()
    {
        Storage::fake('public');

        $user = $this->adminUser();

        $response = $this->actingAs($user)->post(route('admin.products.store'), [
            'name' => 'Produk Test',
            'description' => 'Deskripsi produk',
            'price' => 10000,
            'rental_price' => 5000,
            'stock' => 10,
            'image' => UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('welcome'));

        $this->assertDatabaseHas('products', [
            'name' => 'Produk Test',
            'price' => 10000,
        ]);
    }

}