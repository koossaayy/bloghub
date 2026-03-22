<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class UpdateCategorySeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'Technologie' => 'Actualités tech, innovations numériques et tendances du monde connecté.',
            'Design & Art' => 'Créativité, esthétique, arts visuels et design graphique africain.',
            'Développement' => 'Programmation, frameworks, bonnes pratiques et tutoriels dev.',
            'Culture' => 'Musique, cinéma, littérature et patrimoine culturel camerounais.',
            'Lifestyle' => 'Mode de vie, bien-être, voyages et conseils du quotidien.',
            'Entrepreneuriat' => 'Business, startups, conseils pour entreprendre en Afrique.',
        ];

        foreach ($descriptions as $nom => $description) {
            Category::where('nom', $nom)->update(['description' => $description]);
        }
    }
}