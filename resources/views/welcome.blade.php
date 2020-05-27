<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <title>{{ env('APP_NAME') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icono-pdf.png') }}" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
        <script src="{{ asset('js/dropzone.js') }}"></script>
    </head>
    <body>

        <script src="{{ asset('js/jquery-3.5-1.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    </body>
</html>
