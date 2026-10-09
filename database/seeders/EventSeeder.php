<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'creator_id' => 1,
                'title' => 'Belajar Mengelola Emosi',
                'slug' => 'belajar-mengelola-emosi',
                'description' => 'Emosi terkadang bisa menjadi pisau bermata dua',
                'max_capacity' => 10,
                'allowed_domains' => ['newjeans.com', 'testing.com'],
            ],
            [
                'creator_id' => 2,
                'title' => 'Memasak Rendang Tanpa Dicuri Wong Palembang',
                'slug' => 'memasak-rendang-tanpa-dicuri-wong-palembang',
                'description' => 'Palembang mempunyai citra buruk setelah tiktoker willy salim....',
                'max_capacity' => 20,
                'allowed_domains' => ['palembang.com', 'newjeans.com'],
            ],
            [
                'creator_id' => 3,
                'title' => 'Kesadaran Teknologi Ditengah Gempuran AI',
                'slug' => 'kesadaran-teknologi-ditengah-gempuran-ai',
                'description' => 'Merebaknya AI membuat kita semakin bingung akan berita yang tersebar',
                'max_capacity' => 20,
                'allowed_domains' => ['gmail.com', 'newjeans.com'],
            ],
        ];

        foreach ($events as $e) {
            Event::create($e);
        }
    }
}
