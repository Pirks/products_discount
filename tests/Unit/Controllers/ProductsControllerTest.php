<?php

namespace Tests\Unit\Controllers;

use App\Components\Products\Products;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ProductsControllerTest extends TestCase
{
    /**
     * Test products list
     *
     * @return void
     */
    public function testIndex()
    {
        $productsList = collect();
        $input = ['input_array'];

        $productsMock = \Mockery::mock(Products::class);
        $productsMock->shouldReceive('getActive')
            ->once()
            ->with($input)
            ->andReturn($productsList);

        $this->app->instance(Products::class, $productsMock);

        $request = app(Request::class);
        $request->replace($input);
        $this->app->instance(Request::class, $request);

        $response = $this->call('GET', route('product.index'));
        $response->assertViewHas('products', $productsList);
    }
}