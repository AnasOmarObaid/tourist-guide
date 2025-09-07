<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
      <meta name="description"
            content="is a platform that helps travelers discover cities, find events, and book hotels. We aggregate curated listings, real attendee insights, and up-to-date availability to make trip planning simple and secure.">

      <!-- Twitter meta-->
      <meta property="twitter:card" content="summary_large_image">
      <meta property="twitter:site" content="@pratikborsadiya">
      <meta property="twitter:creator" content="@pratikborsadiya">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- Open Graph Meta-->
      <meta property="og:type" content="website">
      <meta property="og:site_name" content="Vali Admin">
      <meta property="og:title" content="Vali - Free Bootstrap 5 admin theme">
      <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
      <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
      <meta property="og:description"
            content="is a platform that helps travelers discover cities, find events, and book hotels. We aggregate curated listings, real attendee insights, and up-to-date availability to make trip planning simple and secure.">


      <title>Tourist Guide</title>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      {{-- check if the language is Arabic, then load the RTL CSS file --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboards/css/main.min.css') }}">

      {{-- app css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboards/css/app.css') }}">

      <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- add css  --}}
    @yield('css')
</head>

<body class="app sidebar-mini">

      <!-- header-->
      <x-dashboard.header />

      <!-- Sidebar menu-->
      <x-dashboard.sidebar />

      {{-- main content --}}
      {{ $slot }}

      <!-- Essential javascripts for application to work-->
      <script src="{{ asset('dashboards/js/jquery-3.7.0.min.js') }}"></script>
      <script src="{{ asset('dashboards/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('dashboards/js/main.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- alerts --}}
        <x-alert.success />
        <x-alert.error />

        {{-- actions --}}
        <x-actions.delete />

      {{-- add scripts file --}}
      @yield('scripts')


</body>

</html>
