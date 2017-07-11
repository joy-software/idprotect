<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('p_name');
            $table->boolean('p_email')->nullable();
            $table->boolean('p_nickname')->nullable();
            $table->boolean('p_profession')->nullable();
            $table->boolean('p_occupation')->nullable();
            $table->boolean('p_avatar')->nullable();
            $table->timestamps();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function(Blueprint $table) {
            $table->dropForeign('profile_user_id_foreign');
        });
        Schema::dropIfExists('profile');
    }
}
