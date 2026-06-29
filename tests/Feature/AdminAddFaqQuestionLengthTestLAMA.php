<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqQuestionLengthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4B: Admin menambah FAQ dengan data pertanyaan FAQ (≤100 karakter)
     */
    public function test_tc_bf_4b_admin_menambah_faq_dengan_pertanyaan_maksimal_100_karakter()
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
        // 1 & 2. Membuat pertanyaan persis 100 karakter dan mengisi form
        $pertanyaan100Karakter = str_repeat('A', 100);

        $faqData = [
            'question' => $pertanyaan100Karakter,
            // Tetap isi jawaban & order agar lolos validasi required yang lain
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Sistem menerima data (redirect sukses tanpa error validasi)
        $response->assertRedirect('/faqs');
        $response->assertSessionHas('success', 'FAQ berhasil ditambahkan!');

        // Verifikasi B: Pertanyaan dengan 100 karakter tersebut tersimpan di Database
        $this->assertDatabaseHas('faqs', [
            'question' => $pertanyaan100Karakter,
        ]);
    }
}