<?php

use Illuminate\Database\Seeder;
Use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Product 1',
                'price' => '100.15',
            ],
            [
                'name' => 'Product 2',
                'price' => '846.00',
            ],
            [
                'name' => 'Product 3',
                'price' => '65.11',
            ],
        ];
        
        foreach ($products as $product) {
            App\Models\Product::create($product);
        }
        
        $this->command->info('Products seeded!');
    }
}
