<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' : config('app.name') }}</title>
    <link type="image x-icon" href="{{ asset('src/img/logo-favicon/default-favicon.ico') }}" rel="shortcut icon" data-navigate-once />

    {{-- CSS files --}}
    <link href="{{ asset('src/css/tabler.min.css') }}" rel="stylesheet" data-navigate-once />
    <link href="{{ asset('src/css/inter/inter.css') }}" rel="stylesheet" data-navigate-once />

    <link rel="stylesheet" type="text/css" href="{{ asset('src/css/blogs.css') }}" data-navigate-once />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/css/blog.css') }}" data-navigate-once />

    {{-- Quill Editor --}}
    <link rel="stylesheet" href="{{ asset('src/libs/quill/quill.snow.css') }}" data-navigate-once />

    <style>
        #text-editor {
            height: 350px;
        }
    </style>

    {{ $styles }}
</head>

<body>
    <script src="{{ asset('src/js/demo-theme.min.js') }}"></script>

    <div class="page">
        {{-- header --}}
        @include('layouts.partials.header')

        {{-- content --}}
        <div class="page-wrapper">
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>

        {{-- footer --}}
        @include('layouts.partials.footer')
    </div>

    {{-- Jquery --}}
    <script src="{{ asset('src/libs/jquery/jquery-3.6.0.min.js') }}" data-navigate-once></script>
    {{-- Tabler --}}
    <script src="{{ asset('src/js/tabler.min.js') }}" data-navigate-once></script>
    {{-- Quill Editor --}}
    <script src="{{ asset('src/libs/quill/quill.min.js') }}" data-navigate-once></script>

    @livewireChartsScripts

    <script>
        $('[x-ref="profileLink"]').on('click', function() {
            localStorage.setItem('_x_currentTabProfile', '"tabsProfileDetail"');
        });
    </script>

    {{ $scripts }}

</body>

</html>
