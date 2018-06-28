@extends('layout.main')

@section('title', config('app.name'))

@section('content')

    <style>
        .img-placeholder {
            width: 66px;
            height: 66px;
            border: 1px solid #aaa;
        }

        .img-preview {
            border: 1px solid #aaa;
            max-width: 66px;
            max-height: 66px;
            padding: 5px;
        }

        .title-link {
            font-size: 1.5em;
        }

        .author {
            font-style: italic;
            font-size: 0.8em;
        }

        .location {
            font-weight: bold;
            font-size: 0.8em;
        }

        .tags {
            font-size: 0.8em;
        }

        .tags > a {
            margin-right: 5px;
        }
    </style>

    <div class="jumbotron jumbotron-fluid p-4"
         style="text-align: center; color: #444; background: #fceabb; background: linear-gradient(10deg, #f7d785 0%,#fccd4d 100%);">
        <h1 class="text-lg-center">{{config('app.name')}}</h1>
        <h2 class="lead">{{config('app.description')}}</h2>
    </div>

    <div class="container">
        <table class="table table-hover">
            <tbody>
            @foreach($ads as $ad)
                <tr class="clickable-row" style="cursor: pointer;" data-href='ads/{{$ad->id}}/{{$ad->getSlug()}}'>
                    <td class="d-none d-sm-table-cell">
                        @if($ad->pictures()->exists())
                            <img src="{{$ad->pictures()->first()->url}}" class="img-preview"/>
                        @else
                            <div class="img-placeholder"></div>
                        @endif
                    </td>
                    <td>
                        <a class="title-link" href="ads/{{$ad->id}}/{{$ad->getSlug()}}">{{$ad->title}}</a>
                        <span class="author">{{$ad->author_name}} @if($ad->author_age)({{$ad->author_age}})@endif</span>
                        <div class="ad-text">{{$ad->getShortenedText()}}</div>
                        <div class="tags">
                            @foreach($ad->tags as $tag)
                                <a href="/tags/{{$tag->tag}}">#{{$tag->tag}}</a>
                            @endforeach
                        </div>
                        <span class="location">
                            @if($ad->author_town)
                                <span class="d-none d-sm-inline">{{($ad->author_zip ?? '') . " "}}</span>
                                {{$ad->author_town.","}}
                            @endif
                            {{$ad->author_country}}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
