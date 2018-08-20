<?php

namespace Personals\Ad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Personals\User\User
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $email
 * @property string              $phone
 * @property integer             $ad_id
 * @property-read Ad             $ad
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class Reply extends Model
{
    protected $guarded = ['id'];


    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
