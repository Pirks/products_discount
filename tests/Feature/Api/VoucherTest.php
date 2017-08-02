<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoucherTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    /**
     * Test voucher creation
     *
     * @param array $data
     * @param int $status
     * @dataProvider testCreateProvider
     * @return void
     */
    public function testCreate(array $data, $status)
    {
        $this->artisan('db:seed');
        $response = $this->call('POST', route('voucher.store'), $data);

        $response->assertStatus($status);
    }

    /**
     *
     * @return array
     */
    public function testCreateProvider()
    {
        return [
            [['discount_id' => 1, 'start_date' => '2017-07-01', 'end_date' => '2017-07-30'], 200],
            [['discount_id' => '', 'start_date' => '2017-07-01', 'end_date' => '2017-07-30'], 422],
            [['discount_id' => '', 'start_date' => '2017-07-01', 'end_date' => '2017-06-30'], 422],
        ];
    }
}
