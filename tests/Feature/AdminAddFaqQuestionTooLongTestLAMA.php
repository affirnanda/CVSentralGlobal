<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqQuestionTooLongTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4C: Admin menambah FAQ dengan pertanyaan >100 karakter
     */
    public function test_tc_bf_4c_admin_menambah_faq_dengan_pertanyaan_lebih_dari_100_karakter()
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
        // 1 & 2. Membuat pertanyaan 105 karakter (melebihi batas maksimal 100 karakter)
        $pertanyaanLebih = str_repeat('A', 105);

        $faqData = [
            'question' => $pertanyaanLebih,
            'answer' => 'Ini adalah jawaban yang valid.',
            'order' => 1,
            'is_active' => true,
        ];

        // 3. Admin klik Simpan (Mengirim request POST ke Controller)
        $response = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Proses dihentikan dan terdapat Session Error pada kolom 'question' 
        // dengan pesan persis sesuai yang ada di FaqController
        $response->assertSessionHasErrors([
            'question' => 'Pertanyaan terlalu panjang',
        ]);

        // Verifikasi B: Sistem tidak menyimpan data (Database tidak berisi pertanyaan tersebut)
        $this->assertDatabaseMissing('faqs', [
            'question' => $pertanyaanLebih,
        ]);
    }
}