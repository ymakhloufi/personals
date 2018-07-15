{{$name}} {{__('Replied To Your Ad!')}}

{{__('Just reply to this email to answer them!')}}

{{ __('Name:') }} {{$name}}
{{ __('Email:') }} {{$email}}
{{ __('Phone:') }} {{$phone}}

{!! nl2br(e($text)) !!}

{{ __('Link to your ad:') }}
route('ad.tag.show', ['ad' => $ad, 'slug' => $ad->getSlug()])

{{ __('Best,') }}
{{ config('app.name') }}
