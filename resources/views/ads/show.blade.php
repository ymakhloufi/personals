@extends('layout.main')

@section('title', config('app.name'))

@section('content')
    <div class="container mt-4 p-4" style="border: 1px solid #ddd; border-radius: 10px;">
        <h1 class="text-center">{{$ad->title}}</h1>
        <div class="row">
            <div class="col-sm-3 mb-4" style="border-right: 1px solid lightgray;">
                @if($ad->pictures()->exists())
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{$ad->pictures()->first()->url}}" target="_blank" id="preview_link">
                                <img src="{{$ad->pictures()->first()->url}}" style="width: 100%;" id="preview_img">
                            </a>
                        </div>
                    </div>
                    @if($ad->pictures()->count() > 1)
                        <div class="row mt-3 ml-2">
                            @foreach($ad->pictures as $pic)
                                <div style="width:30%;" class="m-1">
                                    <a href="javascript: swapImg('{{$pic->url}}');">
                                        <img style="max-width: 100px; width:100%; max-height: 75px;"
                                             src="{{$pic->url}}"/>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <i class="fa fa-user fa-8x"></i>
                @endif
            </div>
            <div class="col-sm-9">
                <h3>
                    <b>{{$ad->author_name}}</b>
                    @if($ad->author_age)({{$ad->author_age}})@endif
                </h3>
                <div class="row">
                    <div class="col-sm-12">
                        <span style="display: inline-block;">
                            <i class="fa fa-map-marker-alt"></i>
                            @if($ad->author_town)
                                <span class="d-none d-sm-inline">{{($ad->author_zip ?? '') . " "}}</span>
                                {{$ad->author_town.","}}
                            @endif
                            {{ucwords(strtolower(config('countries.all')[$ad->author_country]['name'] ?? ''))}}
                        </span>
                        <span style=" text-align: right; display:inline-block; float:right;">
                        @if($ad->author_phone)
                                <span style="white-space: nowrap;">
                                    &nbsp; <i class="fa fa-phone"></i>
                                    <a href="tel:{{$ad->author_phone}}" target="_blank">
                                        {{$ad->author_phone}}
                                    </a>
                                </span>
                            @endif
                            @if($ad->author_phone_whatsapp and $ad->getWhatsAppUrl())
                                <span style="white-space: nowrap;">
                                    &nbsp; | &nbsp; <i class="fab fa-whatsapp fa-1x"></i>
                                    <a href="{{$ad->getWhatsAppUrl()}}" target="_blank">Whatsapp</a>
                                </span>
                            @endif
                            <span style="white-space: nowrap;">
                            &nbsp; | &nbsp; <i class="far fa-envelope"></i>
                                    <a href="javascript:mailTo('{{bin2hex($ad->author_email)}}');"
                                       target="_blank"> {{__("Email")}}</a>
                                </span>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <span style="display: inline-block; font-size: 9pt;">
                            {{__('Posted:')}} {{$ad->created_at->diffForHumans()}}
                        </span>
                    </div>
                    <div class="col-sm-8">
                        <span style="display: inline-block; float:right;">
                            @if($ad->tags()->exists())
                                Tags:
                                @foreach($ad->tags as $tag)
                                    <a style="white-space: nowrap" class="ml-3" href="/tags/{{$tag->tag}}">
                                        #{{$tag->tag}}
                                    </a>
                                @endforeach
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        {!! nl2br(e($ad->text))!!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .fa-whatsapp {
            color: #fff;
            background: linear-gradient(#25d366, #25d366) 1px 84%/4px 4px no-repeat,
            radial-gradient(circle at center, #25d366 63%, transparent 0);
            stroke: #1b1e21;
            stroke-width: 2px;
        }
    </style>

    <script language="JavaScript">
        function mailTo (encodedEmail) {
            window.location.href = 'mailto:' +
                encodedEmail.replace(/.{1,2}/g, (temp) => String.fromCharCode(parseInt(temp, 16)));
        }

        function swapImg (url) {
            _('preview_img').src = url;
            _('preview_link').href = url;
        }
    </script>
@endsection
