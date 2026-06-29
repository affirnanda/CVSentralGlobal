<?php

namespace Tests\Unit; // Pastikan namespace-nya Unit

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Faq;
use Mockery;

class AdminAddFaqAnswerLengthTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_tc_bf_4e_admin_menambah_faq_dengan_jawaban_maksimal_300_karakter()
    {
        // 1. Persiapan Data
        $jawabanMaksimal = str_repeat('B', 300);

        $request = Request::create('/faqs', 'POST', [
            'question' => 'Bagaimana kebijakan pengembalian barang?',
            'answer' => $jawabanMaksimal,
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Mocking Model & Query Builder
        $faqMock = Mockery::mock('alias:' . Faq::class);
        $queryBuilderMock = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        
        // Mock untuk logika: Faq::where('order', '>=', 1)->increment('order');
        $faqMock->shouldReceive('where')
            ->with('order', '>=', 1)
            ->once()
            ->andReturn($queryBuilderMock);
            
        $queryBuilderMock->shouldReceive('increment')
            ->with('order')
            ->once();

        // Mock untuk logika: Faq::create([...])
        $faqMock->shouldReceive('create')
            ->with([
                'question' => 'Bagaimana kebijakan pengembalian barang?',
                'answer' => $jawabanMaksimal,
                'is_active' => true,
                'order' => 1,
            ])
            ->once()
            ->andReturn((object)['id' => 1]);

        // 3. Mocking Redirect
        $redirectMock = Mockery::mock(\Illuminate\Routing\Redirector::class);
        $redirectResponseMock = Mockery::mock(RedirectResponse::class);

        $redirectResponseMock->shouldReceive('with')
            ->with('success', 'FAQ berhasil ditambahkan!')
            ->once()
            ->andReturn($redirectResponseMock);

        $redirectMock->shouldReceive('route')
            ->with('faqs.index')
            ->once()
            ->andReturn($redirectResponseMock);

        Redirect::swap($redirectMock);

        // 4. Eksekusi Controller Langsung (Whitebox)
        $controller = new FaqController();
        $response = $controller->store($request);

        // 5. Verifikasi
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}