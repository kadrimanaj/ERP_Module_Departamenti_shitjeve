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
        Schema::create('dsh_modeles', function (Blueprint $table) {
            $table->id();
            $table->string('model_name');
            $table->integer('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('module_name')->nullable();
            $table->integer('hapsira_category_id')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_modeles');
    }
};
