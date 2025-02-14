<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $faker = Factory::create('en_GB');
        $max= 100;
        $categories = Category::query()
            ->pluck('id')
            ->toArray();
        $units = Unit::query()
            ->pluck('id')
            ->toArray();

        for ($i=0; $i<$max; $i++){
            $data = new Product();
            $data->code         = Str::upper(Str::random(8));
            $data->name         = Str::ucfirst($faker->word).' '.Str::ucfirst($faker->word);
            $data->category_id  = $categories[rand(0, count($categories)-1)];
            $data->unit_id      = $units[rand(0, count($units)-1)];
            $data->stock        = rand(1, 10);
            $data->price        = rand(1, 10).'000';
            $data->description  = $faker->paragraph(1);
            $data->is_active    = true;
            $data->image        = 'https://picsum.photos/300?random='.($i+1);
            $data->save();
        }
    }
}
