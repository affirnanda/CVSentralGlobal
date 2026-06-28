<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\KelolaHeroSectionController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Mockery;

class KelolaHeroSectiontest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_returns_view_with_data()
    {
       
        $mockData = ['hero_title' => 'Test Hero'];
        Storage::shouldReceive('exists')->with('landing_page.json')->once()->andReturn(true);
        Storage::shouldReceive('get')->with('landing_page.json')->once()->andReturn(json_encode($mockData));

        $controller = new KelolaHeroSectionController();
        $response = $controller->index();

        // Assert response is a View
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('admin.kelola-hero-section', $response->name());
        $this->assertArrayHasKey('data', $response->getData());
        $this->assertEquals($mockData, $response->getData()['data']);
    }

    public function test_index_returns_view_without_data()
    {
       
        Storage::shouldReceive('exists')->with('landing_page.json')->once()->andReturn(false);

        $controller = new KelolaHeroSectionController();
        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('admin.kelola-hero-section', $response->name());
        $this->assertArrayHasKey('data', $response->getData());
        $this->assertEquals([], $response->getData()['data']);
    }

    public function test_update_hero_valid()
    {
        $requestData = [
            'hero_title' => 'Judul Hero Valid',
            'profile_title' => 'Profile Default',
            'section_text' => 'Teks Default',
        ];
        
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn($requestData);
        $requestMock->shouldReceive('hasFile')->andReturn(false);
        $requestMock->shouldReceive('input')->with('hero_title')->andReturn($requestData['hero_title']);
        $requestMock->shouldReceive('input')->with('profile_title')->andReturn($requestData['profile_title']);
        $requestMock->shouldReceive('input')->with('section_text')->andReturn($requestData['section_text']);

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

    public function test_update_hero_invalid_empty_fields()
    {
        $requestData = [
            'hero_title' => '',
            'profile_title' => '',
            'section_text' => '',
        ];

        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn($requestData);

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

    public function test_update_hero_invalid_image_mimes()
    {
        // Fake file with invalid extension/mime
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $requestData = [
            'hero_title' => 'Judul',
            'profile_title' => 'Profile',
            'section_text' => 'Teks',
            'hero_image' => $file
        ];

        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('all')->andReturn($requestData);
        $requestMock->shouldReceive('hasFile')->with('hero_image')->andReturn(true);
        $requestMock->shouldReceive('file')->with('hero_image')->andReturn($file);

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
