<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dsh_products', function (Blueprint $table) {
            $table->text('refuse_comment')->nullable(); // ose pa after() nëse nuk ka preferencë
        });
    }

    public function down()
    {
        Schema::table('dsh_product', function (Blueprint $table) {
            $table->dropColumn('refuse_comment');
        });
    }

};
