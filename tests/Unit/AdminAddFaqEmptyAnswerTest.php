<?php

namespace Tests\Unit; // Ingat untuk dipindah ke folder Unit

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;

class AdminAddFaqEmptyAnswerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4G: Admin menambah FAQ dengan jawaban kosong
     */
    public function test_tc_bf_4g_admin_menambah_faq_dengan_jawaban_kosong()
    {
        // 1. Beritahu PHPUnit bahwa kita berekspektasi adanya error validasi
        $this->expectException(ValidationException::class);

        // 2. Persiapan Data (jawaban sengaja dikosongkan)
        $request = Request::create('/faqs', 'POST', [
            'question' => 'Bagaimana cara melacak pesanan saya?',
            'answer' => '', // Dikosongkan untuk memicu error 'required'
            'order' => 1,
            'is_active' => true,
        ]);

        // 3. Eksekusi Controller
        $controller = new FaqController();
        $controller->store($request);
        
        // Proses akan otomatis terhenti di baris $request->validate() pada controller
    }
}