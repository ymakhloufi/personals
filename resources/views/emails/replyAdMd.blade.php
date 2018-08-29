@component('mail::message')
# {{$name}} {{__('Replied To Your Ad!')}}

{{__('Just reply to this email to answer them!')}}

@component('mail::table')
|           |            |
|:--------- |:---------- |
| {{ __('Name:') }}      | {{$name}}  |
| {{ __('Email:') }}     | {{$email}} |
| {{ __('Phone:') }}     | {{$phone}} |
|           |            |
@endcomponent

{!! nl2br(e($text)) !!}

@component('mail::button', ['url' => route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()])])
{{ __('View Your Ad') }}
@endcomponent

@endcomponent
