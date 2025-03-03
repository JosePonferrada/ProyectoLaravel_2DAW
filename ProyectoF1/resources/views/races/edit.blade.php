<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Carrera') }}: {{ $race->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600 dark:text-red-400">
                                {{ __('¡Ups! Algo salió mal.') }}
                            </div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.races.update', $race) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre de la carrera -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $race->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Circuito -->
                            <div>
                                <x-input-label for="circuit_id" :value="__('Circuito')" />
                                <select id="circuit_id" name="circuit_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach ($circuits as $circuit)
                                        <option value="{{ $circuit->id }}" {{ $race->circuit_id == $circuit->id ? 'selected' : '' }}>
                                            {{ $circuit->name }} ({{ $circuit->location }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('circuit_id')" />
                            </div>

                            <!-- Fecha -->
                            <div>
                                <x-input-label for="date" :value="__('Fecha')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', \Carbon\Carbon::parse($race->date)->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>

                            <!-- Temporada -->
                            <div>
                                <x-input-label for="season" :value="__('Temporada')" />
                                <x-text-input id="season" name="season" type="number" class="mt-1 block w-full" :value="old('season', $race->season)" required min="1950" max="{{ date('Y') + 1 }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('season')" />
                            </div>

                            <!-- Vueltas -->
                            <div>
                                <x-input-label for="laps" :value="__('Vueltas')" />
                                <x-text-input id="laps" name="laps" type="number" class="mt-1 block w-full" :value="old('laps', $race->laps)" required min="1" />
                                <x-input-error class="mt-2" :messages="$errors->get('laps')" />
                            </div>

                            <!-- Clima -->
                            <div class="md:col-span-2">
                                <x-input-label for="weather" :value="__('Clima')" />
                                <x-text-input id="weather" name="weather" type="text" class="mt-1 block w-full" :value="old('weather', $race->weather)" />
                                <x-input-error class="mt-2" :messages="$errors->get('weather')" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Opcional. Describe las condiciones climáticas durante la carrera.') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('races.show', $race) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-3">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>