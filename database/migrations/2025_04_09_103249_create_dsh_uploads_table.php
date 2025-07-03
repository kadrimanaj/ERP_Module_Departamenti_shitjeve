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
        Schema::create('dsh_uploads', function (Blueprint $table) {
            $table->id();
            $table->text('file_name')->nullable();
            $table->integer('file_id')->nullable();
            $table->text('file_path')->nullable();
            $table->text('file_type')->nullable();
            $table->text('file_size')->nullable();
            $table->text('file_userId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_uploads');
    }
};
