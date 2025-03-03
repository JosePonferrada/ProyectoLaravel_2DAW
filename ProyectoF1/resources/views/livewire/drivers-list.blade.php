<div>
    <!-- Search -->
    <div class="mb-6">
        <div class="flex gap-2">
            <x-text-input wire:model.live="search" class="block w-full" type="text"
                placeholder="Buscar por nombre, número o equipo..." />
            @if ($search)
                <button wire:click="$set('search', '')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Limpiar') }}
                </button>
            @endif
        </div>
    </div>

    <!-- Driver grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($drivers as $driver)
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all hover:shadow-md">
                <div class="relative">
                    @php
                        // Verificar primero si hay una imagen subida en storage
                        $hasStorageImage = $driver->photo && Storage::disk('public')->exists($driver->photo);

                        // Si no, intentar buscar en public/images/drivers
                        if (!$hasStorageImage) {
                            // Convertir el nombre del piloto a un formato de archivo (sin espacios, minúsculas)
                            $driverImageFile = strtolower(str_replace(' ', '_', $driver->name)) . '.jpg';
                            // También probar con extensión png si no existe jpg
                            $driverImageFilePng = strtolower(str_replace(' ', '_', $driver->name)) . '.png';

                            // Ruta a la imagen
                            $driverImagePath = 'images/drivers/' . $driverImageFile;
                            $driverImagePathPng = 'images/drivers/' . $driverImageFilePng;
                        }
                    @endphp

                    @if ($hasStorageImage)
                        <!-- Imagen subida por el usuario (desde storage) -->
                        <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}"
                            class="w-full h-48 object-contain">
                    @elseif(file_exists(public_path($driverImagePath)))
                        <!-- Imagen predefinida en public/images/drivers con extensión jpg -->
                        <img src="{{ asset($driverImagePath) }}" alt="{{ $driver->name }}"
                            class="w-full h-48 object-contain">
                    @elseif(file_exists(public_path($driverImagePathPng)))
                        <!-- Imagen predefinida en public/images/drivers con extensión png -->
                        <img src="{{ asset($driverImagePathPng) }}" alt="{{ $driver->name }}"
                            class="w-full h-48 object-contain">
                    @else
                        <!-- Imagen por defecto si no existe ninguna -->
                        <div class="w-full h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif

                    <div
                        class="absolute top-2 right-2 bg-red-600 text-white text-lg font-bold w-10 h-10 rounded-full flex items-center justify-center">
                        {{ $driver->number }}
                    </div>
                    @if ($driver->team)
                        <div
                            class="absolute bottom-0 left-0 right-0 h-6 bg-gradient-to-r from-{{ $driver->team->color ?? 'gray' }}-600 to-{{ $driver->team->color ?? 'gray' }}-800">
                        </div>
                    @endif
                </div>
                <div class="p-6 flex flex-col h-48">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $driver->name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <span class="inline-flex items-center gap-1">
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
                                    $isoCode = $countryIsoMap[$driver->nationality] ?? strtolower($driver->nationality);
                                @endphp
                                <img src="{{ asset('images/flags/' . $isoCode . '.svg') }}"
                                    alt="{{ $driver->nationality }}" class="h-4 w-auto">
                                {{ $driver->nationality }}
                            </span>
                        </p>
                    </div>
                    <div class="flex items-center mt-2">
                        @if ($driver->team)
                            <div class="flex items-center">
                                @php
                                    // Convertir el nombre del equipo a un formato de archivo (sin espacios, minúsculas)
                                    $teamLogoFile = strtolower(str_replace(' ', '_', $driver->team->name)) . '.svg';
                                    // Ruta a la imagen del logo
                                    $teamLogoPath = 'images/teams/' . $teamLogoFile;
                                @endphp

                                @if (file_exists(public_path($teamLogoPath)))
                                    <img src="{{ asset($teamLogoPath) }}" alt="{{ $driver->team->name }}"
                                        class="h-6 w-auto mr-2">
                                @else
                                    <!-- Logo por defecto si no existe el archivo -->
                                    <div
                                        class="w-6 h-6 mr-2 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $driver->team->name }}</span>
                            </div>
                        @else
                            <span class="text-sm text-gray-500 dark:text-gray-400">Sin equipo</span>
                        @endif
                    </div>
                    <div class="mt-auto pt-4">
                        <a href="{{ route('drivers.show', $driver) }}"
                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                            {{ __('Ver detalles') }} →
                        </a>
                    </div>
                </div>
                @if (auth()->user()->role === 'admin')
                    <div
                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
                        <a href="{{ route('admin.drivers.edit', $driver) }}"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{ __('Editar') }}
                        </a>
                        <button wire:click="confirmDriverDeletion({{ $driver->id }})"
                            class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            {{ __('Eliminar') }}
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">{{ __('No se encontraron pilotos.') }}</p>
                @if ($search)
                    <p class="mt-2">
                        <button wire:click="$set('search', '')"
                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            {{ __('Mostrar todos los pilotos') }}
                        </button>
                    </p>
                @endif
            </div>
        @endforelse
        <!-- Modal de confirmación de eliminación -->
        @if ($confirmingDriverDeletion)
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity flex items-center justify-center z-50">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Eliminar Piloto') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('¿Estás seguro de que quieres eliminar este piloto? Esta acción no se puede deshacer.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteDriver" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('Eliminar') }}
                        </button>
                        <button wire:click="cancelDriverDeletion" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            {{ __('Cancelar') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $drivers->links() }}
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('deleteDriver', driverId => {
                    if (confirm('¿Estás seguro de que quieres eliminar este piloto?')) {
                        Livewire.emit('deleteConfirmed', driverId);
                    }
                });
            });
        </script>
    @endpush
</div>
