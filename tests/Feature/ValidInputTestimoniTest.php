<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidInputTestimoniTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_testimonial()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), [
            'name' => 'Galang',
            'message' => 'Pelayanan sangat bagus!',
            'rating' => 5,
        ]);

        $response->assertRedirect(route('welcome'));

        $this->assertDatabaseHas('testimonials', [
            'name' => 'Galang',
            'message' => 'Pelayanan sangat bagus!',
            'rating' => 5,
            'is_approved' => false,
        ]);
    }
}