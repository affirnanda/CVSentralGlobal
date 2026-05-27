<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:100',
            'description'   => 'required|string',
            'price'         => 'required',
            'rental_price'  => 'required',
            'stock'         => 'required',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'name.max' => 'Nama produk terlalu panjang',
            'price.required' => 'Harga beli tidak boleh kosong',
            'rental_price.required' => 'Harga sewa tidak boleh kosong',
            'stock.required' => 'Stok tidak boleh kosong',
            'image.mimes' => 'Format gambar yang diunggah tidak sesuai',
        ]);

        $validator->after(function ($validator) use ($request) {
            $this->validatePriceAndStock($validator, $request);
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $price        = $this->normalizeNumericValue($request->input('price'));
        $rentalPrice  = $this->normalizeNumericValue($request->input('rental_price'));
        $stock        = $this->normalizeNumericValue($request->input('stock'));

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $price,
            'rental_price'  => $rentalPrice,
            'stock'         => $stock,
            'image'         => $imagePath,
        ]);

        return redirect()->route('welcome')->with('success', 'Produk berhasil ditambahkan dan kini tampil di landing page!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:100',
            'description'   => 'required|string',
            'price'         => 'required',
            'rental_price'  => 'required',
            'stock'         => 'required',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'name.max' => 'Nama produk terlalu panjang',
            'price.required' => 'Harga beli tidak boleh kosong',
            'rental_price.required' => 'Harga sewa tidak boleh kosong',
            'stock.required' => 'Stok tidak boleh kosong',
            'image.mimes' => 'Format gambar yang diunggah tidak sesuai',
        ]);

        $validator->after(function ($validator) use ($request) {
            $this->validatePriceAndStock($validator, $request);
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $price        = $this->normalizeNumericValue($request->input('price'));
        $rentalPrice  = $this->normalizeNumericValue($request->input('rental_price'));
        $stock        = $this->normalizeNumericValue($request->input('stock'));

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $price,
            'rental_price'  => $rentalPrice,
            'stock'         => $stock,
            'image'         => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('sukses', 'Product berhasil diupdate!');
    }

    private function validatePriceAndStock($validator, Request $request): void
    {
        $checks = [
            'price' => ['label' => 'Harga beli', 'max' => 100000000],
            'rental_price' => ['label' => 'Harga sewa', 'max' => 100000000],
            'stock' => ['label' => 'Stok', 'max' => 10000000],
        ];

        foreach ($checks as $field => $config) {
            $value = $request->input($field);

            if (! is_numeric($value)) {
                continue;
            }

            $number = (float) $value;

            if ($number <= 0) {
                $validator->errors()->add($field, $config['label'] . ' tidak boleh bernilai 0 atau negatif');
                continue;
            }

            if ($number > $config['max']) {
                $validator->errors()->add($field, 'Nominal ' . strtolower($config['label']) . ' terlalu besar');
            }
        }
    }

    private function normalizeNumericValue($value): float
    {
        if (! is_numeric($value)) {
            return 0;
        }

        $number = (float) $value;

        return $number < 0 ? 0 : $number;
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('sukses', 'Product berhasil dihapus!');
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