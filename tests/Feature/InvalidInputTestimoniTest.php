<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvalidInputTestimoniTest extends TestCase
{
    use RefreshDatabase;

    public function testimonial_requires_name_message_and_rating()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'message',
            'rating',
        ]);
    }

    public function testimonial_requires_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), [
            'message'=> 'Test',
            'rating'=> '3',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function testimonial_requires_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), [
            'name'=> 'Galang',
            'rating'=> '3',
        ]);

        $response->assertSessionHasErrors([
            'message',
        ]);
    }

    public function testimonial_requires_rating()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), [
            'name'=> 'Galang',
            'message'=> 'Test',
        ]);

        $response->assertSessionHasErrors([
            'rating',
        ]);
    }

    public function rating_must_be_between_1_and_5()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('testimonials.store'), [
            'name' => 'Galang',
            'message' => 'Test',
            'rating' => 10, // invalid
        ]);

        $response->assertSessionHasErrors('rating');
    }
}