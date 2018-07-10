<?php

namespace Personals\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdRequest;
use Carbon\Carbon;

class AdController extends Controller
{
    public function index()
    {
        $viewableAds = Ad::where('status', Ad::STATUS_CONFIRMED)
            ->where('expires_at', '>', Carbon::now())
            ->take(30)
            ->get();

        return view('ads.index', ['ads' => $viewableAds]);
    }


    public function show(Ad $ad)
    {
        return view('ads.show', ['ad' => $ad,]);
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

        $ad->status                = Ad::STATUS_CONFIRMED;    // ToDo: change to "STATUS_PENDING"
        $ad->expires_at            = Carbon::now()->addWeeks(4)->toDateTimeString();
        $ad->author_phone_whatsapp = $request->get('author_phone') and $request->has('author_phone_whatsapp');
        $ad->commercial            = $request->has('commercial');

        $ad->save();

        foreach ($request->file('image') ?? [] as $file) {
            $ad->addPicture($file);
        }

        // ToDo: Send Activation email

        session()->flash(
            'success',
            __('We have sent you a confirmation email. Please check your email inbox and ' .
               'click on the confirmation link in order to make the ad visible on our page.')
        );

        return redirect('/');
    }
}
