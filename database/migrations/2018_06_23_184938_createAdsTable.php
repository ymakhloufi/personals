<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64)->index();
            $table->string('slug', 96)->index();
            $table->text('text');
            $table->string('author_name', 16);
            $table->integer('author_age');
            $table->string('author_email', 64);
            $table->string('author_phone', 32)->nullable();
            $table->boolean('author_phone_whatsapp');
            $table->integer('author_zip')->nullable();
            $table->string('author_town', 32)->nullable();
            $table->string('author_country', 32);
            $table->boolean('commercial');
            $table->integer('status');
            $table->timestamp('expires_at');
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
        Schema::dropIfExists('ads');
    }
}
