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
            $table->enum('category', config('enums.itemCategory'))->default('other');
            $table->date('found_time');
            $table->string('title', 64);
            $table->foreignId('found_userid')->constrained('users');
            $table->string('found_location', 128);
            $table->enum('color', config('enums.itemColor'));
            $table->string('image', 256)->nullable();
            $table->enum('state', config('enums.itemState'))->default('open');
            $table->string('description', 512)->nullable();
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
        Schema::dropIfExists('items');
    }
}
