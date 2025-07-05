<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Finished Goods Inventory</h1>
                        <h4 class="text-zinc-700">PCSI Warehouse</h4>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="onExport()"
                            class="px-4 py-2 flex items-center gap-3 rounded-md text-zinc-900 text-sm border border-zinc-300 hover:border-zinc-400 transition duration-200 ease-in-out"><x-lucide-download
                                class="h-4 w-4" />Export</button>
                        <button onclick="my_modal_5.showModal()"
                            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                            <x-lucide-plus class="h-4 w-4" />
                            Add Item</button>

                    </div>



                </div>
                {{-- @if (session('success'))
                    <div id="alert" role="alert" class="alert alert-success mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div id="alert" role="alert" class="alert alert-error mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @elseif ($errors->any())
                    <div id="alert" role="alert" class="alert alert-error mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <ul class="list-disc pl-5 text-white text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}



                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">

                  


                

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


