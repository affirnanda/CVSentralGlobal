<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // ─── ADMIN ────────────────────────────────────────────────────────────────

    /** Daftar semua testimoni di panel admin */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /** Toggle approve/reject testimoni */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);
        $status = $testimonial->is_approved ? 'disetujui' : 'disembunyikan';
        return back()->with('success', "Testimoni berhasil {$status}.");
    }

    /** Hapus testimoni */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }

    // ─── PUBLIC (Landing Page) ─────────────────────────────────────────────────

    /** Simpan testimoni dari form landing page */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'rating'  => 'required|integer|min:1|max:5',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'message.required' => 'Pesan testimoni wajib diisi.',
            'rating.required'  => 'Rating wajib dipilih.',
        ]);

        Testimonial::create([
            'name'        => $request->name,
            'message'     => $request->message,
            'rating'      => $request->rating,
            'is_approved' => false, // menunggu persetujuan admin
        ]);

        return redirect()->route('welcome')
            ->with('success', 'Terima kasih! Testimoni Anda sedang menunggu persetujuan admin.');
    }
}
