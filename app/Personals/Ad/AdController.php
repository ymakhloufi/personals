<?php

namespace Personals\Ad;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdController extends Controller
{
    public function index()
    {
        $viewableAds = Ad::where('status', 'active')->where('expires_at', '>', Carbon::now())->take(30)->get();

        return view('ads.index', ['ads' => $viewableAds]);
    }


    public function write()
    {
        return view('ads.write', ['countries' => config('countries')]);
    }
}
