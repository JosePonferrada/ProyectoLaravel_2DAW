<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Piloto') }}
            </h2>
            <a href="{{ route('drivers.show', $driver) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.drivers.update', $driver) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Columna izquierda -->
                            <div>
                                <!-- Nombre -->
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Nombre')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $driver->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <!-- Número -->
                                <div class="mb-4">
                                    <x-input-label for="number" :value="__('Número')" />
                                    <x-text-input id="number" class="block mt-1 w-full" type="number" name="number" :value="old('number', $driver->number)" min="0" max="99" required />
                                    <x-input-error :messages="$errors->get('number')" class="mt-2" />
                                </div>
                                
                                <!-- Nacionalidad -->
                                <div class="mb-4">
                                    <x-input-label for="nationality" :value="__('Nacionalidad')" />
                                    <x-text-input id="nationality" class="block mt-1 w-full" type="text" name="nationality" :value="old('nationality', $driver->nationality)" required />
                                    <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                                </div>
                                
                            </div>
                            
                            <!-- Columna derecha -->
                            <div>
                                
                                <!-- Equipo -->
                                <div class="mb-4">
                                    <x-input-label for="team_id" :value="__('Equipo')" />
                                    <select id="team_id" name="team_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">{{ __('Seleccionar equipo...') }}</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" {{ old('team_id', $driver->team_id) == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
                                </div>
                                
                                <!-- Fecha de nacimiento -->
                                <div class="mb-4">
                                    <x-input-label for="date_of_birth" :value="__('Fecha de nacimiento')" />
                                    <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth', is_string($driver->date_of_birth) ? $driver->date_of_birth : ($driver->date_of_birth ? $driver->date_of_birth->format('Y-m-d') : ''))" />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>
                                
                                <!-- Imagen -->
                                <div class="mb-4">
                                    <x-input-label for="photo" :value="__('Imagen')" />
                                    <input type="file" id="photo" name="photo" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                    
                                    @if($driver->photo)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Imagen actual:') }}</p>
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" class="h-32 w-auto object-cover rounded-md">
                                            </div>
                                            
                                            <div class="mt-2">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="delete_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                                    <span class="ml-2 text-sm text-red-500">{{ __('Eliminar imagen actual') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <x-secondary-button type="button" onclick="window.location='{{ route('drivers.show', $driver) }}'" class="mr-3">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Guardar cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>