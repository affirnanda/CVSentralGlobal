<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'  => 'Apa itu CV Sentral Global?',
                'answer'    => 'CV Sentral Global adalah perusahaan yang bergerak di bidang jasa dan teknologi, melayani berbagai kebutuhan bisnis klien kami secara profesional.',
                'is_active' => true,
                'order'     => 1,
            ],
            [
                'question'  => 'Bagaimana cara menghubungi tim kami?',
                'answer'    => 'Anda dapat menghubungi kami melalui form kontak di website, email resmi perusahaan, atau melalui nomor telepon yang tersedia di halaman kontak.',
                'is_active' => true,
                'order'     => 2,
            ],
            [
                'question'  => 'Apa saja layanan yang ditawarkan?',
                'answer'    => 'Kami menawarkan berbagai layanan meliputi konsultasi bisnis, pengembangan teknologi, dan solusi terpadu sesuai kebutuhan perusahaan Anda.',
                'is_active' => true,
                'order'     => 3,
            ],
            [
                'question'  => 'Berapa lama proses penyelesaian proyek?',
                'answer'    => 'Durasi pengerjaan proyek bergantung pada kompleksitas dan kebutuhan. Kami akan memberikan estimasi waktu yang jelas pada saat konsultasi awal.',
                'is_active' => true,
                'order'     => 4,
            ],
            [
                'question'  => 'Apakah ada garansi untuk layanan yang diberikan?',
                'answer'    => 'Ya, kami memberikan garansi kepuasan dan after-sales support untuk setiap layanan yang kami berikan kepada klien.',
                'is_active' => false,
                'order'     => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
