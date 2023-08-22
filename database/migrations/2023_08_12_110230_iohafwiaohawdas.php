<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Iohafwiaohawdas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combo_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_id')->references('id')->on('combos');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });

        Schema::create('combo_option_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_option_id')->references('id')->on('combo_options');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('combo_option_products');
        Schema::dropIfExists('combo_options');
    }
}
