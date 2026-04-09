<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Starter') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <div class="mb-8 text-center">
            <a href="/" class="inline-flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-600 text-white font-bold text-lg">
                    S
                </div>
                <span class="text-xl font-bold text-slate-900">{{ config('app.name', 'Starter') }}</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-8">
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
