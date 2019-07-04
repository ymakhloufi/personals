@component('mail::message')
# {{__('Your Ad Has Been Banned')}}

{{__('Your ad has been flagged by our community and banned by an administrator for violating our community standards. Please note that while we do not censor any text or pictures, we still do not permit any ads which express a financial motivation or ads with illegal content as per US or EU laws.')}}

@component('mail::button', ['url' => route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()])])
{{ __('View Your Ad') }}
@endcomponent

{{__('Thanks for your understanding,')}}<br>
{{ config('app.name') }}
@endcomponent
