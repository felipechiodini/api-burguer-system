<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('banners_user_store_id_foreign');
            $table->string('name');
            $table->string('src');
            $table->tinyInteger('order');
            $table->timestamps();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('cards_user_store_id_foreign');
            $table->integer('number');
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id')->index('cart_items_cart_id_foreign');
            $table->unsignedBigInteger('product_item_id')->index('cart_items_product_item_id_foreign');
            $table->double('value');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index('carts_customer_id_foreign');
            $table->unsignedBigInteger('coupon_id')->index('carts_coupon_id_foreign');
            $table->timestamps();
        });

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

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index('order_addresses_order_id_foreign');
            $table->string('name');
            $table->string('cep');
            $table->string('state');
            $table->string('city');
            $table->string('street');
            $table->string('number');
            $table->string('complement');
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
            $table->enum('type', ['withdrawal', 'delivery', 'on_site']);
            $table->enum('status', ['open', 'aceppted', 'delivered', 'canceled'])->default('open');
            $table->enum('origin', ['app']);
            $table->timestamps();
            $table->unsignedBigInteger('coupon_id')->nullable()->index('orders_coupon_id_foreign');
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
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
            $table->smallInteger('max_times');
            $table->timestamps();
        });

        Schema::create('product_configuration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_configuration_product_id_foreign');
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

        Schema::create('product_price_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_price_id')->index('product_price_promotions_product_price_id_foreign');
            $table->double('value', 8, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
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

        Schema::create('store_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_store_id', 36)->index('store_configurations_user_store_id_foreign');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
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

        Schema::create('sub_order_has_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_order_id')->index('sub_order_has_products_sub_order_id_foreign');
            $table->unsignedBigInteger('product_id')->index('sub_order_has_products_product_id_foreign');
            $table->double('value', 8, 2);
            $table->smallInteger('amount');
            $table->text('observation')->nullable();
            $table->timestamps();
        });

        Schema::create('sub_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index('sub_orders_order_id_foreign');
            $table->unsignedBigInteger('waiter_id')->nullable()->index('sub_orders_waiter_id_foreign');
            $table->timestamps();
        });

        Schema::create('user_stores', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->unsignedBigInteger('user_id')->index('user_stores_user_id_foreign');
            $table->string('name');
            $table->string('slug')->unique();
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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cellphone', 30);
            $table->rememberToken();
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

        Schema::table('banners', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->foreign(['user_store_id'])->references(['id'])->on('user_stores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign(['cart_id'])->references(['id'])->on('carts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            // $table->foreign(['product_item_id'])->references(['id'])->on('product_items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign(['coupon_id'])->references(['id'])->on('coupons')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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

        Schema::table('order_addresses', function (Blueprint $table) {
            $table->foreign(['order_id'])->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('order_payments', function (Blueprint $table) {
            $table->foreign(['order_id'])->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['payment_type_id'])->references(['id'])->on('payment_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['coupon_id'])->references(['id'])->on('coupons')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['store_card_id'])->references(['id'])->on('cards')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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

        Schema::table('product_configuration', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_follow_up', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_items', function (Blueprint $table) {
            // $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_photos', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('product_price_promotions', function (Blueprint $table) {
            $table->foreign(['product_price_id'])->references(['id'])->on('product_prices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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

        Schema::table('sub_order_has_products', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['sub_order_id'])->references(['id'])->on('sub_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->foreign(['order_id'])->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['waiter_id'])->references(['id'])->on('waiters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->dropForeign('sub_orders_order_id_foreign');
            $table->dropForeign('sub_orders_waiter_id_foreign');
        });

        Schema::table('sub_order_has_products', function (Blueprint $table) {
            $table->dropForeign('sub_order_has_products_product_id_foreign');
            $table->dropForeign('sub_order_has_products_sub_order_id_foreign');
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

        Schema::table('product_price_promotions', function (Blueprint $table) {
            $table->dropForeign('product_price_promotions_product_price_id_foreign');
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

        Schema::table('product_configuration', function (Blueprint $table) {
            $table->dropForeign('product_configuration_product_id_foreign');
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

        Schema::table('order_addresses', function (Blueprint $table) {
            $table->dropForeign('order_addresses_order_id_foreign');
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

        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_coupon_id_foreign');
            $table->dropForeign('carts_customer_id_foreign');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign('cart_items_cart_id_foreign');
            $table->dropForeign('cart_items_product_item_id_foreign');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign('cards_user_store_id_foreign');
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropForeign('banners_user_store_id_foreign');
        });

        Schema::dropIfExists('waiters');

        Schema::dropIfExists('users');

        Schema::dropIfExists('user_subscriptions');

        Schema::dropIfExists('user_stores');

        Schema::dropIfExists('sub_orders');

        Schema::dropIfExists('sub_order_has_products');

        Schema::dropIfExists('store_schedules');

        Schema::dropIfExists('store_configurations');

        Schema::dropIfExists('store_addresses');

        Schema::dropIfExists('products');

        Schema::dropIfExists('product_stocks');

        Schema::dropIfExists('product_stock_exit');

        Schema::dropIfExists('product_stock_entry');

        Schema::dropIfExists('product_replacements');

        Schema::dropIfExists('product_prices');

        Schema::dropIfExists('product_price_promotions');

        Schema::dropIfExists('product_photos');

        Schema::dropIfExists('product_items');

        Schema::dropIfExists('product_follow_up');

        Schema::dropIfExists('product_configuration');

        Schema::dropIfExists('product_additionals');

        Schema::dropIfExists('plans');

        Schema::dropIfExists('plan_prices');

        Schema::dropIfExists('plan_has_modules');

        Schema::dropIfExists('payment_types');

        Schema::dropIfExists('orders');

        Schema::dropIfExists('order_payments');

        Schema::dropIfExists('order_addresses');

        Schema::dropIfExists('modules');

        Schema::dropIfExists('dashboards');

        Schema::dropIfExists('customers');

        Schema::dropIfExists('coupons');

        Schema::dropIfExists('combos');

        Schema::dropIfExists('combo_has_products');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('carts');

        Schema::dropIfExists('cart_items');

        Schema::dropIfExists('cards');

        Schema::dropIfExists('banners');
    }
};
