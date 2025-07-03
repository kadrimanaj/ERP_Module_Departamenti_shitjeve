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
        Schema::create('dsh_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('project_description')->nullable();
            $table->integer('project_status')->default(0);
            $table->date('project_start_date');
            $table->integer('project_client');
            $table->integer('project_architect')->nullable();
            $table->integer('arkitekt_confirm')->nullable();
            $table->integer('project_seller_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('preventiv_status')->default(0);
            $table->string('priority')->nullable();
            $table->date('client_limit_date')->nullable();
            $table->date('afati_realizimit')->nullable();
            $table->text('order_address')->nullable();
            $table->text('rruga')->nullable();
            $table->string('qarku')->nullable();
            $table->string('bashkia')->nullable();
            $table->string('tipologjia_objektit')->nullable();
            $table->string('kate')->nullable();
            $table->string('lift')->nullable();
            $table->text('address_comment')->nullable();
            $table->string('orari_pritjes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dsh_projects');
    }
};