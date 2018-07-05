<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_tag', function (Blueprint $table) {
            $table->dropForeign('ad_tag_ad_id_foreign');
            $table->dropForeign('ad_tag_tag_id_foreign');
        });
        Schema::dropIfExists('ad_tag');
    }
}
