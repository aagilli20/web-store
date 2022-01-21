<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new Product;
        $product->name = "Coca Cola";
        $product->price = 120;
        $product->stock = 100;
        $product->description = "Gaseosa Cola";
        $product->status = "new";
        $product->warranty = false;
        // migra el objeto a la db
        $product->save();

        $product = new Product;
        $product->name = "Sprite";
        $product->price = 115;
        $product->stock = 90;
        $product->description = "Gaseosa Lima";
        $product->status = "new";
        $product->warranty = false;
        // migra el objeto a la db
        $product->save();

        $product = new Product;
        $product->name = "Fanta";
        $product->price = 110;
        $product->stock = 60;
        $product->description = "Gaseosa sabor naranja";
        $product->status = "new";
        $product->warranty = false;
        // migra el objeto a la db
        $product->save();

        $product = new Product;
        $product->name = "Plato principal";
        $product->price = 300;
        $product->stock = 15;
        $product->description = "El plato principal varía todos los días";
        $product->status = "new";
        $product->warranty = true;
        // migra el objeto a la db
        $product->save();
    }
}
