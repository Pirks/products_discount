<?php

namespace Tests\Unit\Components\Products;

use App\Components\Products\Products;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    /**
     * Test product creation
     *
     * @return void
     */
    public function testCreate()
    {
        $data = ['product_data'];

        $productMock = \Mockery::mock(Product::class);
        $productMock->shouldReceive('fill')
            ->once()
            ->with($data)
            ->andReturn($productMock);
        $productMock->shouldReceive('save')
            ->once();

        $products = new Products($productMock);
        $this->assertEquals($productMock, $products->create($data));
    }
}
