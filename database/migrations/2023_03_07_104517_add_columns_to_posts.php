<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('address')->nullable()->after('description');
            $table->double('price')->nullable()->after('address')->default(0);
            $table->integer('rating')->nullable()->after('price')->default(0);
            $table->string('image')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('price');
            $table->dropColumn('rating');
            $table->dropColumn('image');
        });
    }
};
