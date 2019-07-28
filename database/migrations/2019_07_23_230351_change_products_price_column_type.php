<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProductsPriceColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('products', function ($table) {
            $table->integer('price')->change();
            // DB::statement('ALTER TABLE products MODIFY price  INT;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function ($table) {
            
            $table->unsignedDecimal('price', 8, 2);
        });
    }
}
