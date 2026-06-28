<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function makeRequest(string $method, array $data = []): Request
    {
        return Request::create('/admin/products', $method, $data);
    }

    private function mockValidator(bool $fails, array $errors = []): ValidatorContract
    {
        $validator = Mockery::mock(ValidatorContract::class);
        $validator->shouldReceive('after')->withArgs(function ($callback) use ($validator): bool {
            $callback($validator);

            return true;
        })->andReturnSelf();
        $validator->shouldReceive('fails')->andReturn($fails);
        $validator->shouldReceive('errors')->andReturn(new MessageBag($errors));
        $validator->shouldReceive('getMessageBag')->andReturn(new MessageBag($errors));

        Validator::shouldReceive('make')->andReturn($validator);

        return $validator;
    }

    private function assertRedirectResponse(RedirectResponse $response): void
    {
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame(302, $response->getStatusCode());
    }

    #[Test]
    public function store_with_missing_name_returns_back_with_error(): void
    {
        $request = $this->makeRequest('GET', ['name' => '']);
        $this->mockValidator(true, ['name' => ['Nama produk tidak boleh kosong']]);

        $response = (new ProductController())->store($request);

        $this->assertRedirectResponse($response);
    }

    #[Test]
    public function store_with_invalid_stock_returns_back_with_error(): void
    {
        $request = $this->makeRequest('GET', ['stock' => -2]);
        $this->mockValidator(true, ['stock' => ['Stok tidak boleh bernilai 0 atau negatif']]);

        $response = (new ProductController())->store($request);

        $this->assertRedirectResponse($response);
    }

    #[Test]
    public function update_with_missing_name_returns_back_with_error(): void
    {
        $product = Mockery::mock(Product::class)->makePartial();
        $product->id = 1;

        $request = $this->makeRequest('GET', ['name' => '']);
        $this->mockValidator(true, ['name' => ['Nama produk tidak boleh kosong']]);

        $response = (new ProductController())->update($request, $product);

        $this->assertRedirectResponse($response);
    }

    #[Test]
    public function update_with_invalid_price_returns_back_with_error(): void
    {
        $product = Mockery::mock(Product::class)->makePartial();
        $product->id = 1;

        $request = $this->makeRequest('GET', ['price' => 0]);
        $this->mockValidator(true, ['price' => ['Harga beli tidak boleh bernilai 0 atau negatif']]);

        $response = (new ProductController())->update($request, $product);

        $this->assertRedirectResponse($response);
    }
}
