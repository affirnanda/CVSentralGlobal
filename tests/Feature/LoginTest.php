<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_dengan_email_dan_password_yang_benar()
    {
        $user = User::factory()->create([
            'email' => 'Super@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'Super@admin.com',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_login_dengan_email_yang_tidak_terdaftar()
    {
        $response = $this->post('/login', [
            'email' => 'unknown@test.com',
            'password' => 'admin123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'Email yang dimasukkan tidak terdaftar',
        ]);
    }

    public function test_login_dengan_format_email_salah()
    {
        $response = $this->post('/login', [
            'email' => 'superadmin',
            'password' => 'admin123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'Format email harus menggunakan @domain.***',
        ]);
    }

    public function test_login_dengan_email_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'admin123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'Silahkan isi email anda',
        ]);
    }

    public function test_login_dengan_password_yang_salah()
    {
        $response = $this->post('/login', [
            'email' => 'Super@admin.com',
            'password' => 'salah123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'password' => 'Password yang dimasukkan tidak sesuai',
        ]);
    }

    public function test_login_dengan_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => 'Super@admin.com',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'password' => 'Silahkan isi password anda',
        ]);
    }
}