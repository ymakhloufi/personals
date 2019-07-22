<?php

namespace Personals\Ad;

use App\Mail\BanAd;
use App\Mail\PublishAd;
use App\Mail\ReplyAd;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Personals\User\User
 *
 * @property integer                   $id
 * @property string                    $title
 * @property string                    $slug
 * @property string                    $message
 * @property string                    $author_name
 * @property string                    $author_email
 * @property string                    $author_kik
 * @property string                    $author_snapchat
 * @property string|null               $author_phone
 * @property string                    $author_phone_whatsapp
 * @property string|null               $author_zip
 * @property string|null               $author_town
 * @property string                    $author_country
 * @property boolean                   $commercial
 * @property integer                   $status
 * @property-read Picture[]|Collection $pictures
 * @property-read Tag[]|Collection     $tags
 * @property-read Reply[]|Collection   $replies
 * @property \Carbon\Carbon            $expires_at
 * @property \Carbon\Carbon|null       $created_at
 * @property \Carbon\Carbon|null       $updated_at
 * @mixin \Eloquent
 */
class Ad extends Model
{
    protected $guarded = ['id'];
    protected $with    = ['pictures'];
    protected $dates   = ['expires_at'];

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_BANNED    = 'banned';

    const EMAIL_WEEKS_BANNED_AFTER_VIOLATION = 4;


    public static function search($query): \Illuminate\Support\Collection
    {
        $firstPrioAds = Ad::where(function (Builder $builder) use ($query) {
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


    public function ban(): void
    {
        if (!auth()->check()) {
            throw new UnauthorizedHttpException("", "Only Authenticated Administrators can ban an ad!");
        }

        $this->update(['status' => static::STATUS_BANNED]);
        $this->sendBanEmail();
    }


    public static function getAuthorBannedUntil(string $email): ?Carbon
    {
        $latestBannedAd = static::query()->where('author_email', $email)
            ->where('status', static::STATUS_BANNED)
            ->where('created_at', '>', now()->subWeeks(static::EMAIL_WEEKS_BANNED_AFTER_VIOLATION))
            ->max('created_at');

        return $latestBannedAd
            ? (new Carbon($latestBannedAd))->addWeeks(static::EMAIL_WEEKS_BANNED_AFTER_VIOLATION)
            : null;
    }


    public function isBanned(): bool
    {
        return $this->status === static::STATUS_BANNED;
    }


    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }


    public function isPublished(): bool
    {
        return $this->status === static::STATUS_CONFIRMED;
    }


    public function isActive(): bool
    {
        return $this->isPublished() and !$this->isExpired();
    }


    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }


    public function getCanonicalUrl()
    {
        return route('ad.show', ['ad' => $this, 'slug' => $this->getSlug()]);
    }


    public function getShortUrl()
    {
        return route('ad.show', ['ad' => $this, 'slug' => null]);
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


    public function getKikUrl(): ?string
    {
        if ($this->author_kik) {
            return "https://kik.me/" . $this->author_kik;
        }
    }


    public function getSnapchatUrl(): ?string
    {
        if ($this->author_snapchat) {
            return "https://www.snapchat.com/add/" . $this->author_snapchat;
        }
    }


    public function getShareLinkMarkup()
    {
        $randomId = str_random(8);

        return "
            <div class='row'>
                <div class='col-sm-3 text-center mt-2'>
                    <a class='btn btn-light btn-md' target='_blank' href='{$this->getTwitterShareLink()}'>
                        <i class='fab fa-twitter'></i> Share <span class='d-sm-none d-md-inline'>on Twitter</span>
                    </a>
                </div>
                <div class='col-sm-3 text-center mt-2'>
                    <a class='btn btn-light btn-md' target='_blank' href='{$this->getFacebookShareLink()}'>
                        <i class='fab fa-facebook'></i> Share <span class='d-sm-none d-md-inline'>on Facebook</span>
                    </a>
                </div>
                <div class='col-sm-6 mt-2 text-center'
                     style='border-radius: 10px; margin: auto;'>
                     <table>
                        <tr>
                            <td width='1%'><label for='direct_link_" . $randomId . "'><b>Link</b>&nbsp;&nbsp;</label></td>
                            <td width='99%'><input type='text' id='direct_link_" . $randomId . "' onfocus='this.select()' onclick='this.select()' readonly
                           class='form-control d-inline' value='{$this->getShortUrl()}'/></td>
                        </tr>
                    </table>    
                </div>
            </div>";
    }


    public function getTwitterShareLink()
    {
        // final "\n" is important to separate the url from the text in the tweet
        $text     = urlencode("Hey, I've just posted this ad!\nPlease visit, comment and retweet!\n");
        $hashTags = str_replace(" ", "", implode(",", $this->tags()->pluck('tag')->all()));
        $url      = $this->getCanonicalUrl();

        return "https://twitter.com/intent/tweet?text=$text&hashtags=$hashTags&url=$url";
    }


    public function getFacebookShareLink()
    {
        return "https://www.facebook.com/sharer.php?u=" . urlencode($this->getCanonicalUrl());
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
        if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
            $image = (new ImageManager())->make($file->getRealPath());
            $image->orientate();
            $image->save();
        }
        \Storage::putFileAs('images/' . $this->id, $file, $fileName);
        $thumbnailFileName = Picture::makeThumbnail($file, $this, explode(".", $fileName)[0]);
        $this->pictures()->create([
            'url'           => \Storage::url('images/' . $this->id . "/" . $fileName),
            'thumbnail_url' => \Storage::url('images/' . $this->id . "/" . $thumbnailFileName),
        ]);
    }


    public function sendConformationEmail(): void
    {
        \Mail::send(new PublishAd($this));
    }


    public function sendBanEmail()
    {
        \Mail::send(new BanAd($this));
    }


    public function sendReply(string $name, string $email, string $phone, string $message): void
    {
        $this->replies()->create([
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'message' => $message,
        ]);
        \Mail::to($this->author_email)->send(new ReplyAd($this, $name, $phone ?? '', $email, $message));
    }
}
