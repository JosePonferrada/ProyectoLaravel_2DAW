    <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $race->name }}
            </h2>
            <span class="px-3 py-1 text-xs rounded-full
                {{ $race->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                {{ $race->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                {{ $race->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                {{ $race->status === 'completed' ? 'Completada' : '' }}
                {{ $race->status === 'scheduled' ? 'Programada' : '' }}
                {{ $race->status === 'cancelled' ? 'Cancelada' : '' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            

            <!-- Detalles de la carrera -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Detalles de la carrera
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna izquierda: Información básica -->
                        <div>
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre:</span>
                                <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->name }}</span>
                            </div>

                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha:</span>
                                <span class="block mt-1 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($race->date)->format('d/m/Y') }}</span>
                            </div>

                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temporada:</span>
                                <span class="block mt-1 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($race->date)->format('Y') }}</span>
                            </div>

                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vueltas:</span>
                                <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->laps }}</span>
                            </div>

                            <div>
                                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Clima:</span>
                                <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->weather ?? 'No especificado' }}</span>
                            </div>
                        </div>

                        <!-- Columna derecha: Información del circuito -->
                        <div>
                            @if($race->circuit)
                                <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-3">Circuito</h4>
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->name }}</span>
                                </div>

                                @if($race->circuit->location)
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">País:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->location }}</span>
                                </div>
                                @endif

                                @if($race->circuit->length)
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitud:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->length }} km</span>
                                </div>
                                @endif

                                @if($race->circuit->lap_record)
                                <div>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Récord del circuito:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->lap_record }}</span>
                                </div>
                                @endif

                                @if($race->circuit->capacity)
                                <div class="mt-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Aforo:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->capacity }} espectadores</span>
                                </div>
                                @endif

                                @if($race->circuit->first_grand_prix)
                                <div class="mt-4">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Gran Premio:</span>
                                    <span class="block mt-1 text-gray-900 dark:text-white">{{ $race->circuit->first_grand_prix }}</span>
                                </div>
                                @endif
                            @else
                                <div class="p-4 bg-yellow-50 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded-md">
                                    No hay información del circuito disponible.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resultados de la carrera -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Clasificación de pilotos
                    </h3>

                    @if($race->drivers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Posición
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Piloto
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Equipo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Puntos
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($race->drivers as $driver)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                                {{ $driver->pivot->position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($driver->photo)
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}">
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $driver->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $driver->nationality }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $driver->team->name ?? 'Sin equipo' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $driver->pivot->points }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay resultados</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Aún no hay resultados disponibles para esta carrera.
                            </p>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="mt-6">
                                    <a href="{{ route('admin.races.create', $race) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Añadir resultados
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('races.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Volver
                </a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.races.edit', $race) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Editar
                        </a>

                        @if($race->drivers->isEmpty())
                            <form method="POST" action="{{ route('admin.races.destroy', $race) }}" class="inline"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta carrera?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>