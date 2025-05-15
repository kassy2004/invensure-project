<x-app-layout>
@include('layouts.sidebar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Hi! Welcome to Dashboard") }}
                    @if (auth()->check() && auth()->user()->role === 'admin')
  <h4 class="text-gray-400 mb-6">Admin Dashboard</h4>
@else
               <h4 class="text-gray-400 mb-6">Customer Dashboard</h4>
 @endif
                </div>
            </div>
        </div>
    </div>
     </div>
</x-app-layout>
