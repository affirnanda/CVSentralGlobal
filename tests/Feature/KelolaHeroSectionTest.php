<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KelolaHeroSectionTest extends TestCase
{
    use RefreshDatabase;

    protected function adminUser()
    {
        return User::factory()->create();
    }

    /** @test */
    public function test_updating_hero_section_without_uploading_image_should_fail_validation()
    {
        Storage::fake('local');
        Storage::fake('public');

        $user = $this->adminUser();

        // 1. Initial save with an image to set up initial state
        $image = UploadedFile::fake()->image('hero_init.jpg');
        $response = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Init',
            'hero_subtitle' => 'Subtitle Init',
            'hero_image' => $image,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        // Verify it was saved
        $this->assertTrue(Storage::disk('local')->exists('landing_page.json'));
        $data = json_decode(Storage::disk('local')->get('landing_page.json'), true);
        $this->assertNotEmpty($data['hero_image']);

        // 2. Try to update without uploading an image (empty image input) -> should fail because it remains unchanged
        $response2 = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Changed',
            'hero_subtitle' => 'Subtitle Changed',
        ]);

        $response2->assertStatus(302);
        $response2->assertSessionHasErrors(['hero_image']);
        
        $errors = session('errors')->get('hero_image');
        $this->assertContains('Gambar tidak boleh sama', $errors);
    }

    /** @test */
    public function test_updating_hero_section_with_identical_image_should_fail_validation()
    {
        Storage::fake('local');
        Storage::fake('public');

        $user = $this->adminUser();

        // Use same content for both uploads to check MD5 matching
        // Create two faked images with exactly the same content/pixels
        $image1 = UploadedFile::fake()->image('hero.jpg', 100, 100);
        $image2 = UploadedFile::fake()->image('hero_same.jpg', 100, 100);

        // 1. Initial save
        $response = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Init',
            'hero_subtitle' => 'Subtitle Init',
            'hero_image' => $image1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        // 2. Update with the exact same image content -> should fail validation
        $response2 = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Changed',
            'hero_subtitle' => 'Subtitle Changed',
            'hero_image' => $image2,
        ]);

        $response2->assertStatus(302);
        $response2->assertSessionHasErrors(['hero_image']);

        $errors = session('errors')->get('hero_image');
        $this->assertContains('Gambar tidak boleh sama', $errors);
    }

    /** @test */
    public function test_updating_hero_section_with_different_image_should_succeed()
    {
        Storage::fake('local');
        Storage::fake('public');

        $user = $this->adminUser();

        // 1. Initial save
        $image1 = UploadedFile::fake()->image('hero_first.jpg', 100, 100);
        $response = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Init',
            'hero_subtitle' => 'Subtitle Init',
            'hero_image' => $image1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $dataBefore = json_decode(Storage::disk('local')->get('landing_page.json'), true);
        $firstFilename = $dataBefore['hero_image'];

        // 2. Update with a different image -> should succeed
        // Create an image with different size to ensure different content/hash
        $image2 = UploadedFile::fake()->image('hero_second.jpg', 200, 200);
        $response2 = $this->actingAs($user)->post(route('admin.hero-section.update'), [
            'hero_title' => 'Title Final',
            'hero_subtitle' => 'Subtitle Final',
            'hero_image' => $image2,
        ]);

        $response2->assertStatus(302);
        $response2->assertSessionHasNoErrors();

        // Verify the image was updated in JSON
        $dataAfter = json_decode(Storage::disk('local')->get('landing_page.json'), true);
        $this->assertNotEquals($firstFilename, $dataAfter['hero_image']);
        $this->assertEquals('Title Final', $dataAfter['hero_title']);
    }
}
