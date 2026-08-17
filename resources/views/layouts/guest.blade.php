<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TaskForge')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

</head>

<body>

    @yield('content')

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Global Alerts --}}
    @include('components.alerts')

    {{-- Extra Page Scripts --}}
    @stack('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>