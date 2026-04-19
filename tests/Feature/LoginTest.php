<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_bisa_login_dengan_data_valid()
    {
        $user = User::factory()->create([
            'email' => 'super@admin.com',
            'password' => bcrypt('admin123')
        ]);

        $response = $this->post('/login', [
            'email' => 'super@admin.com',
            'password' => 'admin123'
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_tidak_bisa_login_password_salah()
    {
        $user = User::factory()->create([
            'email' => 'super@admin.com',
            'password' => bcrypt('admin123')
        ]);

        $response = $this->post('/login', [
            'email' => 'super@admin.com',
            'password' => 'salahpassword'
        ]);

        $this->assertGuest();
    }
}