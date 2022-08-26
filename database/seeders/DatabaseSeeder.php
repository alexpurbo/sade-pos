<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
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

        User::create([
            'name' => 'alex purbo',
            'email' => 'alex@mail.com',
            'password' => md5('pswdalex'),
        ]);

        Merchant::create([
            'id_user' => 1,
            'merchant_name' => 'Purboshop',
            'email' => 'purbo@mail.com',
            'phone_number' => '089456789435',
            'merchant_type' => '12',
            'is_verified' => true,
            'is_star_merchant' => true,
            'is_banned' => false

        ]);

        Transaction::create([
            'id_merchant' => '1',
            'date_transaction' => '2022-08-25',
            'type' => 'buy',
            'total'    => '6000'
        ]);

        TransactionDetail::create([
            'id_transaction' => '1',
            'id_product' => '2',
            'quantity' => 2,
            'price' => 3000,
            'total' => 6000
        ]);
    }
}
