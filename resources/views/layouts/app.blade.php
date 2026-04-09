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
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        {{-- Mobile sidebar backdrop --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
            x-cloak
        ></div>

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Main content --}}
        <div class="flex-1 flex flex-col lg:pl-64">
            @include('layouts.partials.topbar')

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    {{-- Global components --}}
    <livewire:components.flash-toast />
    <livewire:components.confirm-modal />

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>
</html>
