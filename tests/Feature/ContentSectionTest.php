<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ContentSectionTest extends TestCase
{
    protected function authenticate()
    {
        // Membypass database sqlite yang error dengan membuat instance User langsung
        $user = new User();
        $user->id = 1;
        $this->actingAs($user);
    }

    protected function validData()
    {
        return [
            'hero_title' => 'Solusi Terbaik',
            'section_text' => 'Deskripsi Hero',
        ];
    }

    /**
     * TC-BF-1G: Admin menyimpan paragraf konten section (≤255 karakter)
     */
    public function test_admin_menyimpan_paragraf_konten_section_kurang_dari_sama_dengan_255_karakter_tc_bf_1g()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => str_repeat('B', 255) // ≤255 karakter
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('section_text');
    }

    /**
     * TC-BF-1H: Admin menyimpan paragraf konten section (>255 karakter)
     * (Sengaja disisakan 1 yang FAILED sesuai permintaan untuk menunjukkan 
     * bahwa sistem aplikasi saat ini tidak memiliki batasan maksimal 255 karakter)
     */
    public function test_admin_menyimpan_paragraf_konten_section_lebih_dari_255_karakter_tc_bf_1h()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => str_repeat('A', 256) // >255 karakter
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        // Ini akan menyebabkan FAILED (failed) karena controller aslinya mengizinkan
        // string lebih dari 255 karakter, sedangkan Test Case mengharapkan ada error.
        $response->assertSessionHasErrors('section_text');
    }

    /**
     * TC-BF-1I: Admin menyimpan paragraf konten section yang kosong
     */
    public function test_admin_menyimpan_paragraf_konten_section_yang_kosong_tc_bf_1i()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => '' // kosong
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        // Muncul error message "Paragraf konten tidak boleh kosong"
        $response->assertSessionHasErrors('section_text');
    }

    /**
     * TC-BF-1J: Admin mengunggah gambar konten section
     */
    public function test_admin_mengunggah_gambar_konten_section_tc_bf_1j()
    {
        Storage::fake('public');
        $this->authenticate();

        $file = UploadedFile::fake()->image('profile.jpg');
        $data = array_merge($this->validData(), ['profile_image' => $file]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('profile_image');
        Storage::disk('public')->assertExists('landing/' . $file->hashName());
    }

    /**
     * TC-BF-1K: Admin mengunggah gambar konten section dengan format salah
     */
    public function test_admin_mengunggah_gambar_konten_section_dengan_format_salah_tc_bf_1k()
    {
        Storage::fake('public');
        $this->authenticate();

        $file = UploadedFile::fake()->create('file.pdf', 100);
        $data = array_merge($this->validData(), ['profile_image' => $file]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('profile_image');
    }

    /**
     * TC-BF-1L: Admin tidak mengunggah gambar konten section
     */
    public function test_admin_tidak_mengunggah_gambar_konten_section_tc_bf_1l()
    {
        $this->authenticate();

        $response = $this->post('/admin/kelola-hero-section', $this->validData());

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('profile_image');
    }
}
