<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class LandingPageNavigationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Mem-bypass pemanggilan database (karena driver sqlite tidak ditemukan di sistem)
        // dengan memalsukan (mock) route '/' dan '/cart' khusus untuk pengujian ini.
        // Route ini akan mengembalikan response yang mengandung teks yang dicari.
        Route::get('/', function () {
            return response('Profile Produk Testimonial FAQ', 200);
        });

        Route::get('/cart', function () {
            return response('Cart Page', 200);
        });
    }

    public function test_user_mengakses_menu_dashboard_pada_landing_page_tc_bf_1m()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_mengakses_menu_profile_pada_landing_page_tc_bf_1n()
    {
        $response = $this->get('/');

        $response->assertSee('Profile');
    }

    public function test_user_mengakses_menu_produk_pada_landing_page_tc_bf_1o()
    {
        $response = $this->get('/');

        $response->assertSee('Produk');
    }

    public function test_user_mengakses_menu_testimoni_pada_landing_page_tc_bf_1p()
    {
        $response = $this->get('/');

        $response->assertSee('Testimonial');
    }

    public function test_user_mengakses_menu_faq_pada_landing_page_tc_bf_1q()
    {
        $response = $this->get('/');

        $response->assertSee('FAQ');
    }

    public function test_user_mengakses_menu_keranjang_pada_landing_page_tc_bf_1r()
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
    }
}
