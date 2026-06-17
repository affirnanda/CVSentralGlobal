<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqEmptyAnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4G: Admin menambah FAQ dengan jawaban kosong
     */
    public function test_tc_bf_4g_admin_menambah_faq_dengan_jawaban_kosong()
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
        // 1 & 2. Mengisi pertanyaan dengan valid, tapi mengosongkan jawaban
        $faqData = [
            'question' => 'Bagaimana cara melacak pesanan saya?',
            'answer' => '', // Kolom jawaban sengaja dikosongkan
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Muncul error message "Silahkan isi jawaban" sesuai di FaqController
        $response->assertSessionHasErrors([
            'answer' => 'Silahkan isi jawaban',
        ]);

        // Verifikasi B: Sistem membatalkan proses dan tidak menyimpan data ke database
        // Kita menggunakan 'question' sebagai penanda untuk memastikan baris data ini batal disimpan
        $this->assertDatabaseMissing('faqs', [
            'question' => 'Bagaimana cara melacak pesanan saya?',
        ]);
    }
}