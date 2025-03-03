@props(['type' => 'info', 'message', 'dismissible' => true])

@php
    $colors = [
        'success' => 'bg-green-100 dark:bg-green-800 border-green-500 text-green-700 dark:text-green-300',
        'error' => 'bg-red-100 dark:bg-red-800 border-red-500 text-red-700 dark:text-red-300',
        'warning' => 'bg-yellow-100 dark:bg-yellow-800 border-yellow-500 text-yellow-700 dark:text-yellow-300',
        'info' => 'bg-blue-100 dark:bg-blue-800 border-blue-500 text-blue-700 dark:text-blue-300',
    ];
    
    $colorClasses = $colors[$type] ?? $colors['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition.duration.300ms {{ $attributes->merge(['class' => "$colorClasses border-l-4 p-4 my-4 relative"]) }} role="alert">
    <div class="flex justify-between items-center">
        <p class="font-bold">{{ $message }}</p>
        @if($dismissible)
            <button @click="show = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <span class="sr-only">Cerrar</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="mt-2">{{ $slot }}</div>
    @endif
</div>