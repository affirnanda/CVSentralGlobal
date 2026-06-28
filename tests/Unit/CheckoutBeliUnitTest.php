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

class CheckoutBeliUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_beli_keranjang_kosong()
    {
        $request = Request::create('/checkout', 'POST', [
            'type' => 'buy',
            'full_name' => 'John Doe',
            'email' => 'john@test.com',
            'phone' => '081234567890',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'district' => 'Gubeng',
            'address' => 'Jl. Merdeka',
            'postal_code' => '60281',
            'payment_method_id' => 1,
        ]);

        $validatorMock = Mockery::mock(\Illuminate\Contracts\Validation\Validator::class);
        $validatorMock->shouldReceive('validate')->andReturn([]);
        Validator::shouldReceive('make')->andReturn($validatorMock);

        Session::shouldReceive('get')
            ->with('keranjang', [])
            ->andReturn([]);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);

        $redirectResponseMock
            ->shouldReceive('with')
            ->with('error', 'Keranjang kosong')
            ->andReturn($redirectResponseMock);

        $redirectMock
            ->shouldReceive('back')
            ->andReturn($redirectResponseMock);

        Redirect::swap($redirectMock);

        $controller = new CheckoutController();

        $response = $controller->process($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_proses_beli_invalid()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/checkout', 'POST', [
            'type' => 'buy',
        ]);

        $controller = new CheckoutController();
        $controller->process($request);
    }

    public function test_proses_beli_valid()
    {
        $request = Request::create('/checkout', 'POST', [
            'type' => 'buy',
            'full_name' => 'John Doe',
            'email' => 'john@test.com',
            'phone' => '081234567890',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'district' => 'Gubeng',
            'address' => 'Jl. Merdeka',
            'postal_code' => '60281',
            'payment_method_id' => 1,
        ]);

        $validatorMock = Mockery::mock(\Illuminate\Contracts\Validation\Validator::class);
        $validatorMock->shouldReceive('validate')->andReturn([]);
        Validator::shouldReceive('make')->andReturn($validatorMock);

        Session::shouldReceive('get')
            ->with('keranjang', [])
            ->andReturn([
                1 => [
                    'id' => 1,
                    'name' => 'Laptop',
                    'price' => 5000000,
                    'qty' => 2,
                ]
            ]);

        Session::shouldReceive('forget')
            ->with('keranjang')
            ->once();

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($callback) {
                return $callback();
            });

        $orderMock = Mockery::mock('alias:' . Order::class);

        $order = Mockery::mock();
        $order->id = 99;

        $orderMock
            ->shouldReceive('create')
            ->once()
            ->andReturn($order);

        $orderItemMock = Mockery::mock('alias:' . OrderItem::class);

        $orderItemMock
            ->shouldReceive('create')
            ->once();

        $productMock = Mockery::mock('alias:' . Product::class);

        $product = Mockery::mock();
        $product->stock = 10;
        $product->name = 'Laptop';

        $productMock
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($product);

        $product
            ->shouldReceive('decrement')
            ->with('stock', 2)
            ->once();

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);

        $redirectResponseMock
            ->shouldReceive('with')
            ->with('success', 'Order berhasil dibuat!')
            ->andReturn($redirectResponseMock);

        $redirectMock
            ->shouldReceive('route')
            ->with('invoice.show', $order)
            ->andReturn($redirectResponseMock);

        Redirect::swap($redirectMock);

        $controller = new CheckoutController();

        $response = $controller->process($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}