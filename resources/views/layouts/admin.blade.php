<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('admin.partials.nav') 
    <main class="admin-main">
        @yield('content')
    </main>

</body>
</html>