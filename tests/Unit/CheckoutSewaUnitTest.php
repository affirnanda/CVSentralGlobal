<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Mockery;

class CheckoutRentUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_sewa_keranjang_kosong()
    {
        $request = Request::create('/checkout', 'POST', [
            'type' => 'rent',
            'full_name' => 'John Doe',
            'email' => 'john@test.com',
            'phone' => '081234567890',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'district' => 'Gubeng',
            'address' => 'Jl. Merdeka',
            'postal_code' => '60281',
            'payment_method_id' => 1,
            'rent_start' => '2023-12-01',
            'rent_end' => '2023-12-05',
        ]);

        $validatorMock = Mockery::mock(\Illuminate\Contracts\Validation\Validator::class);
        $validatorMock->shouldReceive('validate')->andReturn([]);
        Validator::shouldReceive('make')->andReturn($validatorMock);

        Session::shouldReceive('get')->with('keranjang', [])->andReturn([]);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')->with('error', 'Keranjang kosong')->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new CheckoutController();
        $response = $controller->process($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_proses_sewa_invalid()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/checkout', 'POST', [
            'type' => 'rent',
        ]);

        $controller = new CheckoutController();
        $controller->process($request);
    }

    public function test_proses_sewa_valid()
    {
        $request = Request::create('/checkout', 'POST', [
            'type' => 'rent',
            'full_name' => 'John Doe',
            'email' => 'john@test.com',
            'phone' => '081234567890',
            'province' => 'Jatim',
            'city' => 'Sby',
            'district' => 'Gubeng',
            'address' => 'Jl',
            'postal_code' => '123',
            'payment_method_id' => 1,
            'rent_start' => '2023-12-01',
            'rent_end' => '2023-12-03',
        ]);

        $validatorMock = Mockery::mock(\Illuminate\Contracts\Validation\Validator::class);
        $validatorMock->shouldReceive('validate')->andReturn([]);
        Validator::shouldReceive('make')->andReturn($validatorMock);

        Session::shouldReceive('get')->with('keranjang', [])->andReturn([
            1 => [
                'id' => 1,
                'name' => 'Kamera DSLR',
                'rental_price' => 100000,
                'qty' => 1
            ]
        ]);
        Session::shouldReceive('forget')->with('keranjang')->once();

        DB::shouldReceive('transaction')->once()->andReturnUsing(function ($callback) {
            return $callback();
        });

        $orderMock = Mockery::mock('alias:' . Order::class);
        $order = Mockery::mock();
        $order->id = 99;
        $orderMock->shouldReceive('create')->once()->andReturn($order);

        $orderItemMock = Mockery::mock('alias:' . OrderItem::class);
        $orderItemMock->shouldReceive('create')->once();

        $productMock = Mockery::mock('alias:' . Product::class);
        $productInstance = Mockery::mock();
        $productInstance->stock = 5;
        $productInstance->name = 'Kamera DSLR';

        $productMock->shouldReceive('find')->with(1)->once()->andReturn($productInstance);
        $productInstance->shouldReceive('decrement')->with('stock', 1)->once();

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')->with('success', 'Order berhasil dibuat!')->andReturn($redirectResponseMock);

        $redirectMock->shouldReceive('route')->with('invoice.show', $order)->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new CheckoutController();
        $response = $controller->process($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
