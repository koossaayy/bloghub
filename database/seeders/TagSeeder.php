<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'AI', 'Web3', 'Minimalisme', 'UXDesign',
            'Productivity', 'Startup', 'FutureOfWork'
        ];

        foreach ($tags as $nom) {
            Tag::create([
                'nom'  => $nom,
                'slug' => Str::slug($nom),
            ]);
        }
    }
}