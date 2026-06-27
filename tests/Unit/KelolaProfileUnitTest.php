<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\KelolaHeroSectionController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Mockery;

class KelolaProfileUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_update_profile_valid()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn([
            'hero_title' => 'Hero Default',
            'profile_title' => 'Judul Profile Valid',
            'section_text' => 'Teks Paragraf Profile Valid',
        ]);

        $requestMock->shouldReceive('hasFile')->andReturn(false);
        $requestMock->shouldReceive('input')->with('hero_title')->andReturn('Hero Default');
        $requestMock->shouldReceive('input')->with('profile_title')->andReturn('Judul Profile Valid');
        $requestMock->shouldReceive('input')->with('section_text')->andReturn('Teks Paragraf Profile Valid');

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

    public function test_update_profile_invalid_empty_title_and_text()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn([
            'hero_title' => 'Hero Default',
            'profile_title' => '',
            'section_text' => '',
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
