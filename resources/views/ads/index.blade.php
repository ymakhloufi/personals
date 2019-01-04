@extends('layout.main')

@section('title', $title)

@section('content')
    <div class="offset-sm-2 col-sm-8 mb-4" style="text-align: center;">{!! $tagCloud !!}</div>


    @if(isset($tag))
        <h3 style="text-align: center">
            {{__('Showing Ads for Tag')}} <b>{{$tag->tag}}</b>
            <span style="font-size:10pt;">(<a href="/">show all</a>)</span>
        </h3>
    @endif


    @if(request('q'))
        <h3 style="text-align: center">
            {{__('Showing search results for')}} <b>{{request('q')}}</b>
            <span style="font-size:10pt;">(<a href="/">show all</a>)</span>
        </h3>
    @endif

    <div class="container">
        <div class="row float-sm-right d-block d-sm-none">
            <div style="width:200px; float:right;">{!! $simplePaginator->render() !!}</div>
        </div>
        <div class="row float-sm-right d-none d-sm-block">{!! $fullPaginator->render() !!}</div>


        <table class="table table-hover">
            <tbody>
            @foreach($fullPaginator as $ad)
                <tr class="clickable-row" style="cursor: pointer;" data-href='/ads/{{$ad->id}}/{{$ad->getSlug()}}'>
                    <td class="d-none d-sm-table-cell">
                        @if($ad->pictures()->exists())
                            <a href="/ads/{{$ad->id}}/{{$ad->getSlug()}}">
                                <img src="{{$ad->pictures()->first()->thumbnail_url ?? $ad->pictures()->first()->url}}"
                                     class="img-preview" alt="{{$ad->author_name}} thumbnail image"/>
                            </a>
                        @else
                            <div class="img-placeholder"><i class=" fa fa-user fa-4x"></i></div>
                        @endif
                    </td>
                    <td>
                        <a class="title-link" href="/ads/{{$ad->id}}/{{$ad->getSlug()}}">{{$ad->title}}</a>
                        <span class="author">{{$ad->author_name}} @if($ad->author_age)({{$ad->author_age}})@endif</span>
                        <div class="summary">{{$ad->getShortenedText()}}</div>
                        <div class="tags">
                            @foreach($ad->tags as $tag)
                                <a href="{{route('tag.show', ['tag' => $tag->tag])}}">#{{$tag->tag}}</a>
                            @endforeach
                        </div>
                        <span class="location">
                            @if($ad->author_town)
                                <span class="d-none d-sm-inline">{{($ad->author_zip ?? '') . " "}}</span>
                                {{$ad->author_town.","}}
                            @endif
                            @if($ad->author_country)
                                {{ucwords(strtolower(config('countries.all')[$ad->author_country]['name'] ?? ''))}}
                            @else
                                Anywhere
                            @endif
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row float-sm-right d-block d-sm-none">
            <div style="width:200px; float:right;">{!! $simplePaginator->render() !!}</div>
        </div>
        <div class="row float-sm-right d-none d-sm-block">{!! $fullPaginator->render() !!}</div>
    </div>
@endsection
