<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->orderBy('id')->get();
        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        $maxOrder = Faq::count() + 1;
        return view('faqs.create', compact('maxOrder'));
    }

    public function store(Request $request)
    {
        $messages = [
            'question.required' => 'Silahkan isi pertanyaan',
            'question.max' => 'Pertanyaan terlalu panjang',
            'answer.required' => 'Silahkan isi jawaban',
            'answer.max' => 'Jawaban terlalu panjang',
        ];

        $request->validate([
            'question' => 'required|string|max:100',
            'answer' => 'required|string|max:300',
            'order' => 'required|integer|min:1',
        ], $messages);

        $targetOrder = $request->order;

        Faq::where('order', '>=', $targetOrder)->increment('order');

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $request->has('is_active'),
            'order' => $targetOrder,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit(Faq $faq)
    {
        $maxOrder = Faq::count();
        if ($maxOrder < 1)
            $maxOrder = 1;

        return view('faqs.edit', compact('faq', 'maxOrder'));
    }

    public function update(Request $request, Faq $faq)
    {
        $messages = [
            'question.required' => 'Silahkan isi pertanyaan',
            'question.max' => 'Pertanyaan terlalu panjang',
            'answer.required' => 'Silahkan isi jawaban',
            'answer.max' => 'Jawaban terlalu panjang',
        ];

        $request->validate([
            'question' => 'required|string|max:100',
            'answer' => 'required|string|max:300',
            'order' => 'required|integer|min:1',
        ], $messages);

        $targetOrder = $request->order;
        $oldOrder = $faq->order;

        if ($targetOrder != $oldOrder) {
            if ($targetOrder < $oldOrder) {
                Faq::whereBetween('order', [$targetOrder, $oldOrder - 1])->increment('order');
            } else {
                Faq::whereBetween('order', [$oldOrder + 1, $targetOrder])->decrement('order');
            }
        }

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $request->has('is_active'),
            'order' => $targetOrder,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq)
    {
        $deletedOrder = $faq->order;
        $faq->delete();

        Faq::where('order', '>', $deletedOrder)->decrement('order');

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}
