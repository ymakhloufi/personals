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
            $table->string('slug', 96)->unique()->index();
            $table->text('text');
            $table->string('author_name', 32);
            $table->integer('author_age')->nullable()->index();
            $table->string('author_email', 64)->index();
            $table->string('author_phone', 32)->nullable();
            $table->boolean('author_phone_whatsapp');
            $table->integer('author_zip')->nullable();
            $table->string('author_town', 32)->nullable()->index();
            $table->string('author_country', 2)->index();
            $table->boolean('commercial');
            $table->integer('status')->index();
            $table->timestamp('expires_at')->index();
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
