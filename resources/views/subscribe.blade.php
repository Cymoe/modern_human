<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Subscribe to Premium Content</h3>
                    <p class="mb-4">Get access to all our premium content by subscribing now!</p>
                    <a href="{{ $checkoutUrl }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Subscribe Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
