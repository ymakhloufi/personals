<?php

namespace Personals\Ad;

use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;

/**
 * Personals\User\User
 *
 * @property integer             $id
 * @property string              $title
 * @property string              $text
 * @property string              $author_name
 * @property string              $author_email
 * @property string|null         $author_phone
 * @property string              $author_phone_whatsapp
 * @property string|null         $author_zip
 * @property string|null         $author_town
 * @property string              $author_country
 * @property boolean             $commercial
 * @property integer             $status
 * @property \Carbon\Carbon      $expires_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class Ad extends Model
{
    protected $guarded = ['id'];


    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getSlug()
    {
        return (new Slugify())->slugify($this->title);
    }


    public function getShortenedText()
    {
        return strlen($this->text) > 256 ? substr($this->text, 0, 230) . "..." : $this->text;
    }
}
