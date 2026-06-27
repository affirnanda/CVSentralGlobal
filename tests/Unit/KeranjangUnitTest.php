<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\KeranjangController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use Mockery;

class KeranjangUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_tambah_produk_keranjang_valid()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('validate')->once()->andReturn(['qty' => 2]);

        $productMock = Mockery::mock(Product::class)->makePartial();
        $productMock->id = 1;
        $productMock->name = 'Kamera DSLR';
        $productMock->price = 5000000;
        $productMock->rental_price = 100000;
        $productMock->image = 'kamera.jpg';
        $productMock->stock = 10;

        Session::shouldReceive('get')->with('keranjang', [])->andReturn([]);
        Session::shouldReceive('put')->once()->with('keranjang', [
            1 => [
                'id' => 1,
                'name' => 'Kamera DSLR',
                'price' => 5000000,
                'rental_price' => 100000,
                'image' => 'kamera.jpg',
                'qty' => 2,
            ]
        ]);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')->with('success', 'Produk ditambahkan ke keranjang')->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new KeranjangController();
        $response = $controller->add($requestMock, $productMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_tambah_produk_keranjang_invalid_stok_habis()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('validate')->once()->andReturn(['qty' => 1]);

        $productMock = Mockery::mock(Product::class)->makePartial();
        $productMock->stock = 0;

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')->with('error', 'Stok produk habis')->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new KeranjangController();
        $response = $controller->add($requestMock, $productMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_tambah_produk_keranjang_invalid_melebihi_stok()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('validate')->once()->andReturn(['qty' => 5]);

        $productMock = Mockery::mock(Product::class)->makePartial();
        $productMock->stock = 3;

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')->with('error', 'Stok barang tidak mencukupi')->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new KeranjangController();
        $response = $controller->add($requestMock, $productMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
