<?php

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Carbon\Carbon;

class VouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = [
            [
                'discount_id' => 1,
                'start_date' => '2017-4-21',
                'end_date' => '2017-6-21',
            ],
            [
                'discount_id' => 2,
                'start_date' => '2017-4-21',
                'end_date' => '2017-6-21',
            ],
            [
                'discount_id' => 3,
                'start_date' => '2017-4-21',
                'end_date' => '2017-6-21',
            ],
            [
                'discount_id' => 4,
                'start_date' => '2017-4-21',
                'end_date' => '2017-6-21',
            ],
        ];
        
        foreach ($vouchers as $voucher) {
            App\Models\Voucher::create($voucher);
        }
        
        $this->command->info('Voucher seeded!');
    }
}
