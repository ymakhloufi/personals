<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', config('app.description'))">
    <meta name="keywords" content="@yield('keywords', config('app.keywords'))">
    <link rel="canonical" href="@yield('canonicalUrl', URL::full())"/>

    <meta property="og:title" content="@yield('title', config('app.name'))"/>
    <meta property="og:description" content="@yield('description', config('app.description'))"/>
    <meta property="og:url" content="@yield('canonicalUrl', URL::full())"/>
    <meta property="og:image" content="@yield('og-image', env('LOGO_URL', asset('/img/logo_white.png')))"/>

    <script src="{{asset("js/app.js")}}"></script>
    {!! \NoCaptcha::renderJs() !!}
    <link rel="stylesheet" href="{{asset("/css/app.css")}}"/>
    <link rel="stylesheet" href="/css/checbox.css">
    <title>@yield('title', config('app.name'))</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Tahoma', sans-serif;
            font-size: 11pt;
            height: 100vh;
            margin: 0;
        }

        .position-ref {
            position: relative;
        }
    </style>
</head>
<body>
@include('layout._navigation')

<div class="position-ref">
    <div id="content">
        @yield('content')
    </div>
</div>

<script language="JavaScript">
    function _ (id) {
        return document.getElementById(id);
    }

    jQuery(document).ready(function ($) {
        $('.clickable-row').click(function () {
            window.location = $(this).data('href');
        });
    });
</script>
</body>
</html>
