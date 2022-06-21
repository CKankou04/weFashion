<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //on prendra garde de bien supprimer toutes les images avan de commencer les Seeders
        Storage::disk('local')->delete(Storage::allFiles());

        //creation des catégories homme et femme
        Category::factory()->create([
            'name' => 'homme'
        ]);
        Category::factory()->create([
            'name' => 'femme'
        ]);

        //creations des tailles pour les produits
        Size::factory()->create([
           'name' => 'XS'
       ]);
       Size::factory()->create([
           'name' => 'S'
       ]);
       Size::factory()->create([
           'name' => 'M'
       ]);
       Size::factory()->create([
           'name' => 'L'
       ]);
       Size::factory()->create([
           'name' => 'XL'
       ]);
          //creations de 80 livres à partir de la factory
          Product::factory()->count(80)->create()->each(function ($product) {

           //on associe une categorie à un produit que nous venons de creer
           $category = Category::find(rand(1,2));

           //pour chaque $book on lui associe un genre en particulier
           $product->category()->associate($category);
           $product->save();

           /* condition si l'id de catégorie est =1 on choisit il appartient à la catégorie hommen
           sinon il appartient à la catégorie femme */
           $folder = $product->category_id == 1 ? 'hommes' : 'femmes';

           $link =Str::random(12). '.jpg';

           $file = file_get_contents(public_path('images/' . $folder . '/' . rand(1, 10) . '.jpg'));
           Storage::disk('local')->put($link, $file);

           $product->picture()->create([
               'name' => 'Default', // valeur par défaut
               'link' => $link
           ]);



           $sizes =Size::pluck('id')->shuffle()->slice(0,rand(1,5))->all();


           $product->sizes()->attach($sizes);
          });
    }
}
