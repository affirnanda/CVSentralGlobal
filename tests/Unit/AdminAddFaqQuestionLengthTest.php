<?php

namespace Tests\Unit; // Menggunakan namespace Unit

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Faq;
use Mockery;

class AdminAddFaqQuestionLengthTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4B: Admin menambah FAQ dengan data pertanyaan FAQ (maksimal 100 karakter)
     */
    public function test_tc_bf_4b_admin_menambah_faq_dengan_pertanyaan_maksimal_100_karakter()
    {
        // 1. Persiapan Data (Request)
        $pertanyaan100Karakter = str_repeat('A', 100);

        $request = Request::create('/faqs', 'POST', [
            'question' => $pertanyaan100Karakter,
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Isolasi Ketergantungan (Mocking Model & Builder)
        $faqMock = Mockery::mock('alias:' . Faq::class);
        $queryBuilderMock = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        
        // Mock untuk: Faq::where('order', '>=', 1)->increment('order');
        $faqMock->shouldReceive('where')
            ->with('order', '>=', 1)
            ->once()
            ->andReturn($queryBuilderMock);
            
        $queryBuilderMock->shouldReceive('increment')
            ->with('order')
            ->once();

        // Mock untuk: Faq::create([...])
        $faqMock->shouldReceive('create')
            ->with([
                'question' => $pertanyaan100Karakter,
                'answer' => 'Ini adalah jawaban yang valid.',
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

        // 4. Eksekusi Controller Langsung
        $controller = new FaqController();
        $response = $controller->store($request);

        // 5. Verifikasi
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}