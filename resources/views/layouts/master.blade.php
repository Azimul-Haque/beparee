
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user" content="{{ Auth::user() }}">
  
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
  <meta property="og:url" content="{{ Request::url() }}" />
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

  <title>@yield('title')</title>
  <!-- Styles -->
  {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
  {!! Packer::css('/css/app.css', '/storage/cache/css/app.css') !!}

  <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149690696-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-149690696-1');
    </script>
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
<div class="wrapper" id="app">
  
  @include('layouts._navbar')

  @include('layouts._sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <admin-main></admin-main>
    <vue-progress-bar></vue-progress-bar>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <center>
        <h5>সারাদিনের জমা খরচ</h5>
        <p>{{ bangla(date('F d, Y')) }}</p>
      </center>
      
      <p v-html="dailyDebitCreditText(this.alltransactionstoday)" style="height: 650px; overflow-y: auto; display: block;"></p>
      {{-- <p>ক্রয়ঃ 220 ৳ | <small>08:46 PM</small></p>
      <p>বিক্রয়ঃ 570 ৳ | <small>08:46 PM</small></p>
      <p>খরচঃ 230 ৳ | <small>08:46 PM</small></p>
      <p>ক্রয়ঃ 320 ৳ | <small>08:46 PM</small></p>
      <p>বিক্রয়ঃ 70 ৳ | <small>08:46 PM</small></p>
      <p>খরচঃ 230 ৳ | <small>08:46 PM</small></p>

      <br/><br/>
      <center>
        <a href="">
          <small>সর্বশেষ তথ্য দেখতে না পেলে রিলোড করুন</small>
        </a>
      </center> --}}
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <small>যে কোন সমসসায় কল করুনঃ <b><a href="tel:+8801312540450">01312540450</a></b></small> Version: <b>2.0.0</b>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">দোকান খাতা</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<!-- Scripts -->

@auth
<script>
    window.roles = @json(auth()->user()->roles); // for User Roles
    window.permissions = @json(auth()->user()->roles->load('permissions')); // for User Permission
    window.stores = @json(auth()->user()->stores); // for User Stores
</script>
@endauth

{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
{!! Packer::js('/js/app.js', '/storage/cache/js/app.js') !!}
</body>
</html>
