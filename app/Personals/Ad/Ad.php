<?php

namespace Personals\Ad;

use App\Mail\PublishAd;
use App\Mail\ReplyAd;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Propaganistas\LaravelPhone\PhoneNumber;

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


    public static function search($query)
    {
        $firstPrioAds = Ad
            ::where('status', static::STATUS_CONFIRMED)
            ->where(function (Builder $builder) use ($query) {
                $builder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('author_name', 'like', '%' . $query . '%')
                    ->orWhere('author_email', 'like', '%' . $query . '%')
                    ->orWhere('author_phone', 'like', '%' . $query . '%')
                    ->orWhere('author_town', 'like', '%' . $query . '%');
            })
            ->orderByDesc('id')
            ->get();

        $secondPrioAds = collect();
        foreach (Tag::where('tag', 'like', '%' . $query . '%')->with('ads')->get() as $tag) {
            $secondPrioAds = $secondPrioAds->merge($tag->ads);
        }

        $thirdPrioAds = Ad::where('text', 'like', '%' . $query . '%')->get();

        return $firstPrioAds->merge($secondPrioAds)->merge($thirdPrioAds);
    }


    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getShortenedText(): string
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


    public function getSlug(): string
    {
        return ((new Slugify())->slugify($this->title));
    }


    public function getActivationToken(): string
    {
        return hash('sha256', config('app.key') . $this->id);
    }


    public function publishAd(string $activationToken): bool
    {
        if ($activationToken !== $this->getActivationToken()) {
            return false;
        }

        if ($this->status !== static::STATUS_CONFIRMED) {
            $this->status = static::STATUS_CONFIRMED;
            $this->save();
        }

        return true;
    }


    public function addPicture(UploadedFile $file): void
    {
        $fileName = str_random() . "." . $file->getClientOriginalExtension();
        \Storage::putFileAs('images/' . $this->id, $file, $fileName);
        $this->pictures()->create(['url' => \Storage::url('images/' . $this->id . "/" . $fileName)]);
    }


    public function sendConformationEmail(string $email)
    {
        \Mail::to($email)->send(new PublishAd($this));
    }


    public function sendReply(string $name, string $email, string $phone, string $message)
    {
        \Mail::alwaysReplyTo($email);
        \Mail::to($this->author_email)->send(new ReplyAd($this, $name, $phone, $email, $message));
    }
}
