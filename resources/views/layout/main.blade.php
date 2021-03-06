<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123171119-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-123171119-1');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', config('app.description'))">
    <meta name="keywords" content="@yield('keywords', config('app.keywords'))">
    <link rel="canonical" href="@yield('canonicalUrl', URL::full())"/>

    <meta property="og:title" content="@yield('title', config('app.name'))"/>
    <meta property="og:description" content="@yield('description', config('app.description'))"/>
    <meta property="og:url" content="@yield('canonicalUrl', URL::full())"/>
    <meta property="og:image" content="@yield('og-image', config('app.logo') ?? asset('/img/logo_white.png'))"/>
    <meta property="og:type" content="article"/>

    <script src="{{asset("js/app.js")}}" async></script>
    {!! \NoCaptcha::renderJs() !!}
    <link rel="icon" type="image/png" href="{{config('app.favicon') ?? asset('/img/favicon.png')}}"/>
    <link rel="stylesheet" href="{{asset("/css/app.css")}}"/>
    <link rel="stylesheet" href="/css/checbox.css">
    <title>@yield('title', config('app.name'))</title>
</head>
<body>
@include('layout._navigation')

<div class="position-ref">
    <div id="content">
        @yield('content')
    </div>
</div>
<footer class="page-footer font-small blue">

    <!-- Copyright -->
    <div class="text-center py-3" style="background: linear-gradient(10deg, #f7d785 0%,#fccd4d 100%); ">
        Copyright &copy; 2018: {{config('app.name')}}<br/>
        <span style="font-size: 9pt;">{!! str_replace("@", " <i class='fa fa-at'></i> ", config('mail.from.address')) !!}</span>
    </div>
    <!-- Copyright -->

</footer>

<script language="JavaScript" defer>
    makeColumnsClickable();

    function makeColumnsClickable() {
        if (window.$) {
            $(document).ready(function ($) {
                $('.clickable-row').click(function () {
                    window.location = $(this).data('href');
                });
            });
        } else {
            window.setTimeout(makeColumnsClickable, 100);
        }
    }
</script>
<noscript>
    We try our best to make this website work without javascript.
    However if you want to write or reply to an ad, we have to ask you to activate it
    in order to solve the security captcha. We might replace recaptcha with a homebrewed non-js
    variant one day, but currently the focus is on other parts of this website.
</noscript>
</body>
</html>
