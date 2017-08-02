<?php

namespace Tests\Feature\Api;

use App\Models\Voucher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    /**
     * Product creation.
     *
     * @param array $data
     * @param int $status
     * @dataProvider testCreateProvider
     * @return void
     */
    public function testCreate(array $data, $status)
    {
        $this->artisan('db:seed');
        $response = $this->call('POST', route('api.product.store'), $data);
        $response->assertStatus($status);
    }

    /**
     *
     * @return array
     */
    public function testCreateProvider()
    {
        return [
            [['name' => 'Test', 'price' => '10.55'], 200],
            [['name' => '', 'price' => ''], 422],
            [['name' => 1, 'price' => 'test'], 422],
        ];
    }

    /**
     * Voucher bind to product
     *
     * @param int $productId
     * @param int $voucherId
     * @param $status
     * @dataProvider testVoucherBindProvider
     * @return void
     */
    public function testVoucherBind($productId, $voucherId, $status)
    {
        $this->artisan('db:seed');
        // Create used voucher
        factory(Voucher::class)->create(['id' => 999, 'used_date' => '2017-07-25']);

        $response = $this->call('POST', route('api.product.add_voucher', [$productId, $voucherId]));
        $response->assertStatus($status);
    }

    /**
     * @return array
     */
    public function testVoucherBindProvider()
    {
        return [
            [1, 1, 200],
            [1, 999, 422], // used (invalid) voucher
            [1000, 1, 404], // not fount product
            [1, 999999, 422], // not fount (invalid) voucher
        ];
    }
}
