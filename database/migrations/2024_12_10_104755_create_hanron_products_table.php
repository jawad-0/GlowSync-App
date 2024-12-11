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
        Schema::create('hanron_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('parent_code')->nullable();
            $table->string('description')->nullable();
            $table->string('product_name');
            $table->string('image_url');
            $table->string('option')->nullable();
            $table->integer('stock');
            $table->decimal('trade_price', 8, 2);
            $table->decimal('average_weight', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hanron_products');
    }
};
