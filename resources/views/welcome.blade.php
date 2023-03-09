<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')

    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        @auth
            <home nombre="{{ auth()->user()->name }}"></home>
        @else
            <login />
        @endauth
    </div>
</body>

</html>
