<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->constrained('sub_categories');
            $table->foreignId('sub_sub_category_id')->constrained('sub_sub_categories');
            $table->foreignId('brand_id')->constrained();
            $table->mediumText('description')->nullable();

            $table->string('barcode')->unique();
            $table->string('sku')->unique();
            $table->float('quantity');
            $table->float('alert_quantity')->nullable();

            $table->foreignId('discount_id')->constrained('discounts');
            $table->float('cost_price');
            $table->float('sale_price');
            $table->float('discounted_sale_price')->nullable();

            $table->boolean('is_returnable')->nullable();
            $table->integer('return_validity')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
