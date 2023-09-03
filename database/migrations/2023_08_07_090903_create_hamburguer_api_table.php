<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('categories_user_store_id_foreign');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('combo_has_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('combo_id')->index('combo_has_products_combo_id_foreign');
            $table->unsignedBigInteger('product_id')->index('combo_has_products_product_id_foreign');
            $table->timestamps();
        });

        Schema::create('combos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('price', 8, 2);
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('coupons_user_store_id_foreign');
            $table->string('name');
            $table->string('code');
            $table->double('value', 8, 2);
            $table->enum('type', ['unit', 'percent']);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('customers_user_store_id_foreign');
            $table->string('name');
            $table->string('document');
            $table->string('cellphone');
            $table->timestamps();
        });

        Schema::create('dashboards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('dashboards_user_store_id_foreign');
            $table->enum('key', ['general', 'waiters']);
            $table->json('config');
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index('order_payments_order_id_foreign');
            $table->string('payment_type_id')->index('order_payments_payment_type_id_foreign');
            $table->double('value')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('orders_user_store_id_foreign');
            $table->unsignedBigInteger('store_card_id')->nullable()->index('orders_store_card_id_foreign');
            $table->unsignedBigInteger('customer_id')->index('orders_customer_id_foreign');
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('origin');
            $table->unsignedBigInteger('coupon_id')->nullable()->index('orders_coupon_id_foreign');
            $table->timestamps();
        });

        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->unsignedTinyInteger('type');
            $table->tinyText('observation')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('delivery_id')->references('id')->on('order_deliveries');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });

        Schema::create('plan_has_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id')->index('plan_has_modules_plan_id_foreign');
            $table->unsignedBigInteger('module_id')->index('plan_has_modules_module_id_foreign');
            $table->timestamps();
        });

        Schema::create('plan_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id')->index('plan_prices_plan_id_foreign');
            $table->double('value');
            $table->integer('recurrence');
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->string('foreing_id');
            $table->timestamps();
        });

        Schema::create('product_additionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_additionals_product_id_foreign');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->timestamps();
        });

        Schema::create('product_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_configurations_product_id_foreign');
            $table->enum('unit_type', ['grams', 'unit'])->nullable();
            $table->tinyInteger('max_number_replacements');
            $table->tinyInteger('max_number_additionals');
            $table->timestamps();
        });

        Schema::create('product_follow_up', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_follow_up_product_id_foreign');
            $table->string('name');
            $table->double('value', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('product_variation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_items_product_id_foreign');
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->integer('quantity')->nullable();
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_photos_product_id_foreign');
            $table->string('src');
            $table->tinyInteger('order');
            $table->timestamps();
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_prices_product_id_foreign');
            $table->double('value', 8, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });

        Schema::create('product_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_replacements_product_id_foreign');
            $table->string('name');
            $table->double('value', 8, 2);
            $table->timestamps();
        });

        Schema::create('product_stock_entry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_stock_id')->index('product_stock_entry_product_stock_id_foreign');
            $table->double('amount', 8, 2);
            $table->enum('type', ['grams', 'unit']);
            $table->timestamps();
        });

        Schema::create('product_stock_exit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_stock_id')->index('product_stock_exit_product_stock_id_foreign');
            $table->double('amount', 8, 2);
            $table->enum('type', ['grams', 'unit']);
            $table->timestamps();
        });

        Schema::create('product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_stocks_product_id_foreign');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('products_user_store_id_foreign');
            $table->unsignedBigInteger('category_id')->index('products_category_id_foreign');
            $table->boolean('active')->default(false);
            $table->string('name');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->double('value', 8, 2);
            $table->unsignedTinyInteger('type');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });

        Schema::create('order_product_additionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('product_additional_id')->references('id')->on('product_additionals');
            $table->float('value');
            $table->unsignedTinyInteger('amount');
            $table->timestamps();
        });

        Schema::create('order_product_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('product_replacement_id')->references('id')->on('product_replacements');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('store_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('store_configurations_user_store_id_foreign');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });

        Schema::create('store_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('store_configurations_user_store_id_foreign');
            $table->text('warning')->nullable();
            $table->boolean('allow_withdrawal')->nullable();
            $table->integer('withdrawal_time')->nullable();
            $table->integer('delivery_time')->nullable();
            $table->double('minimum_order_value', 8, 2)->nullable();
            $table->double('delivery_price_per_km', 8, 2)->nullable();
            $table->boolean('force_store_open')->default(false);
            $table->boolean('force_store_close')->default(false);
            $table->timestamps();
        });

        Schema::create('store_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('store_schedules_user_store_id_foreign');
            $table->string('week_day');
            $table->boolean('closed')->default(false);
            $table->time('open_at')->nullable();
            $table->time('close_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->double('value', 8, 2);
            $table->smallInteger('amount');
            $table->text('observation')->nullable();
            $table->timestamps();
        });

        Schema::create('order_products_additionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('additional_id')->references('id')->on('product_additionals');
            $table->double('value', 8, 2);
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('order_products_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('replacement_id')->references('id')->on('product_replacements');
            $table->double('value', 8, 2);
            $table->timestamps();
        });

        Schema::create('user_stores', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->unsignedBigInteger('user_id')->index('user_stores_user_id_foreign');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('store_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('user_store_id')->references('id')->on('user_stores');
            $table->string('name');
            $table->string('src');
            $table->tinyInteger('order');
            $table->timestamps();
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('user_store_payment_types', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_store_id')->references('id')->on('user_stores');
            $table->string('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->timestamps();
        });

        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('user_subscriptions_user_id_foreign');
            $table->unsignedBigInteger('plan_price_id')->index('user_subscriptions_plan_price_id_foreign');
            $table->boolean('canceled')->default(false);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cellphone', 30);
            $table->string('token')->nullable()->default(null);
            $table->timestamp('token_expires_in')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('waiters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('waiters_user_store_id_foreign');
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('combo_has_products', function (Blueprint $table) {
            $table->foreign(['combo_id'])->references(['id'])->on('combos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('dashboards', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('order_payments', function (Blueprint $table) {
            $table->foreign(['order_id'])->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['payment_type_id'])->references(['id'])->on('payment_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['coupon_id'])->references(['id'])->on('coupons')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('plan_has_modules', function (Blueprint $table) {
            $table->foreign(['module_id'])->references(['id'])->on('modules')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['plan_id'])->references(['id'])->on('plans')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('plan_prices', function (Blueprint $table) {
            $table->foreign(['plan_id'])->references(['id'])->on('plans')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_additionals', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_configurations', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_follow_up', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_photos', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_prices', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_replacements', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_stock_entry', function (Blueprint $table) {
            $table->foreign(['product_stock_id'])->references(['id'])->on('product_stocks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_stock_exit', function (Blueprint $table) {
            $table->foreign(['product_stock_id'])->references(['id'])->on('product_stocks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_stocks', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('store_configurations', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('store_schedules', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('user_stores', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->foreign(['plan_price_id'])->references(['id'])->on('plan_prices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('waiters', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waiters', function (Blueprint $table) {
            $table->dropForeign('waiters_user_store_id_foreign');
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropForeign('user_subscriptions_plan_price_id_foreign');
            $table->dropForeign('user_subscriptions_user_id_foreign');
        });

        Schema::table('user_stores', function (Blueprint $table) {
            $table->dropForeign('user_stores_user_id_foreign');
        });

        Schema::table('store_schedules', function (Blueprint $table) {
            $table->dropForeign('store_schedules_user_store_id_foreign');
        });

        Schema::table('store_configurations', function (Blueprint $table) {
            $table->dropForeign('store_configurations_user_store_id_foreign');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
            $table->dropForeign('products_user_store_id_foreign');
        });

        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropForeign('product_stocks_product_id_foreign');
        });

        Schema::table('product_stock_exit', function (Blueprint $table) {
            $table->dropForeign('product_stock_exit_product_stock_id_foreign');
        });

        Schema::table('product_stock_entry', function (Blueprint $table) {
            $table->dropForeign('product_stock_entry_product_stock_id_foreign');
        });

        Schema::table('product_replacements', function (Blueprint $table) {
            $table->dropForeign('product_replacements_product_id_foreign');
        });

        Schema::table('product_prices', function (Blueprint $table) {
            $table->dropForeign('product_prices_product_id_foreign');
        });

        Schema::table('product_photos', function (Blueprint $table) {
            $table->dropForeign('product_photos_product_id_foreign');
        });

        Schema::table('product_items', function (Blueprint $table) {
            $table->dropForeign('product_items_product_id_foreign');
        });

        Schema::table('product_follow_up', function (Blueprint $table) {
            $table->dropForeign('product_follow_up_product_id_foreign');
        });

        Schema::table('product_configurations', function (Blueprint $table) {
            $table->dropForeign('product_configurations_product_id_foreign');
        });

        Schema::table('product_additionals', function (Blueprint $table) {
            $table->dropForeign('product_additionals_product_id_foreign');
        });

        Schema::table('plan_prices', function (Blueprint $table) {
            $table->dropForeign('plan_prices_plan_id_foreign');
        });

        Schema::table('plan_has_modules', function (Blueprint $table) {
            $table->dropForeign('plan_has_modules_module_id_foreign');
            $table->dropForeign('plan_has_modules_plan_id_foreign');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_coupon_id_foreign');
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropForeign('orders_store_card_id_foreign');
            $table->dropForeign('orders_user_store_id_foreign');
        });

        Schema::table('order_payments', function (Blueprint $table) {
            $table->dropForeign('order_payments_order_id_foreign');
            $table->dropForeign('order_payments_payment_type_id_foreign');
        });

        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropForeign('dashboards_user_store_id_foreign');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_user_store_id_foreign');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('coupons_user_store_id_foreign');
        });

        Schema::table('combo_has_products', function (Blueprint $table) {
            $table->dropForeign('combo_has_products_combo_id_foreign');
            $table->dropForeign('combo_has_products_product_id_foreign');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_user_store_id_foreign');
        });


        Schema::dropIfExists('waiters');

        Schema::dropIfExists('users');

        Schema::dropIfExists('user_subscriptions');

        Schema::dropIfExists('user_stores');

        Schema::dropIfExists('store_schedules');

        Schema::dropIfExists('store_configurations');

        Schema::dropIfExists('store_addresses');

        Schema::dropIfExists('products');

        Schema::dropIfExists('product_stocks');

        Schema::dropIfExists('product_stock_exit');

        Schema::dropIfExists('product_stock_entry');

        Schema::dropIfExists('product_replacements');

        Schema::dropIfExists('product_prices');

        Schema::dropIfExists('product_photos');

        Schema::dropIfExists('product_items');

        Schema::dropIfExists('product_follow_up');

        Schema::dropIfExists('product_configurations');

        Schema::dropIfExists('product_additionals');

        Schema::dropIfExists('plans');

        Schema::dropIfExists('plan_prices');

        Schema::dropIfExists('plan_has_modules');

        Schema::dropIfExists('payment_types');

        Schema::dropIfExists('orders');

        Schema::dropIfExists('order_payments');

        Schema::dropIfExists('modules');

        Schema::dropIfExists('dashboards');

        Schema::dropIfExists('customers');

        Schema::dropIfExists('coupons');

        Schema::dropIfExists('combos');

        Schema::dropIfExists('combo_has_products');

        Schema::dropIfExists('categories');


        Schema::dropIfExists('cart_items');

        Schema::dropIfExists('store_cards');

        Schema::dropIfExists('store_banners');
    }
};
