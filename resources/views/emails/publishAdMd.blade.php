@component('mail::message')
# {{__('Publish Your Ad')}}

{{__('Verify your email address by clicking the button below. As soon as you click on the link below, we will publish your ad right away!')}}

@component('mail::button', ['url' => route('ad.publish', ['ad' => $ad, 'token' => $ad->getActivationToken()])])
{{__('Publish Ad')}}
@endcomponent

{{ __('Your Ad will be online for: ') . env('AD_DEFAULT_EXPIRY_IN_MONTHS') ." " . str_plural('month', env('AD_DEFAULT_EXPIRY_IN_MONTHS', 1)) . "."}}

{{__('Thanks,')}}<br>
{{ config('app.name') }}
@endcomponent
