<?php

use Illuminate\Database\Migrations\Migration;
use Personals\Ad\Tag;

class FixTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Tag::all() as $tag) {
            if (strpos($tag->tag, "/") !== false) {
                $tag->tag = str_replace("/", "-", $tag->tag);
                $tag->save();
            }
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
