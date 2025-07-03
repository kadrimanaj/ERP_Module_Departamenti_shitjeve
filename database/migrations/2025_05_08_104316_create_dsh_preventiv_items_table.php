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
        Schema::create('dsh_preventiv_items', function (Blueprint $table) {
            $table->id();
            $table->string('sku_code')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('product_type')->nullable();
            $table->string('unit_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->integer('user_id');
            $table->integer('element_id');
            $table->decimal('cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_preventiv_items');
    }
};
