<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_voucher', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('voucher_id');
            
            $table->foreign('product_id')
                    ->references('id')
                    ->on('products');
            $table->foreign('voucher_id')
                    ->references('id')
                    ->on('vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_voucher');
    }
}
