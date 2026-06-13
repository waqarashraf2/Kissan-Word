<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone', 30);
            $table->text('shipping_address');
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('shipping_total', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->string('currency', 3)->default('PKR');
            $table->string('payment_method', 30)->default('cash_on_delivery');
            $table->string('payment_status', 20)->default('pending')->index();
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('placed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });

        Schema::create('magazine_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('magazine_id')->constrained()->cascadeOnDelete();
            $table->string('purchase_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('PKR');
            $table->string('payment_method', 30)->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_status', 20)->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'magazine_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magazine_purchases');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
