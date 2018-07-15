{{ __('Publish Your Ad') }}

{{ __('Verify your email address by clicking the link below or copying it into the address bar of your browser. As soon as you are verified, we will publish your ad right away!') }}

{{ route('ad.publish', ['ad' => $ad, 'token' => $ad->getActivationToken()]) }}

{{ __('Your Ad will be online for:') . env('AD_DEFAULT_EXPIRY_IN_WEEKS') .__('weeks.')}}

{{ __('Thanks,') }}
{{ config('app.name') }}
