@extends('layout.main')

@section('title', config('app.name'))

@section('content')

    <div class="jumbotron jumbotron-fluid p-4">
        <h1 class="text-lg-center">Welcome to {{config('app.name')}}</h1>
        <p class="lead">This is a 100% free portal to post, read and answer personal ads from people around you!</p>
    </div>

    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
            <th style="white-space: nowrap;">{{__('Name (Age)')}}</th>
            <th style="min-width: 125px;">{{__('Title')}}</th>
            <th class="d-none d-sm-table-cell">{{__('Text')}}</th>
            <th class="d-none d-sm-table-cell">{{__('Pictures')}}</th>
            </thead>
            <tbody>
            @foreach($ads as $ad)
                <tr class="clickable-row" style="cursor: pointer;" data-href='ads/{{$ad->id}}/{{$ad->getSlug()}}'>
                    <td>{{$ad->author_name}} @if($ad->author_age)({{$ad->author_age}})@endif</td>
                    <td><a href="ads/{{$ad->id}}/{{$ad->getSlug()}}">{{$ad->title}}</a></td>
                    <td class="d-none d-sm-table-cell">{{$ad->getShortenedText()}}</td>
                    <td class="d-none d-sm-table-cell">{{$ad->has('pictures') ? "yes" : "no"}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
