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
    Schema::table('menus', function (Blueprint $table) {
        $table->boolean('is_best_seller')->default(false);
        $table->boolean('is_recommended')->default(false);
    });
}

public function down()
{
    Schema::table('menus', function (Blueprint $table) {
        $table->dropColumn(['is_best_seller', 'is_recommended']);
    });
}

};
