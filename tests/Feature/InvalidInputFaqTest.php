<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvalidInputFaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function faq_requires_question_and_answer()
    {
        $response = $this->post(route('faqs.store'), []);

        $response->assertSessionHasErrors(['question', 'answer']);
    }

    /** @test */
    public function faq_requires_question_only()
    {
        $response = $this->post(route('faqs.store'), [
            'answer' => 'Jawaban saja',
        ]);

        $response->assertSessionHasErrors(['question']);
    }

    /** @test */
    public function faq_requires_answer_only()
    {
        $response = $this->post(route('faqs.store'), [
            'question' => 'Pertanyaan saja',
        ]);

        $response->assertSessionHasErrors(['answer']);
    }

    /** @test */
    public function order_must_be_integer()
    {
        $response = $this->post(route('faqs.store'), [
            'question' => 'Test',
            'answer' => 'Test',
            'order' => 'salah',
        ]);

        $response->assertSessionHasErrors(['order']);
    }

    /** @test */
    public function order_cannot_be_negative()
    {
        $response = $this->post(route('faqs.store'), [
            'question' => 'Test',
            'answer' => 'Test',
            'order' => -1,
        ]);

        $response->assertSessionHasErrors(['order']);
    }
}