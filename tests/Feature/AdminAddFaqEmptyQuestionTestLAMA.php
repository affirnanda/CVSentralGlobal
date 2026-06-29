<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqEmptyQuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4D: Admin menambah FAQ dengan pertanyaan kosong
     */
    public function test_tc_bf_4d_admin_menambah_faq_dengan_pertanyaan_kosong()
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
        // 1 & 2. Mengosongkan isian pertanyaan
        $faqData = [
            'question' => '', // Kolom pertanyaan sengaja dikosongkan
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Muncul error message "Silahkan isi pertanyaan"
        $response->assertSessionHasErrors([
            'question' => 'Silahkan isi pertanyaan',
        ]);

        // Verifikasi B: Sistem membatalkan proses dan tidak menyimpan data ke database
        // Kita menggunakan 'answer' sebagai penanda untuk memastikan baris data ini tidak masuk
        $this->assertDatabaseMissing('faqs', [
            'answer' => 'Ini adalah jawaban yang valid.',
        ]);
    }
}