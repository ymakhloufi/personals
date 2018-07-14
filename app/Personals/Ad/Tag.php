<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Model;
use lotsofcode\TagCloud\TagCloud;

/**
 * Personals\User\User
 *
 * @property integer $id
 * @property string  $tag
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;


    public function ads()
    {
        return $this->belongsToMany(Ad::class);
    }


    private static function getTagsByCount()
    {
        return static::join('ad_tag', 'tag_id', '=', 'tags.id')
            ->groupBy('tag_id')
            ->orderByRaw('count(*) DESC')
            ->limit(30)
            ->select([\DB::raw('count(*) as count'), 'tag'])
            ->pluck('count', 'tag');
    }


    public static function getTagCloud()
    {
        $cloud = new TagCloud();

        $cloud->setHtmlizeTagFunction(function ($tag, $size) {
            return '<a class="tag size' . $size . '" href="' . $tag['url'] . '">' . $tag['tag'] . '</a>';
        });

        foreach (static::getTagsByCount() as $tag => $count) {
            $cloud->addTag(['tag' => $tag, 'url' => route('tag.show', ['tag' => $tag]), 'size' => $count]);
        }

        return $cloud->render();
    }
}
