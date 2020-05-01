<?php

use App\Product;
use App\ProductCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker      = Faker::create();
        $categories = ProductCategory::whereHas('parentCategory.parentCategory')->pluck('id');

        for($i = 1; $i <= 200; $i++) {
            $product = Product::create([
                'name'        => $faker->sentence(3),
                'description' => $faker->paragraph,
                'price'       => mt_rand(99, 4999) / 100,
            ]);

            $product->categories()->sync($categories->random(mt_rand(1,3)));
        }
    }
}
