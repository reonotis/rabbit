<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        {{-- css --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}?<?= date('YmdHis'); ?>">
        <link rel="stylesheet" href="{{ asset('css/guest.css') }}?<?= date('YmdHis'); ?>">

        {{-- java script --}}
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="{{ asset('js/app.js') }}?<?= date('YmdHis'); ?>" defer></script>
        <script src="{{ asset('js/guest.js') }}?<?= date('YmdHis'); ?>" defer></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">

            <!-- Page Heading -->
            <x-common.flash-message class="mb-4"></x-common.flash-message>
            {{ $slot }}
        </div>
    </body>
</html>
