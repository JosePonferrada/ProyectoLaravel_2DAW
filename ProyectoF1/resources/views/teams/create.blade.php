<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Nuevo Equipo') }}
            </h2>
            <a href="{{ route('teams.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Volver') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Formulario para crear equipo -->
                    <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Nombre del equipo -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- País del equipo -->
                        <div>
                            <x-input-label for="country" :value="__('País')" />
                            <select id="country" name="country" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">{{ __('Seleccionar país') }}</option>
                                <!-- Lista de países con nombres completos -->
                                @php
                                    $countries = [
                                        'Spanish' => 'España',
                                        'British' => 'Reino Unido',
                                        'Dutch' => 'Países Bajos',
                                        'German' => 'Alemania',
                                        'French' => 'Francia',
                                        'Italian' => 'Italia',
                                        'Mexican' => 'México',
                                        'Australian' => 'Australia',
                                        'Finnish' => 'Finlandia',
                                        'Canadian' => 'Canadá',
                                        'Monegasque' => 'Mónaco',
                                        'Danish' => 'Dinamarca',
                                        'Japanese' => 'Japón',
                                        'Thailand' => 'Tailandia',
                                        'Chinese' => 'China',
                                        'Austria' => 'Austria',
                                        'America' => 'Estados Unidos',
                                    ];
                                    asort($countries); // Ordenar alfabéticamente por valor (nombres en español)
                                @endphp

                                @foreach($countries as $iso => $name)
                                    <option value="{{ $iso }}" {{ old('country') == $iso ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Se guardará el nombre del país en inglés (por ejemplo: "Spanish" para España)') }}
                            </p>
                        </div>

                        <!-- Año de fundación -->
                        <div>
                            <x-input-label for="year_founded" :value="__('Año de fundación')" />
                            <x-text-input id="year_founded" name="year_founded" type="number" class="mt-1 block w-full" 
                                :value="old('year_founded')" min="1900" max="{{ date('Y') }}" />
                            <x-input-error :messages="$errors->get('year_founded')" class="mt-2" />
                        </div>

                        <!-- Campeonatos ganados -->
                        <div>
                            <x-input-label for="championships" :value="__('Campeonatos ganados')" />
                            <x-text-input id="championships" name="championships" type="number" class="mt-1 block w-full" 
                                :value="old('championships', 0)" min="0" />
                            <x-input-error :messages="$errors->get('championships')" class="mt-2" />
                        </div>

                        <!-- Logo del equipo -->
                        <div>
                            <x-input-label for="logo" :value="__('Logo')" />
                            <input type="file" id="logo" name="logo" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                dark:file:bg-indigo-900 dark:file:text-indigo-300
                                hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800
                            " accept="image/*" />
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('PNG, JPG o SVG. Máximo 2MB.') }}
                            </p>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('teams.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Crear Equipo') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>