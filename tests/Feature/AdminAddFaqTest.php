<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAddFaqTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TC-BF-4A: Admin menambah FAQ dengan data lengkap
     */
    public function test_tc_bf_4a_admin_menambah_faq_dengan_data_lengkap()
    {
        // ==========================================
        // PRE-CONDITION: ADMIN LOGIN
        // ==========================================
        $admin = User::factory()->create([
            'email' => 'super@admin.com',
        ]);

        $this->actingAs($admin);

        $responseIndex = $this->get('/faqs');
        $responseIndex->assertStatus(200);

        // ==========================================
        // SKENARIO PENGUJIAN
        // ==========================================
        // 1. Admin membuka halaman form Tambah FAQ
        $responseCreate = $this->get('/faqs/create');
        $responseCreate->assertStatus(200);

        // 2 & 3. Admin mengisi form dan klik Simpan
        $faqData = [
            'question' => 'Bagaimana cara melakukan pemesanan?',
            'answer' => 'Pilih produk lalu checkout',
            'order' => 1, 
            'is_active' => true,
        ];

        $responseStore = $this->post('/faqs', $faqData);

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Verifikasi A: Sistem melakukan redirect kembali ke halaman kelola FAQ (/faqs)
        $responseStore->assertRedirect('/faqs');
        
        // Verifikasi B: Terdapat Session Alert Success
        $responseStore->assertSessionHas('success', 'FAQ berhasil ditambahkan!');

        // Verifikasi C: Data benar-benar tersimpan di Database
        $this->assertDatabaseHas('faqs', [
            'question' => 'Bagaimana cara melakukan pemesanan?',
            'answer' => 'Pilih produk lalu checkout',
        ]);

        // Verifikasi D: Tampil pada Landing Page
        $responseLanding = $this->get('/');
        $responseLanding->assertStatus(200)
                        ->assertSee('Bagaimana cara melakukan pemesanan?');
    }
}
