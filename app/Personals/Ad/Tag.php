<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use lotsofcode\TagCloud\TagCloud;

/**
 * Personals\User\User
 *
 * @property integer              $id
 * @property string               $tag
 * @property-read Ad[]|Collection $ads
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


    private static function getTagsByCount(int $count)
    {
        return static::join('ad_tag', 'tag_id', '=', 'tags.id')
            ->groupBy('tag')
            ->orderByRaw('count(*) DESC')
            ->limit($count)
            ->select([\DB::raw('count(*) as count'), 'tag'])
            ->pluck('count', 'tag');
    }


    public static function getTagCloud()
    {
        return \Cache::remember('tagCloud', 60, function () {
            $cloud = new TagCloud();

            $cloud->setHtmlizeTagFunction(function ($tag, $size) {
                return '<a class="tag size' . $size . '" href="' . $tag['url'] . '">' . $tag['tag'] . '</a>';
            });

            foreach (Tag::getTagsByCount(30) as $tag => $count) {
                $cloud->addTag(['tag' => $tag, 'url' => route('tag.show', ['tag' => $tag]), 'size' => $count]);
            }

            return $cloud->render();
        });
    }
}
