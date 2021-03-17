<?php

use Illuminate\Database\Seeder;
use App\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0; $i <= 100; $i++) {
            factory(Product::class, 100)->create();
        }
    }
}
