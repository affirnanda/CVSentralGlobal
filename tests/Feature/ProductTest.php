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

    /** @test */
    public function test_pengguna_memasukkan_produk_ke_keranjang_dengan_jumlah_valid()
    {
        $product = Product::factory()->create([
            'name' => 'Produk A',
            'stock' => 10,
            'price' => 150000,
            'rental_price' => 50000,
        ]);

        $response = $this->post(route('keranjang.add', $product), ['qty' => 2]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Produk ditambahkan ke keranjang');
        $this->assertSame(2, session('keranjang.' . $product->id . '.qty'));
    }

    /** @test */
    public function test_pengguna_memasukkan_produk_ke_keranjang_dengan_jumlah_melebihi_stok()
    {
        $product = Product::factory()->create([
            'name' => 'Produk B',
            'stock' => 10,
            'price' => 150000,
            'rental_price' => 50000,
        ]);

        $response = $this->post(route('keranjang.add', $product), ['qty' => 15]);

        $response->assertRedirect();
        $this->assertNull(session('keranjang.' . $product->id . '.qty'));
    }

    /** @test */
    public function test_pengguna_memasukkan_produk_ke_keranjang_dengan_jumlah_bernilai_0()
    {
        $product = Product::factory()->create([
            'name' => 'Produk C',
            'stock' => 10,
            'price' => 150000,
            'rental_price' => 50000,
        ]);

        $response = $this->post(route('keranjang.add', $product), ['qty' => 0]);

        $response->assertSessionHasErrors(['qty']);
           $this->assertNull(session('keranjang.' . $product->id . '.qty'));

    }

    /** @test */
    public function test_pengguna_memasukkan_produk_ke_keranjang_dengan_input_non_integer()
    {
        $product = Product::factory()->create([
            'name' => 'Produk D',
            'stock' => 10,
            'price' => 150000,
            'rental_price' => 50000,
        ]);

        $response = $this->post(route('keranjang.add', $product), ['qty' => 'dua']);

        $response->assertSessionHasErrors(['qty']);
        $this->assertStringContainsString(
            'Silahkan isi jumlah produk yang ingin dipesan',
            session('errors')->get('qty')[0]
        );
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_data_lengkap()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->create('produk.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk A',
                'description' => 'Deskripsi lengkap produk A',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 50,
                'image' => $image,
            ]);

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', [
            'name' => 'Produk A',
            'stock' => 50,
            'price' => 150000,
        ]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_format_gambar_tidak_valid()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->create('produk.gif', 100, 'image/gif');

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Gagal',
                'description' => 'Deskripsi produk gagal',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
                'image' => $image,
            ]);

        $response->assertSessionHasErrors(['image']);
        $this->assertStringContainsString(
            'Format gambar yang diunggah tidak sesuai',
            session('errors')->get('image')[0]
        );
    }

    /** @test */
    public function test_admin_menambah_produk_tanpa_mengunggah_gambar()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk A',
                'description' => 'Deskripsi lengkap produk A',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 50,
            ]);

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', [
            'name' => 'Produk A',
            'stock' => 50,
            'price' => 150000,
        ]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_nama_produk_maksimal_100_karakter()
    {
        Storage::fake('public');

        $name = str_repeat('A', 100);

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => $name,
                'description' => 'Deskripsi produk valid',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', ['name' => $name]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_nama_produk_melebihi_100_karakter()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => str_repeat('A', 101),
                'description' => 'Deskripsi produk invalid',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertStringContainsString(
            'Nama produk terlalu panjang',
            session('errors')->get('name')[0]
        );
    }

    /** @test */
    public function test_admin_menambah_produk_tanpa_mengisi_nama_produk()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => '',
                'description' => 'Deskripsi produk kosong nama',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertStringContainsString(
            'Nama produk tidak boleh kosong',
            session('errors')->get('name')[0]
        );
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_stok_melebihi_batas_maksimum_integer()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Stok Besar',
                'description' => 'Deskripsi stok besar',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 2147483648,
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Jumlah stok melebihi batas', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_stok_bernilai_negatif()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Stok Negatif',
                'description' => 'Deskripsi stok negatif',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => -2,
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Stok tidak boleh bernilai 0 atau negatif', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_stok_non_integer()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Stok Non Integer',
                'description' => 'Deskripsi stok non integer',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 'budi',
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Stok harus berupa bilangan bulat', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_harga_melebihi_batas_maksimum_integer()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Harga Besar',
                'description' => 'Deskripsi harga besar',
                'price' => 2147483648,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Nominal harga beli terlalu besar', session('errors')->get('price')[0]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_harga_bernilai_0()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Harga Nol',
                'description' => 'Deskripsi harga nol',
                'price' => 0,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Harga beli tidak boleh bernilai 0 atau negatif', session('errors')->get('price')[0]);
    }

    /** @test */
    public function test_admin_menambah_produk_dengan_harga_non_integer()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Harga Non Integer',
                'description' => 'Deskripsi harga non integer',
                'price' => 'tono',
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Harga beli harus berupa angka', session('errors')->get('price')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_data_yang_valid()
    {
        $product = Product::factory()->create([
            'name' => 'Produk Lama',
            'description' => 'Deskripsi lama',
            'price' => 150000,
            'rental_price' => 50000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk A',
                'description' => 'Deskripsi diperbarui',
                'price' => 200000,
                'rental_price' => 60000,
                'stock' => 50,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produk A',
            'stock' => 50,
            'price' => 200000,
        ]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_format_gambar_tidak_valid()
    {
        $product = Product::factory()->create([
            'name' => 'Produk Lama',
            'description' => 'Deskripsi lama',
            'price' => 150000,
            'rental_price' => 50000,
            'stock' => 10,
        ]);

        $image = UploadedFile::fake()->create('produk.gif', 100, 'image/gif');

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk A',
                'description' => 'Deskripsi diperbarui',
                'price' => 200000,
                'rental_price' => 60000,
                'stock' => 50,
                'image' => $image,
            ]);

        $response->assertSessionHasErrors(['image']);
        $this->assertStringContainsString('Format gambar yang diunggah tidak sesuai', session('errors')->get('image')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_tanpa_mengunggah_gambar_baru()
    {
        $product = Product::factory()->create([
            'name' => 'Produk Lama',
            'description' => 'Deskripsi lama',
            'price' => 150000,
            'rental_price' => 50000,
            'stock' => 10,
            'image' => 'products/old.jpg',
        ]);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Baru',
                'description' => 'Deskripsi baru',
                'price' => 180000,
                'rental_price' => 55000,
                'stock' => 15,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produk Baru',
            'image' => 'products/old.jpg',
        ]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_nama_produk_valid_1_100_karakter()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'A',
                'description' => 'Deskripsi',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'A']);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_nama_produk_melebihi_100_karakter()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => str_repeat('A', 101),
                'description' => 'Deskripsi',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertStringContainsString('Nama produk terlalu panjang', session('errors')->get('name')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_tanpa_mengisi_nama_produk()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => '',
                'description' => 'Deskripsi',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertStringContainsString('Nama produk tidak boleh kosong', session('errors')->get('name')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_stok_melebihi_batas_maksimum_integer()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Stok Besar',
                'description' => 'Deskripsi stok besar',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 2147483648,
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Jumlah stok melebihi batas', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_stok_bernilai_0_atau_negatif()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Stok Nol',
                'description' => 'Deskripsi stok nol',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => -1,
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Stok tidak boleh bernilai 0 atau negatif', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_stok_non_integer()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Stok Non Integer',
                'description' => 'Deskripsi stok non integer',
                'price' => 150000,
                'rental_price' => 50000,
                'stock' => 'budi',
            ]);

        $response->assertSessionHasErrors(['stock']);
        $this->assertStringContainsString('Stok harus berupa bilangan bulat', session('errors')->get('stock')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_harga_melebihi_batas_maksimum_integer()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Harga Besar',
                'description' => 'Deskripsi harga besar',
                'price' => 2147483648,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Nominal harga beli terlalu besar', session('errors')->get('price')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_harga_bernilai_0_atau_negatif()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Harga Nol',
                'description' => 'Deskripsi harga nol',
                'price' => -1,
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Harga beli tidak boleh bernilai 0 atau negatif', session('errors')->get('price')[0]);
    }

    /** @test */
    public function test_admin_mengedit_produk_dengan_harga_non_integer()
    {
        $product = Product::factory()->create(['name' => 'Produk Lama']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.products.update', $product), [
                'name' => 'Produk Edit Harga Non Integer',
                'description' => 'Deskripsi harga non integer',
                'price' => 'budi',
                'rental_price' => 50000,
                'stock' => 10,
            ]);

        $response->assertSessionHasErrors(['price']);
        $this->assertStringContainsString('Harga beli harus berupa angka', session('errors')->get('price')[0]);
    }
}