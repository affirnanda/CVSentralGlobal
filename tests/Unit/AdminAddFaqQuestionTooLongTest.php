<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;

class AdminAddFaqQuestionTooLongTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4C: Admin menambah FAQ dengan pertanyaan >100 karakter
     */
    public function test_tc_bf_4c_admin_menambah_faq_dengan_pertanyaan_lebih_dari_100_karakter()
    {
        // 1. Ekspektasi error validasi
        $this->expectException(ValidationException::class);

        // 2. Persiapan Data (Pertanyaan 105 karakter)
        $pertanyaanLebih = str_repeat('A', 105);

        $request = Request::create('/faqs', 'POST', [
            'question' => $pertanyaanLebih,
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ]);

        // 3. Eksekusi Controller
        $controller = new FaqController();
        $controller->store($request);
        
        // Eksekusi akan terhenti karena ValidationException
    }
}