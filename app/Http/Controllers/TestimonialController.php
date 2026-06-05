<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);
        $status = $testimonial->is_approved ? 'disetujui' : 'disembunyikan';
        return back()->with('success', "Testimoni berhasil {$status}.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'message' => 'required|string|max:300',
            'rating'  => 'required|integer|min:1|max:5',
        ], [
            'name.required'    => 'Silahkan isi nama anda',
            'name.max'         => 'Penulisan nama terlalu panjang',
            'message.required' => 'Silahkan isi pesan testimoni',
            'message.max'      => 'Pesan testimoni terlalu panjang',
            'rating.required'  => 'Rating wajib dipilih.',
        ]);

        Testimonial::create([
            'name'        => $request->name,
            'message'     => $request->message,
            'rating'      => $request->rating,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Terima kasih Telah mengisi Testimoni');
    }
}
