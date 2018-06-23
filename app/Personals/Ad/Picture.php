<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Model;

/**
 * Personals\User\User
 *
 * @property integer $id
 * @property integer $ad_id
 * @mixin \Eloquent
 */
class Picture extends Model
{
    protected $guarded = ['id'];


    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
