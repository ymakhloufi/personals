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
                                    <a href="#reply"> {{__("Reply")}}</a>
                                </span>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <span style="display: inline-block; font-size: 9pt;">
                            {{__('Posted:')}} {{$ad->created_at->diffForHumans()}}
                        </span>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        {!! nl2br(e($ad->text))!!}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        @if($ad->tags()->exists())
                            <b>Tags:</b>
                            @foreach($ad->tags as $tag)
                                <a style="white-space: nowrap" class="ml-3"
                                   href="{{route('tag.show', ['tag' => $tag->tag])}}">
                                    #{{$tag->tag}}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 border-top" style="padding-top: 20px;" id="reply">
            <div class="col-sm-12">
                <form method="post" action="{{route('ad.reply', ['ad' => $ad])}}">
                    {{csrf_field()  }}
                    <h2 class="mb-3">Reply to ths Ad</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="form-control mt-1" placeholder="Your Name" required name="name" type="text"
                                   value="{{old('name')}}"/>
                            <input class="form-control mt-1" placeholder="Your Email Address" required name="email"
                                   value="{{old('email')}}"
                                   type="email"/>
                            <input class="form-control mt-1 mb-1" placeholder="Your Phone Number" name="phone"
                                   value="{{old('phone')}}"/>
                        </div>
                        <div class="col-sm-6">
                        <textarea class="form-control" placeholder="Your Message" required name="message"
                                  style="height:100%; min-height: 100px;">{{old('message')}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-center">
                            <div style="transform:scale(0.95);transform-origin:0 0;"> {!! NoCaptcha::display() !!}</div>
                            <button type="submit" class="btn btn-warning">Send Reply</button>
                        </div>
                    </div>
                </form>
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
        function mailTo(encodedEmail) {
            window.location.href = 'mailto:' +
                encodedEmail.replace(/.{1,2}/g, (temp) => String.fromCharCode(parseInt(temp, 16)));
        }

        function swapImg(url) {
            _('preview_img').src = url;
            _('preview_link').href = url;
        }
    </script>
@endsection