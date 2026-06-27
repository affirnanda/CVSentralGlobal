<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HeroSectionTest extends TestCase
{
    protected function authenticate()
    {
        $user = new User();
        $user->id = 1;
        $this->actingAs($user);
    }

    protected function validData()
    {
        return [
            'hero_title' => 'Solusi Terbaik',
            'profile_title' => 'Profile Kami',
            'section_text' => 'Deskripsi Hero',
        ];
    }

    public function test_admin_mengunggah_gambar_hero_section_tc_bf_1a()
    {
        Storage::fake('public');
        $this->authenticate();

        $file = UploadedFile::fake()->image('hero.png');
        $data = array_merge($this->validData(), ['hero_image' => $file]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists('landing/' . $file->hashName());
    }

    public function test_admin_mengunggah_gambar_dengan_format_salah_tc_bf_1b()
    {
        Storage::fake('public');
        $this->authenticate();

        $file = UploadedFile::fake()->create('file.pdf', 100);
        $data = array_merge($this->validData(), ['hero_image' => $file]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('hero_image');
    }

    public function test_admin_tidak_mengunggah_gambar_hero_section_tc_bf_1c()
    {
        $this->authenticate();

        $response = $this->post('/admin/kelola-hero-section', $this->validData());

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('hero_image');
    }

    public function test_admin_menyimpan_judul_hero_section_kurang_dari_sama_dengan_100_karakter_tc_bf_1d()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'hero_title' => 'Solusi Terbaik untuk Bisnis Anda'
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('hero_title');
    }

    public function test_admin_menyimpan_judul_hero_section_lebih_dari_100_karakter_tc_bf_1e()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'hero_title' => str_repeat('A', 101)
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('hero_title');
    }

    public function test_admin_menyimpan_judul_hero_section_yang_kosong_tc_bf_1f()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'hero_title' => ''
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('hero_title');
    }

    public function test_admin_menyimpan_paragraf_konten_section_kurang_dari_sama_dengan_255_karakter_tc_bf_1g()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => str_repeat('B', 255)
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('section_text');
    }

    public function test_admin_menyimpan_paragraf_konten_section_lebih_dari_255_karakter_tc_bf_1h()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => str_repeat('C', 256)
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('section_text');
    }

    public function test_admin_menyimpan_paragraf_konten_section_yang_kosong_tc_bf_1i()
    {
        $this->authenticate();

        $data = array_merge($this->validData(), [
            'section_text' => ''
        ]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('section_text');
    }

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

    public function test_admin_mengunggah_gambar_konten_section_dengan_format_salah_tc_bf_1k()
    {
        Storage::fake('public');
        $this->authenticate();

        $file = UploadedFile::fake()->create('file.pdf', 100);
        $data = array_merge($this->validData(), ['profile_image' => $file]);

        $response = $this->post('/admin/kelola-hero-section', $data);

        $response->assertSessionHasErrors('profile_image');
    }

    public function test_admin_tidak_mengunggah_gambar_konten_section_tc_bf_1l()
    {
        $this->authenticate();

        $response = $this->post('/admin/kelola-hero-section', $this->validData());

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors('profile_image');
    }
}
