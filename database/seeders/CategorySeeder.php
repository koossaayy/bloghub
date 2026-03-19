<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technologie', 'Design & Art', 'Développement',
            'Culture', 'Lifestyle', 'Entrepreneuriat'
        ];

        foreach ($categories as $nom) {
            Category::create([
                'nom'  => $nom,
                'slug' => Str::slug($nom),
            ]);
        }
    }
}