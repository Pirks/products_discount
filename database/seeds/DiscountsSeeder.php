<?php

use Illuminate\Database\Seeder;
Use App\Models\Discount;

class DiscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discounts = [10, 15, 20, 25];
        
        foreach ($discounts as $discount) {
            Discount::create(['percents' => $discount]);
        }
        
        $this->command->info('Discounts seeded!');
    }
}
