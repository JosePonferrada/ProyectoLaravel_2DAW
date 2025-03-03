<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex space-x-2">
                <a href="{{ route('teams.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Volver') }}
                </a>
                @if (auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.teams.edit', $team) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('Editar') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative">
                    <!-- Banner con el color del equipo -->
                    <div
                        class="h-32 bg-gradient-to-r from-{{ $team->color ?? 'gray' }}-600 to-{{ $team->color ?? 'gray' }}-800 flex items-center justify-center">
                        <h1 class="text-4xl font-bold text-white">{{ $team->name }}</h1>
                    </div>

                    <!-- Alerta de éxito al actualizar -->
                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mt-4"
                            role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Contenido principal -->
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <!-- Columna izquierda: información del equipo -->
                            <div class="md:w-1/3 flex flex-col items-center mb-6 md:mb-0">
                                <div
                                    class="w-48 h-48 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-6">
                                    @if ($team->logo)
                                        <img src="{{ asset('images/teams/' . $team->logo) }}" alt="{{ $team->name }}"
                                            class="w-full h-full object-contain">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <div class="flex items-center justify-center space-x-2 mb-4">

                                        @php

                                            $countryField = $team->country ?? '';

                                            $countryIsoMap = [
                                                'Spanish' => 'es',
                                                'British' => 'gb',
                                                'Dutch' => 'nl',
                                                'German' => 'de',
                                                'French' => 'fr',
                                                'Italian' => 'it',
                                                'Mexican' => 'mx',
                                                'Australian' => 'au',
                                                'Finnish' => 'fi',
                                                'Canadian' => 'ca',
                                                'Monegasque' => 'mc',
                                                'Danish' => 'dk',
                                                'Japanese' => 'jp',
                                                'Thai' => 'th',
                                                'Chinese' => 'cn',
                                                'Austria' => 'at',
                                            ];
                                            // Determinar el código ISO
                                            $isoCode = strtolower($countryIsoMap[$countryField] ?? $countryField);

                                            // Comprobar varios formatos de archivo
                                            $flagExtensions = ['.svg', '.png', '.jpg'];
                                            $flagFound = false;
                                            $flagPath = '';

                                            foreach ($flagExtensions as $ext) {
                                                $testPath = 'images/flags/' . $isoCode . $ext;
                                                if (file_exists(public_path($testPath))) {
                                                    $flagFound = true;
                                                    $flagPath = $testPath;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if ($flagFound)
                                            <img src="{{ asset($flagPath) }}" alt="{{ $countryField }}"
                                                class="h-6 w-auto">
                                        @else
                                            <!-- Mostrar un indicador de que no se encontró la bandera -->
                                            <div
                                                class="h-6 w-9 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $isoCode }}</span>
                                            </div>
                                        @endif
                                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $team->country }}</h3>
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400">
                                        <p class="mb-1"><span
                                                class="font-medium">{{ __('Año de fundación') }}:</span>
                                            {{ $team->year_founded ?? 'N/A' }}</p>
                                        <p><span class="font-medium">{{ __('Color') }}:</span> <span
                                                class="inline-block w-4 h-4 bg-{{ $team->color ?? 'gray' }}-600 rounded-full mr-1 align-middle"></span>
                                            {{ ucfirst($team->color ?? 'N/A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna derecha: pilotos y estadísticas -->
                            <div class="md:w-2/3 md:pl-8 md:border-l md:border-gray-200 dark:md:border-gray-700">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">{{ __('Pilotos') }}
                                </h2>

                                @if ($team->drivers->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        @foreach ($team->drivers as $driver)
                                            <a href="{{ route('drivers.show', $driver) }}"
                                                class="block bg-gray-50 dark:bg-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 mr-3">
                                                        @php
                                                            // Verificar primero si hay una imagen subida en storage
                                                            $hasStorageImage =
                                                                $driver->photo &&
                                                                Storage::disk('public')->exists($driver->photo);

                                                            // Si no, intentar buscar en public/images/drivers
                                                            if (!$hasStorageImage) {
                                                                // Convertir el nombre del piloto a un formato de archivo (sin espacios, minúsculas)
                                                                $driverImageFile =
                                                                    strtolower(str_replace(' ', '_', $driver->name)) .
                                                                    '.jpg';
                                                                $driverImageFilePng =
                                                                    strtolower(str_replace(' ', '_', $driver->name)) .
                                                                    '.png';

                                                                // Ruta a la imagen
                                                                $driverImagePath = 'images/drivers/' . $driverImageFile;
                                                                $driverImagePathPng =
                                                                    'images/drivers/' . $driverImageFilePng;
                                                            }
                                                        @endphp

                                                        @if ($hasStorageImage)
                                                            <!-- Imagen subida por el usuario (desde storage) -->
                                                            <img src="{{ asset('storage/' . $driver->photo) }}"
                                                                alt="{{ $driver->name }}"
                                                                class="w-12 h-12 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                                        @elseif(file_exists(public_path($driverImagePath)))
                                                            <!-- Imagen predefinida en public/images/drivers con extensión jpg -->
                                                            <img src="{{ asset($driverImagePath) }}"
                                                                alt="{{ $driver->photo }}"
                                                                class="w-12 h-12 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                                        @elseif(file_exists(public_path($driverImagePathPng)))
                                                            <!-- Imagen predefinida en public/images/drivers con extensión png -->
                                                            <img src="{{ asset($driverImagePathPng) }}"
                                                                alt="{{ $driver->photo }}"
                                                                class="w-12 h-12 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                                        @else
                                                            <div
                                                                class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                <span
                                                                    class="text-lg font-bold text-gray-600 dark:text-gray-300">{{ substr($driver->name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-800 dark:text-white">
                                                            {{ $driver->name }}</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            <span class="font-bold">{{ __('Número') }}:</span>
                                                            #{{ $driver->number }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                                        {{ __('Este equipo no tiene pilotos asignados.') }}</p>
                                @endif

                                <!-- Estadísticas del equipo -->
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                                    {{ __('Estadísticas') }}</h2>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-{{ $team->color ?? 'gray' }}-600">
                                                {{ $team->wins ?? '0' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Victorias') }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-{{ $team->color ?? 'gray' }}-600">
                                                {{ $team->podiums ?? '0' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Podios') }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-{{ $team->color ?? 'gray' }}-600">
                                                {{ $team->championships ?? '0' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('Campeonatos') }}</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-{{ $team->color ?? 'gray' }}-600">
                                                {{ $team->points ?? '0' }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Puntos') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 italic text-center">
                                        {{ __('Nota: Las estadísticas son ilustrativas y pueden no reflejar datos reales.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Botones de acción para administradores -->
            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="mt-6 flex justify-end space-x-3">
                    <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            onclick="return confirm('¿Estás seguro? Esta acción eliminará el equipo y no se puede deshacer.')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            {{ __('Eliminar equipo') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
