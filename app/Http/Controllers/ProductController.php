<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'required|string',
            'price'       => ['bail', 'required', 'regex:/^[0-9]+$/', 'numeric', 'min:1', 'max:100000000'],
            'stock'       => ['bail', 'required', 'regex:/^[0-9]+$/', 'numeric', 'min:1', 'max:10000000'],
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'name.max' => 'Nama produk terlalu panjang',
            'price.required' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.numeric' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.min' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.regex' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.max' => 'Nominal harga produk terlalu besar',
            'stock.required' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.numeric' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.min' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.regex' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.max' => 'Jumlah stok melebihi batas',
            'image.mimes' => 'Format gambar yang diunggah tidak sesuai',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()->route('welcome')->with('success', 'Produk berhasil ditambahkan dan kini tampil di landing page!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'required|string',
            'price'       => ['bail', 'required', 'regex:/^[0-9]+$/', 'numeric', 'min:1', 'max:100000000'],
            'stock'       => ['bail', 'required', 'regex:/^[0-9]+$/', 'numeric', 'min:1', 'max:10000000'],
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'name.max' => 'Nama produk terlalu panjang',
            'price.required' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.numeric' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.min' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.regex' => 'Harga tidak boleh bernilai 0 atau negatif',
            'price.max' => 'Nominal harga produk terlalu besar',
            'stock.required' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.numeric' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.min' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.regex' => 'Stok tidak boleh bernial 0 atau negatif',
            'stock.max' => 'Jumlah stok melebihi batas',
            'image.mimes' => 'Format gambar yang diunggah tidak sesuai',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil dihapus!');
    }
    public function welcome()
    {
        // Mengambil data landing page (JSON)
        $landingData = [];
        if (Storage::exists('landing_page.json')) {
            $landingData = json_decode(Storage::get('landing_page.json'), true) ?? [];
        }

        $keranjang = session()->get('keranjang', []);

        // Mengambil 8 produk terbaru
        $products = \App\Models\Product::latest()->take(8)->get();
        
        // Mengambil testimoni yang sudah disetujui admin
        $testimonials = \App\Models\Testimonial::where('is_approved', true)->latest()->take(6)->get();

        $faqs = Faq::where('is_active', true)->orderBy('order')->orderBy('id')->get();
        
        return view('welcome', compact('products', 'testimonials', 'faqs', 'landingData','keranjang'));
    }
    public function katalog()
    {
        // Ambil semua produk dengan pagination (12 per halaman)
        $products = Product::latest()->paginate(12);
        $keranjang = session()->get('keranjang', []);

        return view('products.katalog', compact('products', 'keranjang'));
    }

    public function show(Product $product)
{
    $related = Product::where('id', '!=', $product->id)
                ->latest()
                ->take(4)
                ->get();

    $keranjang = session()->get('keranjang', []);
    return view('products.show', compact('product', 'related','keranjang'));
}
}