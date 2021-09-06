<!DOCTYPE html>


<html lang="en" class="" style="height: auto;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Admin') }}</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <div id="app">
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
