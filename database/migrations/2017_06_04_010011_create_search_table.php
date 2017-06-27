<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
            $table->increments('id');
            $table->text('keywords')->nullable();
            $table->timestamps();

            $table->integer('profile_id')->unsigned()->nullable();
            $table->foreign('profile_id')
                ->references('id')
                ->on('profile')
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
        Schema::table('search', function(Blueprint $table) {
            $table->dropForeign('search_profile_id_foreign');
        });
        Schema::dropIfExists('search');
    }
}
