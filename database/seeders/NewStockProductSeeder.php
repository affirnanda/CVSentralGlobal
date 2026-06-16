<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NewStockProductSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $products = [
            'Produk Baru A',
            'Produk Baru B',
            'Produk Baru C',
            'Produk Baru D',
            'Produk Baru E',
            'Produk Baru F',
            'Produk Baru G',
            'Produk Baru H',
            'Produk Baru I',
            'Produk Baru J',
        ];

        foreach ($products as $index => $name) {
            $filename = 'products/new_stock_' . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '.svg';
            $color = sprintf('#%06X', mt_rand(0x223344, 0xAABBCC));

            $this->createPlaceholderImage($filename, $name, $color);

            Product::create([
                'name' => $name,
                'description' => 'Produk baru untuk pengujian dengan stok tetap 2.',
                'price' => 250000 + ($index * 50000),
                'rental_price' => 100000 + ($index * 20000),
                'stock' => 2,
                'image' => $filename,
            ]);
        }
    }

    protected function createPlaceholderImage(string $relativePath, string $text, string $bgColor): void
    {
        $storagePath = Storage::disk('public')->path($relativePath);
        $dir = dirname($storagePath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="640" height="480">'
            . '<rect width="100%" height="100%" fill="' . $bgColor . '" />'
            . '<rect y="360" width="100%" height="120" fill="rgba(0,0,0,0.35)" />'
            . '<text x="50%" y="410" font-family="Arial, Helvetica, sans-serif" font-size="30" fill="#ffffff" text-anchor="middle">'
            . htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
            . '</text>'
            . '<text x="50%" y="450" font-family="Arial, Helvetica, sans-serif" font-size="18" fill="#ffffff" opacity="0.85" text-anchor="middle">'
            . 'Stok 2'
            . '</text>'
            . '</svg>';

        file_put_contents($storagePath, $svg);
    }
}
