<?php

namespace Personals\Ad;

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
}
