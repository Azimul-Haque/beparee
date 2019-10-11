<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ Auth::user() }}">
    <title>@yield('title')</title>

    <meta name="description" content="দোকান খাতা (Dokan Khata) অনলাইন প্লাটফর্ম, সব হিসাব এখানেই! আপনার যাবতীয় ব্যবসায়ী হিসাব এখন সহজ করে দিতে আমরা এসেছি আপনার প্রতিষ্ঠানে! &copy; Copyright Reserved {{ date('Y') }}">
    <meta name="keywords" content="দোকান খাতা, দোকান, খাতা,  Dokan Khata, Dokan, Khata, shop, store, business, Bangladesh">
    <meta name="author" content="A. H. M. Azimul Haque">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons//manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicons/ms-icon-144x144.png') }}">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">
    <meta name="mobile-web-app-capable" content="yes">

    {{-- og --}}
    <meta property="og:image" content="{{ asset('images/fb.jpg') }}" />
    <meta property="og:title" content="দোকান খাতা (Dokan Khata), সব হিসাব এখানেই!"/>
    <meta property="og:description" content="আপনার যাবতীয় ব্যবসায়ী হিসাব এখন সহজ করে দিতে আমরা এসেছি আপনার প্রতিষ্ঠানে! &copy; Copyright Reserved {{ date('Y') }}" />
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ Request::url('/') }}" />
    <meta property="og:site_name" content="দোকান খাতা (Dokan Khata)">
    <meta property="og:locale" content="en_US">
    <meta property="fb:admins" content="100001596964477">
    <meta property="fb:app_id" content="163879201229487">
    <meta property="og:type" content="article">
    <!-- Open Graph - Article -->
    <meta name="article:section" content="দোকান খাতা (Dokan Khata)">
    <meta name="article:published_time" content="{{ date('F d, Y') }}">
    <meta name="article:author" content="A. H. M. Azimul Haque">
    <meta name="article:tag" content="Product">
    <meta name="article:modified_time" content="{{ date('F d, Y') }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    {{-- og --}}

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700,800,900|Roboto+Slab:400,700" rel="stylesheet"> --}}

    <!-- Styles -->
    <!-- Stylesheets
    ============================================= -->
    {!! Packer::css('/vendor/canvas/css/bootstrap.min.css', '/storage/cache/vendor/canvas/css/bootstrap.min.css') !!}
    {!! Packer::css('/vendor/canvas/style.css', '/storage/cache/vendor/canvas/style.css') !!}
    {!! Packer::css('/vendor/canvas/css/dark.css', '/storage/cache/vendor/canvas/css/dark.css') !!}
    {{-- {!! Packer::css('/vendor/canvas/css/font-icons.css', '/storage/cache/vendor/canvas/css/font-icons.css') !!} --}}
    {!! Packer::css('/vendor/canvas/css/font-awesome.min.css', '/storage/cache/vendor/canvas/css/font-awesome.min.css') !!}
    {!! Packer::css('/vendor/canvas/css/animate.css', '/storage/cache/vendor/canvas/css/animate.css') !!}
    {{-- {!! Packer::css('/vendor/canvas/css/magnific-popup.css', '/storage/cache/vendor/canvas/css/magnific-popup.css') !!} --}}

    {!! Packer::css('/vendor/canvas/css/responsive.css', '/storage/cache/vendor/canvas/css/responsive.css') !!}
    <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    @yield('css')
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149690696-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-149690696-1');
    </script>
    <!-- Google Tag Manager -->
    {{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PBXL2GW');</script> --}}
    <!-- End Google Tag Manager -->
</head>
<body class="stretched">
    <!-- Google Tag Manager (noscript) -->
    {{-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBXL2GW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> --}}
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        <!-- Document Wrapper
        ============================================= -->
        <div id="wrapper" class="clearfix">

            @include('layouts._landingnav')


            <main>
                @yield('content')
            </main>

            @include('layouts._landingfooter')

        </div>
        <!-- Go To Top
        ============================================= -->
        <div id="gotoTop" class="icon-angle-up"></div>
    </div>
    

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="{{ asset('vendor/canvas/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/canvas/js/plugins.js') }}"></script>

    <!-- Footer Scripts
    ============================================= -->
    <script type="text/javascript" src="{{ asset('vendor/canvas/js/functions.js') }}"></script>

    
    @yield('js')
</body>
</html>
