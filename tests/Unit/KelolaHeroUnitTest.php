<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\KelolaHeroSectionController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Mockery;

class KelolaHeroUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_update_hero_valid()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn([
            'hero_title' => 'Judul Hero Valid',
            'profile_title' => 'Profile Default',
            'section_text' => 'Teks Default',
        ]);

        $requestMock->shouldReceive('hasFile')->andReturn(false);
        $requestMock->shouldReceive('input')->with('hero_title')->andReturn('Judul Hero Valid');
        $requestMock->shouldReceive('input')->with('profile_title')->andReturn('Profile Default');
        $requestMock->shouldReceive('input')->with('section_text')->andReturn('Teks Default');

        Storage::shouldReceive('exists')->with('landing_page.json')->andReturn(false);
        Storage::shouldReceive('put')->once()->andReturn(true);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);

        $redirectResponseMock->shouldReceive('with')->with('status', 'Konten Berhasil Diubah.')->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new KelolaHeroSectionController();
        $response = $controller->update($requestMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_hero_invalid_empty_title()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn([
            'hero_title' => '',
            'profile_title' => 'Profile Default',
            'section_text' => 'Teks Default',
        ]);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);

        $redirectResponseMock->shouldReceive('withErrors')->once()->andReturn($redirectResponseMock);
        $redirectResponseMock->shouldReceive('withInput')->once()->andReturn($redirectResponseMock);
        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new KelolaHeroSectionController();
        $response = $controller->update($requestMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
