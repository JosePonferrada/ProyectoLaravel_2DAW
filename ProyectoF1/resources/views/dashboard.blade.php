<!-- filepath: /c:/Users/Usuario/git/ProyectoLaravel_2DAW/ProyectoF1/resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Banner de bienvenida -->
            <div class="bg-gradient-to-r from-red-600 to-red-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-white mb-4">¡Bienvenido a F1 Stats, {{ Auth::user()->name }}!</h2>
                    <p class="text-white text-lg">Tu portal para seguir toda la emoción de la Fórmula 1.</p>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-500 bg-opacity-75 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilotos</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Explora los perfiles de todos los pilotos</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('drivers.index') }}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Ver pilotos →</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-75 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Equipos</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Conoce los equipos de la temporada</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('teams.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Ver equipos →</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-75 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Carreras</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Calendario de carreras y resultados</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('races.index') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium">Ver carreras →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Próxima carrera -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Próxima carrera</h3>
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="w-full md:w-1/3 mb-4 md:mb-0">
                            <img src="{{ asset('https://cdn3.iconfinder.com/data/icons/race-tracks/100/Race_tracks-Icons-65-512.png') }}" alt="Circuito" class="rounded-lg w-full h-48 object-cover">
                        </div>
                        <div class="md:ml-6 w-full md:w-2/3">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Gran Premio de Barcelona</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Circuit de Barcelona-Catalunya</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>12 - 14 Mayo, 2023</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Ver detalles
                                </a>
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Calendario completo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de usuario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tu perfil</h3>
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="w-full md:w-1/4 flex justify-center mb-4 md:mb-0">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="rounded-full w-32 h-32 object-cover border-4 border-gray-200 dark:border-gray-700">
                            @else
                                <div class="rounded-full w-32 h-32 flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-4xl font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="md:ml-6 w-full md:w-3/4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Auth::user()->email }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                                Miembro desde {{ Auth::user()->created_at->format('d M, Y') }}
                            </p>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Editar perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>