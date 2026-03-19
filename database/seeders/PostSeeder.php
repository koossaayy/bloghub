<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $auteur = User::where('email', 'calebdassi@gmail.com')->first();
        $admin = User::where('email', 'admin@bloghub.com')->first();

        $tech = Category::where('slug', 'technologie')->first();
        $design = Category::where('slug', 'design-art')->first();
        $dev = Category::where('slug', 'developpement')->first();
        $culture = Category::where('slug', 'culture')->first();
        $lifestyle = Category::where('slug', 'lifestyle')->first();
        $entrepr = Category::where('slug', 'entrepreneuriat')->first();

        $tagAI = Tag::where('slug', 'ai')->first();
        $tagWeb3 = Tag::where('slug', 'web3')->first();
        $tagUX = Tag::where('slug', 'uxdesign')->first();
        $tagStartup = Tag::where('slug', 'startup')->first();
        $tagProd = Tag::where('slug', 'productivity')->first();
        $tagMini = Tag::where('slug', 'minimalisme')->first();

        $posts = [
            [
                'user_id'     => $auteur->id,
                'category_id' => $tech->id,
                'titre'       => "L'essor de la Tech au Cameroun : Yaoundé devient un hub numérique",
                'contenu'     => "Le Cameroun connaît une révolution numérique sans précédent. La capitale Yaoundé, avec ses nombreuses startups et incubateurs comme le Silicon Mountain de Buea, s'impose progressivement comme un acteur incontournable de l'écosystème tech africain.

De jeunes entrepreneurs camerounais développent des solutions innovantes adaptées aux réalités locales. Des applications de paiement mobile aux plateformes d'e-commerce, en passant par les solutions agricoles connectées, la créativité technologique camerounaise ne cesse de surprendre.

## Les acteurs clés

L'incubateur ActivSpaces à Buea a déjà accompagné plus de 200 startups depuis sa création. Des noms comme Njorku, le LinkedIn africain créé par un Camerounais, ou encore PayDunya, montrent que le talent local peut rivaliser avec les meilleures solutions mondiales.

## Les défis à relever

Malgré cet enthousiasme, des défis persistent : l'accès à internet reste limité dans les zones rurales, et le financement des startups demeure difficile. Mais avec l'engagement du gouvernement dans la stratégie nationale du numérique, l'avenir s'annonce prometteur.",
                'image'       => 'https://econuma.com/storage/articles/1755775282DMkz0ZvNeuZnYUe3d3fqtDwhPj5whPDg.jpg',
                'statut'      => 'publie',
                'tags'        => [$tagAI->id, $tagStartup->id],
            ],
            [
                'user_id'     => $auteur->id,
                'category_id' => $culture->id,
                'titre'       => "La musique camerounaise à l'ère du streaming : makossa et bikutsi conquièrent le monde",
                'contenu'     => "La musique camerounaise, riche de ses rythmes envoûtants, connaît une nouvelle jeunesse grâce aux plateformes de streaming. Le makossa et le bikutsi, ces genres musicaux nés au Cameroun, séduisent désormais des millions d'auditeurs à travers le monde.

Des artistes comme Charlotte Dipanda, Locko ou encore Tenor portent haut les couleurs de la musique camerounaise sur Spotify, Apple Music et YouTube.

## Le bikutsi, rythme ancestral devenu mondial

Originaire des Beti du Centre-Cameroun, le bikutsi est bien plus qu'un simple genre musical. C'est une expression culturelle profonde qui raconte l'histoire, les joies et les peines d'un peuple.

## L'avenir de la musique camerounaise

Avec l'émergence de producteurs talentueux basés à Douala et Yaoundé, le Cameroun est en passe de devenir une capitale musicale africaine incontournable.",
                'image'       => 'https://musique.rfi.fr/sites/default/files/thumbnails/image/charlotte-dipanda-c-universal-music-africa-the-ghost_0.jpg',
                'statut'      => 'publie',
                'tags'        => [$tagMini->id],
            ],
            [
                'user_id'     => $admin->id,
                'category_id' => $entrepr->id,
                'titre'       => "Entrepreneuriat au Cameroun : 5 conseils pour lancer sa startup en 2024",
                'contenu'     => "Lancer une startup au Cameroun en 2024 n'a jamais été aussi accessible. Avec un écosystème entrepreneurial en plein essor, des incubateurs actifs et une jeunesse connectée, les opportunités sont nombreuses.

## 1. Identifier un problème local réel

Les meilleures startups camerounaises ont résolu des problèmes concrets : l'accès aux soins de santé, le transport urbain à Douala, la vente des produits agricoles.

## 2. Rejoindre un incubateur

Des structures comme ActivSpaces à Buea, CamInTech à Yaoundé ou l'ANTIC offrent des ressources précieuses : mentorat, espace de travail, mise en réseau avec des investisseurs.

## 3. Maîtriser le mobile money

Au Cameroun, MTN Mobile Money et Orange Money sont incontournables. Intégrez ces solutions de paiement dès le début de votre projet.

## 4. Construire votre réseau

Les événements comme le Cameroon Digital Week ou les meetups tech de Yaoundé et Douala sont des occasions en or.

## 5. Penser régional dès le départ

Le marché camerounais est un tremplin vers l'Afrique centrale.",
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfnQOdtLxsO5mkoZmm44ynGcnoYFtdFTZSag&s',
                'statut'      => 'publie',
                'tags'        => [$tagStartup->id, $tagProd->id],
            ],
            [
                'user_id'     => $auteur->id,
                'category_id' => $dev->id,
                'titre'       => "Laravel au Cameroun : pourquoi les développeurs locaux l'adoptent massivement",
                'contenu'     => "Laravel s'impose comme le framework PHP préféré des développeurs camerounais. Dans les écoles de code de Yaoundé et Douala, dans les bootcamps et les universités, Laravel est enseigné comme la référence du développement web moderne.

## Pourquoi Laravel ?

Sa syntaxe élégante, sa documentation complète et son écosystème riche en font un outil idéal pour les développeurs qui veulent aller vite sans sacrifier la qualité.

## La communauté camerounaise Laravel

Des groupes WhatsApp et Telegram réunissant des centaines de développeurs camerounais se sont formés autour de Laravel.

## Les projets réalisés

De nombreuses plateformes camerounaises tournent sous Laravel : des sites e-commerce, des systèmes de gestion scolaire, des applications de réservation de transport.",
                'image'       => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800',
                'statut'      => 'publie',
                'tags'        => [$tagWeb3->id, $tagAI->id],
            ],
            [
                'user_id'     => $admin->id,
                'category_id' => $lifestyle->id,
                'titre'       => "Vivre à Yaoundé : le guide du digital nomad camerounais",
                'contenu'     => "Yaoundé, la ville aux sept collines, s'impose de plus en plus comme une destination de choix pour les digital nomads. Entre ses espaces de coworking modernes, sa gastronomie riche et son climat agréable, la capitale camerounaise a tout pour séduire.

## Les meilleurs spots de travail

Le quartier de Bastos regorge de cafés branchés où il fait bon travailler tout en savourant un café arabica des hauts plateaux de l'Ouest Cameroun.

## Se nourrir en travaillant

La cuisine camerounaise est une invitation au voyage. Entre le ndolé, le poulet DG et l'eru, les restaurants du centre-ville proposent des repas complets à moins de 2000 FCFA.

## Se déplacer dans la ville

Les motos-taxis et les taxis jaunes permettent de se déplacer facilement. Des applications comme Yango commencent également à se faire une place dans le paysage urbain.",
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrp7e4fOnNYO9fNBJwaVRCECG-jW87FYB31Q&s',
                'statut'      => 'publie',
                'tags'        => [$tagProd->id, $tagMini->id],
            ],
            [
                'user_id'     => $auteur->id,
                'category_id' => $design->id,
                'titre'       => "Design africain : comment les créatifs camerounais réinventent l'identité visuelle",
                'contenu'     => "Une nouvelle génération de designers camerounais s'impose sur la scène internationale. Armés de leurs tablettes graphiques et de leur riche héritage culturel, ils créent un langage visuel unique qui mêle tradition africaine et modernité numérique.

## L'influence des motifs traditionnels

Les motifs Bamiléké, Bassa et Fang inspirent une nouvelle génération de créations visuelles. Ces géométries ancestrales, réinterprétées avec les outils du design moderne, donnent naissance à des identités visuelles d'une richesse inégalée.

## Les designers camerounais à suivre

Des talents formés à l'École Supérieure des Arts et de l'Industrie Graphique de Yaoundé rayonnent désormais bien au-delà des frontières camerounaises.

## L'UX Design, nouveau terrain de jeu

L'UX Design s'impose comme une discipline en plein essor au Cameroun. Des bootcamps spécialisés forment chaque année des dizaines de designers UX.",
                'image'       => 'https://ecole-du-digital.com/_next/image/?url=https%3A%2F%2Fstorage.googleapis.com%2Fstrapi-esd-prod%2Fcms%2Fmotion_designer_a14cd55c1a%2Fmotion_designer_a14cd55c1a.png&w=1920&q=90',
                'statut'      => 'publie',
                'tags'        => [$tagUX->id, $tagMini->id],
            ],
        ];

        foreach ($posts as $postData) {
            $tags = $postData['tags'];
            unset($postData['tags']);
            $postData['slug'] = Str::slug($postData['titre']) . '-' . uniqid();
            $post = Post::create($postData);
            $post->tags()->sync($tags);
        }
    }
}