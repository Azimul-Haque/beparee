
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user" content="{{ Auth::user() }}">

  <title>@yield('title')</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  
  @include('layouts._navbar')

  @include('layouts._sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>
        Sidebar content
      </p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Version: <b>1.0.28</b>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="http://orbachinujbuk.com/">Orbachin Ujbuk</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<!-- Scripts -->

@auth
<script>
    window.roles = @json(auth()->user()->roles); // for User Roles
    window.permissions = @json(auth()->user()->roles->load('permissions')); // for User Permission
    window.stores = @json(auth()->user()->stores); // for User Stores
    console.log(window.stores);
</script>
@endauth

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
