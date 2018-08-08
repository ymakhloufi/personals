<?php

namespace Personals\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyAdRequest;
use App\Http\Requests\StoreAdRequest;
use Carbon\Carbon;

class AdController extends Controller
{
    const RESULTS_PER_PAGE = 25;


    public function index()
    {
        if (is_numeric(request('page')) and request('page') <= 1) {
            return redirect("/", 301);
        }

        $viewableAds = Ad::where('status', Ad::STATUS_CONFIRMED)
            ->where('expires_at', '>', Carbon::now())
            ->orderByDesc('id');

        return view('ads.index', [
            'simplePaginator' => $viewableAds->simplePaginate(static::RESULTS_PER_PAGE),
            'fullPaginator'   => $viewableAds->paginate(static::RESULTS_PER_PAGE),
            'tagCloud'        => Tag::getTagCloud(),
            'title'           => config('app.name') . " - " . config('app.description'),
        ]);
    }


    public function search()
    {
        if (!$query = trim(request('q', ''))) {
            session()->flash('error', __('The requested search term was invalid.'));

            return redirect('/');
        }

        return view('ads.search', [
            'ads'      => Ad::search($query)->filter(function (Ad $ad) {
                return $ad->isPublished() and !$ad->isExpired();    // remove expired and unconfirmed ads
            }),
            'tagCloud' => Tag::getTagCloud(),
            'title'    => $query,
        ]);
    }


    public function reply(ReplyAdRequest $request, Ad $ad)
    {
        $ad->sendReply(
            $request->get('name'),
            $request->get('email'),
            $request->get('phone') ?? '',
            $request->get('message')
        );

        session()->flash('success', __('Your message has been sent. Good Luck!'));

        return redirect('/');
    }


    public function show(Ad $ad)
    {
        if ($ad->status !== Ad::STATUS_CONFIRMED) {
            return response(__("This ad has not been confirmed yet - please check your email inbox"), 403);
        }

        return view('ads.show', ['ad' => $ad,]);
    }


    public function showByTag(string $tag)
    {
        $tag = Tag::where('tag', '=', $tag)->orderByDesc('id')->first();
        $ads = $tag->ads()->where('status', Ad::STATUS_CONFIRMED)->where('expires_at', '>', Carbon::now());

        return view('ads.index', [
            'tag'             => $tag,
            'simplePaginator' => $ads->simplePaginate(static::RESULTS_PER_PAGE),
            'fullPaginator'   => $ads->paginate(static::RESULTS_PER_PAGE),
            'tagCloud'        => Tag::getTagCloud(),
            'title'           => $tag->tag,
        ]);
    }


    public function publish(Ad $ad, string $token)
    {
        if (!$ad->publishAd($token)) {
            return response(__("The confirmation token is invalid."));
        }

        session()->flash('success', __('Your Ad has been published successfully!'));

        return redirect()->route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()]);
    }


    public function write()
    {
        return view('ads.write', [
            'countries'       => config('countries'),
            'tagsPlaceholder' => (Tag::inRandomOrder()->first()->tag ?? 'tag1') . ', ' .
                                 (Tag::inRandomOrder()->first()->tag ?? 'tag2') . ', ' . '...',
        ]);
    }


    public function store(StoreAdRequest $request)
    {
        $adminPublish = (\Auth::check() and $request->get('admin_publish'));

        /** @var Ad $ad */
        $ad = Ad::make($request->only([
            'title',
            'text',
            'author_name',
            'author_age',
            'author_email',
            'author_kik',
            'author_snapchat',
            'author_phone',
            'author_zip',
            'author_town',
            'author_country',
        ]));

        $ad->status                = $adminPublish ? Ad::STATUS_CONFIRMED : Ad::STATUS_PENDING;
        $ad->expires_at            = Carbon::now()->addMonths(env('AD_DEFAULT_EXPIRY_IN_MONTHS', 1))->toDateTimeString();
        $ad->author_phone_whatsapp = (int) ($request->get('author_phone') and $request->has('author_phone_whatsapp'));
        $ad->commercial            = $request->has('commercial');
        $ad->save();

        // tags are POSTed as a comma-separated list
        $tags = array_filter(array_map('trim', explode(',', $request->get('tags'))));
        foreach ($tags as $tagString) {
            $tag = Tag::firstOrCreate(['tag' => $tagString]);
            $ad->tags()->sync([$tag->id], false);
        }

        // attach pictures to Ad
        foreach ($request->file('image') ?? [] as $file) {
            $ad->addPicture($file);
        }

        if ($adminPublish) {
            session()->flash('success', __('Your Ad has been published successfully!'));

            return redirect()->route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()]);
        } else {
            // send confirmation email
            $ad->sendConformationEmail($request->get('author_email'));

            session()->flash(
                'success',
                __('We have sent you a confirmation email. Please check your email inbox and ' .
                   'click on the confirmation link in order to make the publish the ad on our page.')
            );

            return redirect('/');
        }
    }
}
