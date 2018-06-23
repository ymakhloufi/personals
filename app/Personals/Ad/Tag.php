<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Model;

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


    public function ads()
    {
        return $this->belongsToMany(Ad::class);
    }
}
