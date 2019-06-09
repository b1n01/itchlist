<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItchesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('url');
            $table->longText('pic');
            $table->string('description');
            $table->string('price');
            $table->string('seller');
            $table->string('provider');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');;

            $table->unsignedBigInteger('booked_by')->nullable();
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('set null');;
            
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
        Schema::dropIfExists('itches');
    }
}
