<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Product::create([
            'product_name' => 'Rinso 500gr',
            'unit' => 'pcs'
        ]);

        Product::create([
            'product_name' => 'Molto 125gr',
            'unit' => 'pcs'
        ]);

        Product::create([
            'product_name' => 'Nuvo Batang 190gr',
            'unit' => 'pcs'
        ]);

        Product::create([
            'product_name' => 'Minyak Bimoli 2L',
            'unit' => 'pcs'
        ]);

        Product::create([
            'product_name' => 'Minyak Sunco 2L',
            'unit' => 'pcs'
        ]);
    }
}
