<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqAnswerTooLongTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4F: Admin menambah FAQ dengan jawaban FAQ (>300 karakter)
     */
    public function test_tc_bf_4f_admin_menambah_faq_dengan_jawaban_lebih_dari_300_karakter()
    {
        // ==========================================
        // PRE-CONDITION: ADMIN LOGIN
        // ==========================================
        $admin = User::factory()->create([
            'email' => 'super@admin.com',
        ]);

        $this->actingAs($admin);

        // ==========================================
        // SKENARIO PENGUJIAN
        // ==========================================
        // 1 & 2. Membuat jawaban 305 karakter (melebihi batas maksimal 300 karakter)
        $jawabanLebih = str_repeat('C', 305);

        $faqData = [
            'question' => 'Bagaimana cara menghubungi customer service?',
            'answer' => $jawabanLebih,
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST ke Controller)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Proses dihentikan dan terdapat Session Error pada kolom 'answer' 
        // dengan pesan yang persis diatur di FaqController
        $response->assertSessionHasErrors([
            'answer' => 'Jawaban terlalu panjang',
        ]);

        // Verifikasi B: Sistem tidak memproses ke database
        // Mengecek melalui 'question' untuk memastikan baris data ini memang tidak pernah di-insert
        $this->assertDatabaseMissing('faqs', [
            'question' => 'Bagaimana cara menghubungi customer service?',
        ]);
    }
}