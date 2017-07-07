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
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('links')->nullable();
            $table->string('videoLink')->nullable();
            $table->text('preview')->nullable();
            $table->enum('source', ['soprano', 'alto'])->default('soprano');
            $table->enum('category', ['all', 'social', 'document', 'images', 'video'])->default('all');
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
