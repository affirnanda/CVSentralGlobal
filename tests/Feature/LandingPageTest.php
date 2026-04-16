<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_can_be_accessed()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_page_contains_title()
    {
        $response = $this->get('/');

        $response->assertSee('Solusi Sentra Global Indo');
    }

    public function test_landing_page_contains_hero_text()
    {
        $response = $this->get('/');

        $response->assertSee('The Best Solution for Your Bussines');
    }

    public function test_landing_page_contains_product_section()
    {
        $response = $this->get('/');

        $response->assertSee('Catalog Product');
    }

    public function test_landing_page_contains_testimonial_section()
    {
        $response = $this->get('/');

        $response->assertSee('Testimonial');
    }
}