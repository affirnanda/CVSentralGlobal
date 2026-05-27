<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::withTrashed()->forceDelete();

        Storage::disk('public')->makeDirectory('products');

        $products = [
            'Laptop Pro Max',
            'Laptop Ultra Slim',
            'Laptop Business Edition',
            'Laptop Gamer X',
            'Laptop Creative Studio',
            'Laptop Voyager',
            'Laptop WorkMate',
            'Laptop CloudBook',
            'Laptop Vision',
            'Laptop Fusion',
        ];

        $basePrice = 4500000;
        $description = 'Laptop dummy untuk pengujian. Cocok untuk kebutuhan profesional dan presentasi bisnis.';

        foreach ($products as $index => $name) {
            $filename = 'products/laptop_' . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '.svg';
            $color = sprintf('#%06X', mt_rand(0x333333, 0xAAAAAA));

            $this->createPlaceholderImage($filename, $name, $color);

            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $basePrice + ($index * 250000),
                'rental_price' => max(500000, ($basePrice + ($index * 250000)) / 4),
                'stock' => 5,
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
            . '<text x="50%" y="410" font-family="Arial, Helvetica, sans-serif" font-size="32" fill="#ffffff" text-anchor="middle">'
            . htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
            . '</text>'
            . '<text x="50%" y="450" font-family="Arial, Helvetica, sans-serif" font-size="20" fill="#ffffff" opacity="0.8" text-anchor="middle">'
            . 'Produk Dummy CV Sentra Global'
            . '</text>'
            . '</svg>';

        file_put_contents($storagePath, $svg);
    }

    protected function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
