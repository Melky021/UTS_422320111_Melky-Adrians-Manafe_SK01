<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Bank Benih Pusaka</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/benih.css') }}">
    @stack('styles')
</head>
<body>
    <div class="shell">
        @include('partials.sidebar')

        <main class="main">
            @include('partials.flash')
            @yield('content')
            @include('partials.footer')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
