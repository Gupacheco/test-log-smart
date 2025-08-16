<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Log Smart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gHk0rH+6E6pRg+8EfpGL+Ra/0nYFkBPR2qfX3z6gXJKJ2e0C5bH6P7LrYdjKm2mN" crossorigin="anonymous">
</head>

<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS Bundle (com Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MRCkqJ2E+4n1P+H7f2aN4B1w+q3k1FjYg9vYwH3hx1z2k2rYw6w5s7ZP2vM8R9lF" crossorigin="anonymous">
    </script>
</body>

</html>