<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersSocialAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_user_id');
            $table->string('provider_user_token');
            $table->string('provider');
            $table->string('pic');
            $table->string('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('provider_user_id');
            $table->dropColumn('provider_user_token');
            $table->dropColumn('provider');
            $table->dropColumn('pic');
            $table->dropColumn('uuid');
        });
    }
}
