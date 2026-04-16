<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs.
     */
    public function index()
    {
        $faqs = Faq::orderBy('order')->orderBy('id')->get();
        return view('faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'order'    => 'nullable|integer|min:0',
        ]);

        Faq::create([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'is_active' => $request->has('is_active'),
            'order'     => $request->order ?? 0,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit(Faq $faq)
    {
        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'order'    => 'nullable|integer|min:0',
        ]);

        $faq->update([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'is_active' => $request->has('is_active'),
            'order'     => $request->order ?? 0,
        ]);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}
