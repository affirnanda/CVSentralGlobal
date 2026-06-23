<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_dapat_submit_testimonial()
    {
        $response = $this->post(route('testimonials.store'), [
            'name' => 'Galang',
            'message' => 'Pelayanan sangat baik',
            'rating' => 5,
        ]);

        $response->assertSessionHas(
            'success',
            'Terima kasih Telah mengisi Testimoni'
        );

        $this->assertDatabaseHas('testimonials', [
            'name' => 'Galang',
            'message' => 'Pelayanan sangat baik',
            'rating' => 5,
            'is_approved' => false,
        ]);
    }

    public function test_user_dapat_submit_testimonial_dengan_100_characters_pada_nama()
    {
        $response = $this->post(route('testimonials.store'), [
            'name' => str_repeat('A', 100),
            'message' => 'Testimoni',
            'rating' => 5,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonials', [
            'name' => str_repeat('A', 100),
        ]);
    }

    public function test_user_tidak_dapat_submit_testimonial_dengan_nama_lebih_dari_100_characters()
    {
        $response = $this->from('/')
            ->post(route('testimonials.store'), [
                'name' => str_repeat('A', 101),
                'message' => 'Testimoni',
                'rating' => 5,
            ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(
            'Penulisan nama terlalu panjang',
            session('errors')->first('name')
        );
    }

    public function test_user_tidak_dapat_submit_jika_nama_kosong()
    {
        $response = $this->from('/')
            ->post(route('testimonials.store'), [
                'name' => '',
                'message' => 'Testimoni',
                'rating' => 5,
            ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(
            'Silahkan isi nama anda',
            session('errors')->first('name')
        );
    }

    public function test_user_dapat_submit_testimonial_dengan_pesan_200_characters()
    {
        $response = $this->post(route('testimonials.store'), [
            'name' => 'Galang',
            'message' => str_repeat('A', 200),
            'rating' => 5,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonials', [
            'name' => 'Galang',
        ]);
    }

    public function test_user_tidak_dapat_submit_testimonial_dengan_pesan_lebih_dari_200_characters()
    {
        $response = $this->from('/')
            ->post(route('testimonials.store'), [
                'name' => 'Galang',
                'message' => str_repeat('A', 201),
                'rating' => 5,
            ]);

        $response->assertSessionHasErrors('message');

        $this->assertEquals(
            'Pesan testimoni terlalu panjang',
            session('errors')->first('message')
        );
    }

    public function test_user_tidak_dapat_submit_dengan_message_kosong()
    {
        $response = $this->from('/')
            ->post(route('testimonials.store'), [
                'name' => 'Galang',
                'message' => '',
                'rating' => 5,
            ]);

        $response->assertSessionHasErrors('message');

        $this->assertEquals(
            'Silahkan isi pesan testimoni',
            session('errors')->first('message')
        );
    }
}