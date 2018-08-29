{{ __('Publish Your Ad') }}

{{ __('Verify your email address by clicking the link below or copying it into the address bar of your browser. As soon as you have done it, we will publish your ad right away!') }}

{{ route('ad.publish', ['ad' => $ad, 'token' => $ad->getActivationToken()]) }}

{{ __('Your Ad will be online for: ') . env('AD_DEFAULT_EXPIRY_IN_MONTHS') ." " . str_plural('month', env('AD_DEFAULT_EXPIRY_IN_MONTHS', 1)) . "."}}

{{ __('Thanks,') }}
{{ config('app.name') }}
