<?php

namespace Personals\Ad;

use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Personals\User\User
 *
 * @property integer             $id
 * @property string              $title
 * @property string              $slug
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
    protected $with    = ['pictures'];

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';


    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getShortenedText()
    {
        return strlen($this->text) > 256 ? substr($this->text, 0, 230) . "..." : $this->text;
    }


    public function getWhatsAppUrl(): ?string
    {
        try {
            $internationalNuber = ($countryCode = $this->author_country ?: [])
                ? PhoneNumber::make($this->author_phone, $countryCode)->formatE164()
                : $this->author_phone;


            return "https://wa.me/" . ltrim($internationalNuber, '+');
        } catch (\Exception $e) {
            return null;
        }
    }


    public function getSlug()
    {
        return ((new Slugify())->slugify($this->title));
    }


    public function getActivationToken()
    {
        return bcrypt(config('app.key') . $this->id);
    }


    public function activateAd(string $activationToken)
    {
        if ($activationToken !== $this->getActivationToken()) {
            throw new AccessDeniedHttpException("The activation token is invalid!");
        }

        $this->status = static::STATUS_CONFIRMED;
    }


    public function addPicture(UploadedFile $file)
    {
        $fileName = str_random() . "." . $file->getClientOriginalExtension();
        \Storage::putFileAs($this->id, $file, $fileName);
        $this->pictures()->create(['url' => \Storage::url($this->id . "/" . $fileName)]);
    }
}
