<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Faq;
use Mockery;

class AdminAddFaqTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4A: Admin menambah FAQ dengan data lengkap
     */
    public function test_tc_bf_4a_admin_menambah_faq_dengan_data_lengkap()
    {
        // 1. Persiapan Data Request
        $faqData = [
            'question' => 'Bagaimana cara melakukan pemesanan?',
            'answer' => 'Pilih produk lalu checkout',
            'order' => 1,
            'is_active' => true,
        ];

        $request = Request::create('/faqs', 'POST', $faqData);

        // 2. Isolasi Ketergantungan (Mocking)
        $faqMock = Mockery::mock('alias:' . Faq::class);
        $queryBuilderMock = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);

        // Mock logic: Faq::where('order', '>=', 1)->increment('order');
        $faqMock->shouldReceive('where')
            ->with('order', '>=', 1)
            ->once()
            ->andReturn($queryBuilderMock);
            
        $queryBuilderMock->shouldReceive('increment')
            ->with('order')
            ->once();

        // Mock logic: Faq::create([...])
        $faqMock->shouldReceive('create')
            ->with($faqData)
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

        // 4. Eksekusi
        $controller = new FaqController();
        $response = $controller->store($request);

        // 5. Verifikasi
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}