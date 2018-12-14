<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title') </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Aditional CSS -->
    @yield('css')

    <!-- Favicon -->
    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon">

</head>
<body class="sidebar-dark">
  <div class="container-scroller" id="app">
    @include('layouts.partials.navbar')
    <div class="container-fluid page-body-wrapper">
      @include('layouts.partials.sidebar')
      <div class="main-panel">
        @yield('content')

        @include('layouts.partials.footer')
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- Scripts -->
  <script src="{{ asset('js/manifest.js') }}"></script>
  <script src="{{ asset('js/vendor.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- Page Scripts -->
  @yield('js')

</body>
</html>
