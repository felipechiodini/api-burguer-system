<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('cellphone')->nullable();
            $table->boolean('root')->default(false);
            $table->timestamps();
        });

        Schema::create('user_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('store_payment_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->timestamps();
        });

        Schema::create('delivery_types', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('store_delivery_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('delivery_type_id');
            $table->unsignedInteger('minutes');
            $table->foreign('delivery_type_id')->references('id')->on('delivery_types');
            $table->timestamps();
        });

        Schema::create('store_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->text('warning')->nullable();
            $table->double('minimum_order_value', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('store_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });

        Schema::create('store_shipping_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('store_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->string('src');
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });

        Schema::create('store_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('name', 20);
            $table->unsignedInteger('order');
            $table->timestamps();
        });

        Schema::create('store_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->string('document');
            $table->string('cellphone');
            $table->timestamps();
        });

        Schema::create('store_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->string('description')->nullable();
            $table->string('code');
            $table->double('value', 8, 2);
            $table->unsignedTinyInteger('type');
            $table->timestamps();
        });

        Schema::create('store_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->foreignId('store_category_id')->references('id')->on('store_categories');
            $table->boolean('active')->default(false);
            $table->string('name');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->string('src');
            $table->tinyInteger('order');
            $table->timestamps();
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->double('value', 8, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });

        Schema::create('product_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->double('value', 8, 2);
            $table->unsignedTinyInteger('type');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });

        Schema::create('product_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->enum('unit_type', ['grams', 'unit'])->nullable();
            $table->tinyInteger('max_number_replacements');
            $table->tinyInteger('max_number_additionals');
            $table->timestamps();
        });

        Schema::create('product_additionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_follow_up', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('store_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_store_id')->references('id')->on('user_stores');
            $table->foreignId('store_customer_id')->references('id')->on('store_customers');
            $table->foreignId('store_coupon_id')->nullable()->default(null)->references('id')->on('store_coupons');
            $table->float('products_total');
            $table->float('delivery_fee');
            $table->float('discount');
            $table->float('total');
            $table->unsignedTinyInteger('origin');
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_order_id')->references('id')->on('store_orders');
            $table->foreignId('store_product_id')->references('id')->on('store_products');
            $table->double('value', 8, 2);
            $table->smallInteger('amount');
            $table->text('observation')->nullable();
            $table->timestamps();
        });

        Schema::create('order_product_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_product_id')->references('id')->on('order_products');
            $table->foreignId('product_additional_id')->references('id')->on('product_additionals');
            $table->float('value');
            $table->unsignedTinyInteger('amount');
            $table->timestamps();
        });

        Schema::create('order_product_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_product_id')->references('id')->on('order_products');
            $table->foreignId('product_replacement_id')->references('id')->on('product_replacements');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('order_product_follow_up', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_order_id')->references('id')->on('store_orders');
            $table->foreignId('product_replacement_id')->references('id')->on('product_replacements');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_order_id')->references('id')->on('store_orders');
            $table->unsignedTinyInteger('type');
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_order_id')->references('id')->on('store_orders');
            $table->unsignedTinyInteger('type');
            $table->timestamps();
        });

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_order_id')->references('id')->on('store_orders');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('complement')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('cellphone');
            $table->string('email');
            $table->string('message');
            $table->timestamps();
        });
    }
};
