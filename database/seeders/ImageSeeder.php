<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = new Image;
        $image->name = "coca.jpg";
        $image->url = "0456d3130f9b516ce8f16cceee5f6ff6.jpg";
        $image->product_id = 1;
        
        // migra el objeto a la db
        $image->save();

        $image = new Image;
        $image->name = "sprite.jpg";
        $image->url = "1a7f8d19754130d9a25e06fad8e2e7f3.jpg";
        $image->product_id = 2;
        
        // migra el objeto a la db
        $image->save();

        $image = new Image;
        $image->name = "fanta.jpg";
        $image->url = "135115825e22c2ead2cc66da124f6a44.jpg";
        $image->product_id = 3;
        
        // migra el objeto a la db
        $image->save();

        $image = new Image;
        $image->name = "specials-1.png";
        $image->url = "41b0fe13e648b8fa2279d2f405638f88.png";
        $image->product_id = 4;
        
        // migra el objeto a la db
        $image->save();

        $image = new Image;
        $image->name = "specials-2.png";
        $image->url = "1998501c5d4b3e31b477616e6eb080ee.png";
        $image->product_id = 4;
        
        // migra el objeto a la db
        $image->save();

        $image = new Image;
        $image->name = "specials-3.png";
        $image->url = "b7baf2d69ad5535165db5eaf46c55ac8.png";
        $image->product_id = 4;
        
        // migra el objeto a la db
        $image->save();
    }
}
