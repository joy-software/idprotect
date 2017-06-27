<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSearchResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Search_Result', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link');
            $table->string('links');
            $table->string('videoLink');
            $table->text('preview');
            $table->enum('source', ['soprano', 'alto'])->default('soprano');
            $table->enum('category', ['all', 'social', 'documents', 'images', 'video'])->default('all');
            $table->enum('statut', ['waiting', 'valid', 'rejected'])->default('waiting');
            $table->timestamps();


            $table->integer('search_id')->unsigned()->nullable();
            $table->foreign('search_id')
                ->references('id')
                ->on('search')
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
        Schema::table('Search_Result', function(Blueprint $table) {
            $table->dropForeign('Search_Result_search_id_foreign');
        });
        Schema::dropIfExists('Search_Result');
    }
}
