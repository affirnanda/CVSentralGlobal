<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidInputFaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_create_faq_with_valid_input()
    {
        $response = $this->post(route('faqs.store'), [
            'question' => 'Apa itu Laravel?',
            'answer' => 'Framework PHP',
            'order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'question' => 'Apa itu Laravel?',
            'answer' => 'Framework PHP',
            'order' => 1,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function test_can_update_faq_with_valid_input()
    {
        $faq = Faq::factory()->create();

        $response = $this->put(route('faqs.update', $faq->id), [
            'question' => 'Update pertanyaan',
            'answer' => 'Update jawaban',
            'order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Update pertanyaan',
            'answer' => 'Update jawaban',
            'order' => 2,
        ]);
    }

    /** @test */
    public function test_can_delete_faq()
    {
        $faq = Faq::factory()->create();

        $response = $this->delete(route('faqs.destroy', $faq->id));

        $response->assertRedirect(route('faqs.index'));

        $this->assertDatabaseMissing('faqs', [
            'id' => $faq->id,
        ]);
    }
}