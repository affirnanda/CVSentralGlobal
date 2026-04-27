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
            'image' => UploadedFile::fake()->image('product.jpg'),
        ]);

        $response->assertRedirect(route('welcome'));

        $this->assertDatabaseHas('products', [
            'name' => 'Produk Test',
            'price' => 10000,
        ]);
    }

   public function test_can_update_product()
{
    Storage::fake('public');

    $user = $this->adminUser();

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->patch(
    route('admin.products.update', ['product' => $product->id]),
    [
        'name' => 'Produk Update',
        'description' => 'Deskripsi update',
        'price' => 20000,
        'image' => UploadedFile::fake()->image('new.jpg'), // 🔥 FIX
    ]
);

    $response->assertStatus(302);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Produk Update',
    ]);
}

public function test_can_delete_product()
{
    $user = $this->adminUser();

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->post(
        route('admin.products.destroy', ['product' => $product->id]),
        [
            '_method' => 'DELETE',
        ]
    );

    $response->assertStatus(302);

    $this->assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
}

public function test_cannot_create_product_with_empty_input()
{
    $user = $this->adminUser();

    $response = $this->actingAs($user)->post(route('admin.products.store'), []);

    $response->assertSessionHasErrors([
        'name',
        'description',
        'price',
    ]);

    $this->assertDatabaseCount('products', 0);
}

public function test_cannot_create_product_with_negative_price()
{
    $user = $this->adminUser();

    $response = $this->actingAs($user)->post(route('admin.products.store'), [
        'name' => 'Produk Test',
        'description' => 'Deskripsi',
        'price' => -1000,
    ]);

    $response->assertSessionHasErrors('price');

    $this->assertDatabaseMissing('products', [
        'name' => 'Produk Test',
    ]);
}

public function test_cannot_create_product_with_invalid_image()
{
    $user = $this->adminUser();

    $response = $this->actingAs($user)->post(route('admin.products.store'), [
        'name' => 'Produk Test',
        'description' => 'Deskripsi',
        'price' => 10000,
        'image' => UploadedFile::fake()->create('file.pdf', 100),
    ]);

    $response->assertSessionHasErrors('image');

    $this->assertDatabaseMissing('products', [
        'name' => 'Produk Test',
    ]);
}

public function test_cannot_update_product_with_invalid_data()
{
    $user = $this->adminUser();

    $product = Product::factory()->create();

    $response = $this->actingAs($user)->patch(
        route('admin.products.update', ['product' => $product->id]),
        [
            'name' => '',
            'description' => '',
            'price' => -500,
        ]
    );

    $response->assertSessionHasErrors([
        'name',
        'description',
        'price',
    ]);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $product->name,
    ]);
}

}