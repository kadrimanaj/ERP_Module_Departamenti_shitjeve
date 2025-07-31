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
        Schema::create('dsh_modele_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained('dsh_modeles')->onDelete('cascade');
            $table->integer('modele_item_id')->nullable();
            $table->string('input_type'); // e.g., text, checkbox, select
            $table->text('input_name')->nullable();
            $table->text('input_options')->nullable();
            $table->string('parent_name')->nullable()->after('input_options');
            $table->string('icon')->nullable();
            $table->string('cols')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_modele_items');
    }
};
