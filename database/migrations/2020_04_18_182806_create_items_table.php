<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->enum('category',config('enums.itemCategory'))->default('other');
            $table->date('found_time');
            $table->bigInteger('found_userid')->unsigned();
            $table->string('found_location', 256);
            $table->enum('color', config('enums.itemColor'));
            $table->string('image', 256)->nullable();
            $table->string('description', 256)->nullable();
            $table->timestamps();
            $table->foreign('found_userid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
