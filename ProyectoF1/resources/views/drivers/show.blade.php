<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalles del Piloto') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('drivers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Volver') }}
                </a>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.drivers.edit', $driver) }}"
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
                    <!-- Banner con el número y color del equipo -->
                    <div
                        class="h-20 bg-gradient-to-r from-{{ $driver->team->color ?? 'gray' }}-600 to-{{ $driver->team->color ?? 'gray' }}-800 flex items-center px-6">
                        <span
                            class="text-5xl font-bold text-white opacity-20 absolute right-6">#{{ $driver->number }}</span>
                    </div>

                    <!-- Alerta de éxito al actualizar -->
                    @if (session('status'))
                        <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mt-4"
                            role="alert">
                            <p class="font-bold">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Contenido principal -->
                    <div class="flex flex-col md:flex-row">
                        <!-- Columna izquierda: Foto y datos básicos -->
                        <div class="md:w-1/3 p-6">
                            <div class="flex flex-col items-center">
                                <div class="relative mb-6">
                                    @php
                                        // Verificar primero si hay una imagen subida en storage
                                        $hasStorageImage =
                                            $driver->photo && Storage::disk('public')->exists($driver->photo);

                                        // Si no, intentar buscar en public/images/drivers
                                        if (!$hasStorageImage) {
                                            // Convertir el nombre del piloto a un formato de archivo (sin espacios, minúsculas)
                                            $driverImageFile =
                                                strtolower(str_replace(' ', '_', $driver->name)) . '.jpg';
                                            $driverImageFilePng =
                                                strtolower(str_replace(' ', '_', $driver->name)) . '.png';

                                            // Ruta a la imagen
                                            $driverImagePath = 'images/drivers/' . $driverImageFile;
                                            $driverImagePathPng = 'images/drivers/' . $driverImageFilePng;
                                        }
                                    @endphp

                                    @if ($hasStorageImage)
                                        <!-- Imagen subida por el usuario (desde storage) -->
                                        <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}"
                                            class="w-48 h-48 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                    @elseif(file_exists(public_path($driverImagePath)))
                                        <!-- Imagen predefinida en public/images/drivers con extensión jpg -->
                                        <img src="{{ asset($driverImagePath) }}" alt="{{ $driver->photo }}"
                                            class="w-48 h-48 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                    @elseif(file_exists(public_path($driverImagePathPng)))
                                        <!-- Imagen predefinida en public/images/drivers con extensión png -->
                                        <img src="{{ asset($driverImagePathPng) }}" alt="{{ $driver->photo }}"
                                            class="w-48 h-48 object-cover rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600">
                                    @else
                                        <!-- Imagen por defecto si no existe ninguna -->
                                        <div
                                            class="w-48 h-48 bg-gray-300 dark:bg-gray-700 rounded-full border-4 border-{{ $driver->team->color ?? 'gray' }}-600 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute bottom-0 right-0 bg-red-600 text-white text-xl font-bold w-12 h-12 rounded-full flex items-center justify-center border-4 border-white dark:border-gray-800">
                                        {{ $driver->number }}
                                    </div>
                                </div>

                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
                                    {{ $driver->name }}</h1>

                                <div class="flex items-center mt-2 mb-4">
                                    @php
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
                                        ];
                                        $isoCode =
                                            $countryIsoMap[$driver->nationality] ?? strtolower($driver->nationality);
                                    @endphp
                                    <img src="{{ asset('images/flags/' . $isoCode . '.svg') }}"
                                        alt="{{ $driver->nationality }}" class="h-5 w-auto mr-2">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $driver->nationality }}</span>
                                </div>

                                <!-- Información del equipo -->
                                @if ($driver->team)
                                    <div class="mt-4 bg-gray-100 dark:bg-gray-700 rounded-lg p-4 w-full max-w-xs">
                                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('Equipo actual') }}</h3>
                                        <div class="flex items-center">
                                            @php
                                                // Convertir el nombre del equipo a un formato de archivo
                                                $teamLogoFile =
                                                    strtolower(str_replace(' ', '_', $driver->team->name)) . '.svg';
                                                // Ruta a la imagen del logo
                                                $teamLogoPath = 'images/teams/' . $teamLogoFile;
                                            @endphp

                                            @if (file_exists(public_path($teamLogoPath)))
                                                <img src="{{ asset($teamLogoPath) }}" alt="{{ $driver->team->name }}"
                                                    class="h-8 w-auto mr-3">
                                            @else
                                                <div
                                                    class="w-8 h-8 mr-3 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800 dark:text-white">
                                                    {{ $driver->team->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    @if ($driver->team->nationality)
                                                        @php
                                                            $teamIsoCode =
                                                                $countryIsoMap[$driver->team->nationality] ??
                                                                strtolower($driver->team->nationality);
                                                        @endphp
                                                        <span class="inline-flex items-center">
                                                            <img src="{{ asset('images/flags/' . $teamIsoCode . '.svg') }}"
                                                                alt="{{ $driver->team->nationality }}"
                                                                class="h-3 w-auto mr-1">
                                                            {{ $driver->team->nationality }}
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('teams.show', $driver->team) }}"
                                            class="mt-2 text-sm text-{{ $driver->team->color ?? 'blue' }}-600 hover:text-{{ $driver->team->color ?? 'blue' }}-800 dark:text-{{ $driver->team->color ?? 'blue' }}-400 dark:hover:text-{{ $driver->team->color ?? 'blue' }}-300 block">
                                            {{ __('Ver detalles del equipo') }} →
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Estadísticas clave -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                                    {{ __('Estadísticas') }}</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Podios') }}</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                            {{ $driver->podiums ?? 0 }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Victorias') }}</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                            {{ $driver->victories ?? 0 }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Poles') }}</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                            {{ $driver->poles ?? 0 }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Campeonatos') }}</p>
                                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                            {{ $driver->championships ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha: Detalles, biografía, etc. -->
                        <div
                            class="md:w-2/3 p-6 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700">
                            <!-- Detalles personales -->
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                                    {{ __('Información') }}</h2>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Fecha de nacimiento') }}</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $driver->date_of_birth ? \Carbon\Carbon::parse($driver->date_of_birth)->format('d/m/Y') : __('No disponible') }}
                                            @if ($driver->date_of_birth)
                                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">
                                                    ({{ \Carbon\Carbon::parse($driver->date_of_birth)->age }}
                                                    {{ __('años') }})
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Lugar de nacimiento') }}</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $driver->birthplace ?? __('No disponible') }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Debut en F1') }}
                                        </p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $driver->debut_year ?? __('No disponible') }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Carreras disputadas') }}</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $driver->races_count ?? __('No disponible') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Biografía -->
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">
                                    {{ __('Biografía') }}</h2>
                                <div class="prose dark:prose-invert max-w-none">
                                    @if ($driver->biography)
                                        <p class="text-gray-700 dark:text-gray-300">{{ $driver->biography }}</p>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 italic">
                                            {{ __('No hay información biográfica disponible para este piloto.') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Carreras recientes o destacadas -->
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">
                                    {{ __('Carreras recientes') }}</h2>
                                @if ($driver->races && $driver->races->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        {{ __('Fecha') }}</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        {{ __('Gran Premio') }}</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        {{ __('Posición') }}</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        {{ __('Puntos') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach ($driver->races->take(5) as $race)
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            {{ \Carbon\Carbon::parse($race->date)->format('d/m/Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <a href="{{ route('races.show', $race) }}"
                                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                                {{ $race->name }}
                                                            </a>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            @if ($race->pivot && isset($race->pivot->position))
                                                                @if ($race->pivot->position == 1)
                                                                    <span class="text-yellow-500 font-bold">1º</span>
                                                                @elseif($race->pivot->position == 2)
                                                                    <span class="text-gray-400 font-semibold">2º</span>
                                                                @elseif($race->pivot->position == 3)
                                                                    <span
                                                                        class="text-amber-700 font-semibold">3º</span>
                                                                @else
                                                                    {{ $race->pivot->position }}º
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $race->pivot->points ?? '0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($driver->races->count() > 5)
                                        <div class="mt-3 text-right">
                                            <a href="#"
                                                class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ __('Ver todas las carreras') }} →
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 italic">
                                        {{ __('No hay información sobre carreras para este piloto.') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
