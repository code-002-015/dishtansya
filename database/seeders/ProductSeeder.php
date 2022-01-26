<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10; $i++){
            \App\Models\Product::create([
                'name' => 'Product '.$i,
                'available_stock' => 10
            ]);
        }
    }
}
