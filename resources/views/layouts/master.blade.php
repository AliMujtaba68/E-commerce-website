<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

     <!-- Add favicon -->
     <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/svg+xml">

    <!-- Include CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')

    <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    @include('layouts.partials.nav')
    <main class="page">
        @yield('content')
    </main>
    @include('layouts.partials.footer')

    <!-- Include necessary scripts -->
</body>
</html>
