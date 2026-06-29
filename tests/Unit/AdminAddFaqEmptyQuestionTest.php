<?php

namespace Tests\Unit; // Menggunakan namespace Unit

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;

class AdminAddFaqEmptyQuestionTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4D: Admin menambah FAQ dengan pertanyaan kosong
     */
    public function test_tc_bf_4d_admin_menambah_faq_dengan_pertanyaan_kosong()
    {
        // 1. Beritahu PHPUnit bahwa kita berekspektasi adanya error validasi
        $this->expectException(ValidationException::class);

        // 2. Persiapan Data (pertanyaan sengaja dikosongkan)
        $request = Request::create('/faqs', 'POST', [
            'question' => '', // Dikosongkan untuk memicu error 'required'
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ]);

        // 3. Eksekusi Controller
        $controller = new FaqController();
        $controller->store($request);
        
        // Eksekusi akan otomatis terhenti di baris $request->validate() 
        // dan test ini dinyatakan berhasil (PASS).
    }
}