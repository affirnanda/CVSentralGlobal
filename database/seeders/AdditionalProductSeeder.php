<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class AdditionalProductSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $adjectives = ['Smart', 'Portable', 'Ultra', 'Eco', 'Pro', 'Deluxe', 'Compact', 'Wireless', 'Advanced', 'Classic'];
        $categories = ['Charger','Adapter','Cable','Stand','Holder','Mat','Cleaner','Case','Cover','Bracket'];
        $colors = ['#7C3AED','#F59E0B','#10B981','#EF4444','#0EA5E9','#8B5CF6','#EC4899','#14B8A6'];

        for ($i = 1; $i <= 20; $i++) {
            $name = $adjectives[array_rand($adjectives)] . ' ' . $categories[array_rand($categories)];
            $description = 'Produk dummy untuk pengujian. Cocok untuk kebutuhan sehari-hari.';
            $price = rand(10000, 500000);
            $filename = 'products/add_product_' . time() . '_' . $i . '.svg';
            $color = $colors[array_rand($colors)];

            $this->createPlaceholderImage($filename, $name, $color);

            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
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
            . '<text x="50%" y="410" font-family="Arial, Helvetica, sans-serif" font-size="28" fill="#ffffff" text-anchor="middle">'
            . htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
            . '</text>'
            . '</svg>';

        file_put_contents($storagePath, $svg);
    }
}
