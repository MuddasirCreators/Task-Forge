<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>

        @yield('title', 'TaskForge')

        — Work. Track. Deliver.

    </title>

    {{-- Favicon --}}
    <link rel="icon"
          type="image/png"
          href="{{ asset('images/favicon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css"
          rel="stylesheet">

    {{-- Project CSS --}}
    <link rel="stylesheet"
          href="{{ asset('css/app.css') }}">

    {{-- Extra Styles --}}
    @stack('styles')

</head>

<body>

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="tf-layout">

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <main class="tf-main">

            @yield('content')

        </main>

    </div>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Bootstrap JS (Required for Modal) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Tom Select --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    {{-- Flash Messages --}}
    @include('components.alerts')

    {{-- Page Scripts --}}
    @stack('scripts')

</body>

</html>