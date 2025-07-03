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
        Schema::create('dsh_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_description')->nullable();
            $table->integer('product_status')->default(0);
            $table->string('product_price')->nullable();
            $table->string('product_type');
            $table->integer('product_quantity')->default(0);
            $table->decimal('lenda_pare', 10, 2)->default(0);
            $table->decimal('lenda_ndihmese', 10, 2)->default(0);
            $table->decimal('other_costs', 10, 2)->default(0);
            $table->integer('product_confirmation')->nullable();
            $table->integer('kostoisti_product_confirmation')->nullable();
            $table->integer('product_project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->date('afati_realizimit_product')->nullable();
            $table->string('dimension')->nullable();
            $table->string('color')->nullable();
            $table->integer('kryeinxhinieri_product_confirmation')->default(0);
            $table->integer('ofertuesi_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_products');
    }
};
