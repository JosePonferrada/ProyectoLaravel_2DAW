<!-- filepath: /c:/Users/Usuario/git/ProyectoLaravel_2DAW/ProyectoF1/resources/views/livewire/teams-list.blade.php -->
<div>
    <!-- Search -->
    <div class="mb-6">
        <div class="flex gap-2">
            <input wire:model.live="search" type="text"
                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Buscar por nombre o país...">

            @if (!empty($search))
                <button wire:click="resetFilters"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Limpiar') }}
                </button>
            @endif
        </div>
    </div>

    <!-- Teams grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($teams as $team)
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all hover:shadow-md border-t-4 border-{{ $team->color ?? 'gray' }}-600">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0 mr-4">
                        @if ($team->logo)
                            @if (Str::startsWith($team->logo, ['http://', 'https://', '/']))
                                <img src="{{ $team->logo }}" alt="{{ $team->name }}"
                                    class="w-24 h-24 object-contain">
                            @elseif(Str::startsWith($team->logo, 'images/'))
                                <img src="{{ asset($team->logo) }}" alt="{{ $team->name }}"
                                    class="w-24 h-24 object-contain">
                            @else
                                <img src="{{ asset('images/teams/' . $team->logo) }}" alt="{{ $team->name }}"
                                    class="w-24 h-24 object-contain">
                            @endif
                        @else
                            <div
                                class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $team->name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <span class="inline-flex items-center gap-1">
                                @php
                                    $flagPath = 'images/flags/' . strtolower($team->nationality) . '.png';
                                @endphp

                                @if (file_exists(public_path($flagPath)))
                                    <img src="{{ asset($flagPath) }}" alt="{{ $team->nationality }}"
                                        class="h-4 w-auto">
                                @endif
                                {{ $team->nationality }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Fundado en') }}: {{ $team->year_founded }}
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <div class="mt-2 mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Pilotos') }}</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($team->drivers as $driver)
                                <a href="{{ route('drivers.show', $driver) }}"
                                    class="inline-flex items-center bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full text-xs font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <span class="mr-1 font-bold">#{{ $driver->number }}</span>
                                    {{ $driver->name }}
                                </a>
                            @empty
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Sin pilotos') }}</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('teams.show', $team) }}"
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            {{ __('Ver detalles') }} →
                        </a>
                    </div>
                </div>
                @if (auth()->check() && auth()->user()->role === 'admin')
                    <div
                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
                        <a href="{{ route('admin.teams.edit', $team) }}"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{ __('Editar') }}
                        </a>
                        <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">
                                {{ __('Eliminar') }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">{{ __('No se encontraron equipos.') }}</p>
                @if (!empty($search))
                    <p class="mt-2">
                        <button wire:click="resetFilters"
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ __('Mostrar todos los equipos') }}
                        </button>
                    </p>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $teams->links() }}
    </div>
</div>
