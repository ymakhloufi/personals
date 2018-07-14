<?php

namespace Personals\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdRequest;
use App\Mail\PublishAd;
use Carbon\Carbon;

class AdController extends Controller
{
    public function index()
    {
        $viewableAds = Ad::where('status', Ad::STATUS_CONFIRMED)
            ->where('expires_at', '>', Carbon::now())
            ->take(30)
            ->get();

        return view('ads.index', [
            'ads'      => $viewableAds,
            'tagCloud' => Tag::getTagCloud(),
        ]);
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
        $tag = Tag::where('tag', '=', $tag)->first();

        return view('ads.index', [
            'tag'      => $tag,
            'ads'      => $tag->ads,
            'tagCloud' => Tag::getTagCloud(),
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
        return view('ads.write', ['countries' => config('countries')]);
    }


    public function store(StoreAdRequest $request)
    {
        /** @var Ad $ad */
        $ad = Ad::make($request->only([
            'title',
            'text',
            'author_name',
            'author_age',
            'author_email',
            'author_phone',
            'author_zip',
            'author_town',
            'author_country',
        ]));

        $ad->status                = Ad::STATUS_PENDING;
        $ad->expires_at            = Carbon::now()->addWeeks(4)->toDateTimeString();
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

        // send confirmation email
        \Mail::to($request->get('author_email'))->send(new PublishAd($ad));

        session()->flash(
            'success',
            __('We have sent you a confirmation email. Please check your email inbox and ' .
               'click on the confirmation link in order to make the publish the ad on our page.')
        );

        return redirect('/');
    }
}
