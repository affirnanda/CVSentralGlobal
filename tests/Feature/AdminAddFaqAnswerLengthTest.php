<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqAnswerLengthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4E: Admin menambah FAQ dengan jawaban FAQ (≤300 karakter)
     */
    public function test_tc_bf_4e_admin_menambah_faq_dengan_jawaban_maksimal_300_karakter()
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
        // 1 & 2. Membuat string jawaban persis 300 karakter dan mengisi form
        $jawabanMaksimal = str_repeat('B', 300);

        $faqData = [
            'question' => 'Bagaimana kebijakan pengembalian barang?', // Pertanyaan valid standar
            'answer' => $jawabanMaksimal,
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Sistem menerima data (redirect ke /faqs tanpa pesan error)
        $response->assertRedirect('/faqs');
        $response->assertSessionHas('success', 'FAQ berhasil ditambahkan!');

        // Verifikasi B: Jawaban yang panjangnya 300 karakter tersebut berhasil masuk ke Database
        $this->assertDatabaseHas('faqs', [
            'question' => 'Bagaimana kebijakan pengembalian barang?',
            'answer' => $jawabanMaksimal,
        ]);
    }
}