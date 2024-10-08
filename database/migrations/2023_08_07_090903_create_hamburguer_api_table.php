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
            $table->string('logo')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('store_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->boolean('active')->default(false);
            $table->unsignedTinyInteger('type');
        });

        Schema::create('store_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->boolean('active')->default(false);
            $table->unsignedTinyInteger('type');
            $table->unsignedInteger('minutes')->nullable();
        });

        Schema::create('store_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->text('warning')->nullable();
            $table->double('minimum_order_value', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('store_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
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

        Schema::create('store_neighborhoods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->boolean('active');
            $table->string('name');
            $table->float('price');
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
        });

        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('plan_id')->references('id')->on('plans');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->tinyInteger('status');
        });

        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->references('id')->on('user_subscriptions');
            $table->timestamps();
        });

        Schema::create('user_sub_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->boolean('active');
            $table->string('name');
            $table->string('email');
            $table->string('password');
        });

        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('title');
            $table->text('content');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });

        Schema::create('store_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->string('src');
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });

        Schema::create('store_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->string('name', 20);
            $table->unsignedInteger('order');
            $table->timestamps();
        });

        Schema::create('store_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->string('document')->nullable();
            $table->string('cellphone');
            $table->timestamps();
        });

        Schema::create('store_tables', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->timestamps();
        });

        Schema::create('store_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->string('description')->nullable();
            $table->string('code');
            $table->double('value', 8, 2);
            $table->unsignedTinyInteger('type');
            $table->timestamps();
        });

        Schema::create('store_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->foreignId('category_id')->references('id')->on('store_categories');
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('image')->nullable();
            $table->float('price');
            $table->float('price_from')->nullable();
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_prepared', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('store_products');
            $table->unsignedTinyInteger('serves_people_count')->nullable();
            $table->float('weight')->nullable();
        });

        Schema::create('store_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->unsignedTinyInteger('week_day');
            $table->time('start');
            $table->time('end');
        });

        Schema::create('store_scheduled_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->timestamp('start');
            $table->timestamp('end');
        });

        Schema::create('store_emergency_closes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->timestamp('ends_at');
        });

        Schema::create('product_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->references('id')->on('store_products');
            $table->unsignedTinyInteger('quantity');
            $table->boolean('required');
            $table->timestamps();
        });

        Schema::create('choice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('choice_id')->references('id')->on('product_choices');
            $table->string('name');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('product_additionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_follow_up', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->references('id')->on('store_products');
            $table->string('name');
            $table->double('value', 8, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('store_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('store_id')->references('id')->on('user_stores');
            $table->foreignId('customer_id')->references('id')->on('store_customers');
            $table->foreignId('coupon_id')->nullable()->default(null)->references('id')->on('store_coupons');
            $table->float('products_total');
            $table->float('delivery_fee');
            $table->unsignedTinyInteger('delivery');
            $table->float('discount');
            $table->float('total');
            $table->unsignedTinyInteger('origin');
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('store_orders');
            $table->foreignId('product_id')->references('id')->on('store_products');
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
            $table->foreignId('order_id')->references('id')->on('store_orders');
            $table->foreignId('product_replacement_id')->references('id')->on('product_replacements');
            $table->float('value');
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('store_orders');
            $table->unsignedTinyInteger('type');
        });

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('store_orders');
            $table->string('cep')->nullable();
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('city')->nullable();
            $table->string('complement')->nullable();
        });
    }
};
