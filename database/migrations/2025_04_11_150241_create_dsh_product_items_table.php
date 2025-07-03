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
        Schema::create('dsh_product_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('product_type');
            $table->text('item_description')->nullable();
            $table->text('item_dimensions')->nullable();
            $table->integer('item_quantity');
            $table->integer('product_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('item_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_product_items');
    }
};
