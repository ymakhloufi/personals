@component('mail::message')
# {{__('Publish Your Ad')}}

{{__('Your ad has been flagged by our community and banned by an administrator for violating our community standards. Please note that while we do not censor any text or pictures, we still do not permit any ads which express a financial motivation or ads with illegal content as per US or EU laws.')}}

{{ __('Link to your ad:') }}
{{route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()])}}

{{__('Thanks for your understanding,')}}<br>
{{ config('app.name') }}
@endcomponent
