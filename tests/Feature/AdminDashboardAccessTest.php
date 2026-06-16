<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AdminDashboardAccessTest extends TestCase
{
    /**
     * TC-BF-3A
     * Admin mengakses dashboard dengan session aktif
     */
    public function test_admin_mengakses_dashboard_dengan_session_aktif_tc_bf_3a()
    {
        // Membypass database dengan membuat instance User secara langsung di memori
        $admin = new User();
        $admin->id = 1;
        $admin->role = 'admin';
        $admin->email_verified_at = now(); // Bypass middleware 'verified'

        // Login sebagai admin dan akses dashboard
        $response = $this->actingAs($admin)->get('/dashboard');

        // Memastikan berhasil diarahkan ke halaman dashboard (Status 200 OK)
        $response->assertStatus(200);
    }

    /**
     * TC-BF-3B
     * Admin mengakses dashboard dengan session kadaluarsa
     */
    public function test_admin_mengakses_dashboard_dengan_session_kadaluarsa_tc_bf_3b()
    {
        // Akses dashboard tanpa login / session kadaluarsa
        $response = $this->get('/dashboard');

        // Memastikan sistem mengarahkan (redirect) ke halaman login
        $response->assertRedirect('/login');
    }
}
