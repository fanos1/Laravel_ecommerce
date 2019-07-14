<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
             $table->string('title', 255);
            $table->text('content');
            $table->string('img', 64)->nullable();
            $table->string('h2', 255)->nullable();
            $table->string('slug')->nullable();

            $table->unsignedDecimal('price', 8, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('glut_free')->default(0);

            $table->integer('size_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
