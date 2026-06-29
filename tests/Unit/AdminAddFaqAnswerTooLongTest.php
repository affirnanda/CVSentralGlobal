<?php

namespace Tests\Unit; // Menggunakan folder Unit

use Tests\TestCase;
use App\Http\Controllers\FaqController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;

class AdminAddFaqAnswerTooLongTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * TC-BF-4F: Admin menambah FAQ dengan jawaban FAQ (>300 karakter)
     */
    public function test_tc_bf_4f_admin_menambah_faq_dengan_jawaban_lebih_dari_300_karakter()
    {
        // 1. Beritahu PHPUnit bahwa kita berekspektasi Controller akan menolak dan melempar Exception
        $this->expectException(ValidationException::class);

        // 2. Persiapan Data (jawaban 305 karakter)
        $jawabanLebih = str_repeat('C', 305);

        $request = Request::create('/faqs', 'POST', [
            'question' => 'Bagaimana cara menghubungi customer service?',
            'answer' => $jawabanLebih,
            'order' => 1,
            'is_active' => true,
        ]);

        // 3. Eksekusi Controller
        $controller = new FaqController();
        $controller->store($request);
        
        // Catatan: Saat eksekusi store(), proses akan otomatis berhenti pada baris $request->validate()
        // dan test ini akan dianggap PASS (berhasil) karena Exception dilempar sesuai ekspektasi.
    }
}