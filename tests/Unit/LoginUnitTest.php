<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Mockery;

class LoginUnitTest extends TestCase
{
    public function test_login_autentikasi_valid()
    {
        $requestMock = Mockery::mock(LoginRequest::class)->makePartial();

        $requestMock->shouldReceive('authenticate')->once()->andReturnNull();

        $sessionMock = Mockery::mock(\Illuminate\Contracts\Session\Session::class);
        $sessionMock->shouldReceive('regenerate')->once()->andReturn(true);

        $requestMock->shouldReceive('session')->andReturn($sessionMock);

        $controller = new AuthenticatedSessionController();
        $response = $controller->store($requestMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('dashboard'), $response->getTargetUrl());
    }

    public function test_login_autentikasi_invalid()
    {
        $this->expectException(ValidationException::class);

        $requestMock = Mockery::mock(LoginRequest::class)->makePartial();

        $requestMock->shouldReceive('authenticate')
            ->once()
            ->andThrow(ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]));

        $controller = new AuthenticatedSessionController();
        $controller->store($requestMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
