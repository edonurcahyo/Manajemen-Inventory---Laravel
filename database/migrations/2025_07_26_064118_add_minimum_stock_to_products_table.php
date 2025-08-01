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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('minimum_stock')->default(0)->after('stok');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('minimum_stock');
        });
    }
};
