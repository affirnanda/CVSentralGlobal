<?php

namespace Tests\Unit;

use App\Http\Controllers\TestimonialController;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\RunClassInSeparateProcess;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\PreserveGlobalState;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class TestimonialUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    
    public function test_approve_testimonial_menyetujui()
    {
        $testimonialMock = Mockery::mock(Testimonial::class)->makePartial();
        $testimonialMock->is_approved = false;
        
        $testimonialMock->shouldReceive('update')
            ->once()
            ->with(['is_approved' => true])
            ->andReturnUsing(function($data) use ($testimonialMock) {
                $testimonialMock->is_approved = $data['is_approved'];
                return true;
            });

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')
            ->once()
            ->with('success', 'Testimoni berhasil disetujui.')
            ->andReturnSelf();

        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new TestimonialController();
        $response = $controller->approve($testimonialMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_approve_testimonial_menyembunyikan()
    {
        $testimonialMock = Mockery::mock(Testimonial::class)->makePartial();
        $testimonialMock->is_approved = true;
        
        $testimonialMock->shouldReceive('update')
            ->once()
            ->with(['is_approved' => false])
            ->andReturnUsing(function($data) use ($testimonialMock) {
                $testimonialMock->is_approved = $data['is_approved'];
                return true;
            });

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')
            ->once()
            ->with('success', 'Testimoni berhasil disembunyikan.')
            ->andReturnSelf();

        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new TestimonialController();
        $response = $controller->approve($testimonialMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_destroy_testimonial()
    {
        $testimonialMock = Mockery::mock(Testimonial::class)->makePartial();
        $testimonialMock->shouldReceive('delete')->once()->andReturn(true);

        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);
        $redirectResponseMock->shouldReceive('with')
            ->once()
            ->with('success', 'Testimoni berhasil dihapus.')
            ->andReturnSelf();

        $redirectMock->shouldReceive('back')->andReturn($redirectResponseMock);
        Redirect::swap($redirectMock);

        $controller = new TestimonialController();
        $response = $controller->destroy($testimonialMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

 
}
