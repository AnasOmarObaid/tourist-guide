<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboards/css/main.min.css') }}">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>Login | Tourist Guide</title>
  </head>

  <body>

    {{ $slot }}

    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('dashboards/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('dashboards/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboards/js/main.js') }}"></script>

  </body>
</html>
