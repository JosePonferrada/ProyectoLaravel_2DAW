<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>F1 Stats - Tu portal de Fórmula 1</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-f1-laravel.svg') }}">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* La hoja de estilos minificada del Tailwind */
            </style>
        @endif
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
            
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-red-600 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- Logo F1 personalizado -->
                            <x-application-logo class="h-16 w-auto" />
                        </div>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-gray-800 ring-1 ring-transparent transition hover:text-red-600 focus:outline-none focus-visible:ring-red-600 dark:text-gray-200 dark:hover:text-red-400"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-gray-800 ring-1 ring-transparent transition hover:text-red-600 focus:outline-none focus-visible:ring-red-600 dark:text-gray-200 dark:hover:text-red-400"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-gray-800 ring-1 ring-transparent transition hover:text-red-600 focus:outline-none focus-visible:ring-red-600 dark:text-gray-200 dark:hover:text-red-400"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a
                                href="{{ route('races.index') }}"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg ring-1 ring-white/[0.05] transition duration-300 hover:text-gray-700 hover:ring-red-500/20 focus:outline-none focus-visible:ring-red-600 md:row-span-2 lg:p-10 lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-gray-300 dark:hover:ring-red-400/30 dark:focus-visible:ring-red-500"
                            >
                                <div class="relative flex w-full flex-1 items-stretch">
                                    
                                    <div
                                        class="absolute -bottom-16 -left-16 h-40 w-[calc(100%_+_8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-gray-800 dark:to-gray-800"
                                    ></div>
                                </div>

                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div class="flex items-start gap-6 lg:flex-col">
                                        <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-600/10 sm:size-16">
                                            <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                            </svg>
                                        </div>

                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Carreras</h2>

                                            <p class="mt-4 text-sm/relaxed">
                                                Explora todas las carreras de la temporada actual. Consulta los circuitos, fechas, resultados y estadísticas de cada Gran Premio.
                                            </p>
                                        </div>
                                    </div>

                                    <svg class="size-6 shrink-0 stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                                </div>
                            </a>

                            <a
                                href="{{ route('drivers.index') }}"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-white/[0.05] transition duration-300 hover:text-gray-700 hover:ring-red-500/20 focus:outline-none focus-visible:ring-red-600 lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-gray-300 dark:hover:ring-red-400/30 dark:focus-visible:ring-red-500"
                            >
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-600/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pilotos</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Conoce a los pilotos que compiten en la Fórmula 1. Accede a sus perfiles, estadísticas, victorias y campeonatos ganados a lo largo de su carrera.
                                    </p>
                                </div>

                                <svg class="size-6 shrink-0 self-center stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                            </a>

                            <a
                                href="{{ route('teams.index') }}"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-white/[0.05] transition duration-300 hover:text-gray-700 hover:ring-red-500/20 focus:outline-none focus-visible:ring-red-600 lg:pb-10 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-gray-300 dark:hover:ring-red-400/30 dark:focus-visible:ring-red-500"
                            >
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-600/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.479m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Equipos</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Descubre los equipos que forman parte del campeonato de Fórmula 1. Información sobre su historia, pilotos actuales, monoplazas y rendimiento.
                                    </p>
                                </div>

                                <svg class="size-6 shrink-0 self-center stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                            </a>

                            <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-lg ring-1 ring-white/[0.05] lg:pb-10 dark:bg-gray-800 dark:ring-gray-700">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-600/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Sobre esta aplicación</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Esta aplicación ha sido desarrollada como proyecto para el curso de Desarrollo de Aplicaciones Web utilizando Laravel, Livewire y Tailwind CSS. Proporciona información actualizada sobre la Fórmula 1, incluyendo pilotos, equipos y carreras.
                                    </p>
                                    
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        Si tienes alguna pregunta o sugerencia, no dudes en contactar con el administrador.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-gray-600 dark:text-gray-400">
                        F1 Stats - Proyecto Laravel 2DAW &copy; {{ date('Y') }}
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>