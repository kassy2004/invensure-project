<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Delivery Operations</h1>
                        <h4 class="text-zinc-700">Complete logistics management from allocation to delivery</h4>
                    </div>



                </div>


                @if (session('success'))
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
                @endif


                <div class="flex gap-6 flex-wrap lg:flex-nowrap mt-5">
                    <!-- Total Equipment Card -->
                    <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                        <div class="flex items-center">

                            <div class="flex flex-col w-full gap-3">
                                <div class="flex justify-between items-center w-full">
                                    <div class="flex flex-col">
                                        <p class="text-gray-700 font-semibold text-sm">Pending Allocations</p>
                                    </div>
                                    <x-lucide-clipboard-list class="h-5 w-5 text-gray-500" />

                                </div>
                                <div>
                                    <p class="text-3xl font-bold text-gray-800">
                                        500</p>

                                </div>
                            </div>
                        </div>
                    </div>

                

                    <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                        <div class="flex items-center">

                            <div class="flex flex-col w-full gap-3">
                                <div class="flex justify-between items-center w-full">
                                    <div class="flex flex-col">
                                        <p class="text-gray-700 font-semibold text-sm">Truck in Transit</p>
                                    </div>
                                    <x-lucide-truck class="h-5 w-5 text-gray-500" />



                                </div>
                                <div>
                                    <p class="text-3xl font-bold text-gray-800">
                                        2000</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>






                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">
               


                    <div x-data="{ tab: 'allocations' }">
                        <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200 w-full gap-5">

                            <span @click="tab = 'allocations'"
                                :class="tab === 'allocations' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900 w-full text-center">Allocations</span>

                          
                            <span @click="tab = 'truck-loading'"
                                :class="tab === 'truck-loading' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900 w-full text-center">Truck Loading</span>
                            {{-- <span @click="tab = 'outgoing'" :class="tab === 'outgoing' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Outgoing </span> --}}

                        </div>
                        <div class="mt-5 w-full">
                            <div x-show="tab === 'allocations'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('logistic.delivery.allocations')
                            </div>
                           
                            <div x-show="tab === 'truck-loading'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('logistic.delivery.truck-loading')
                            </div>

                           

                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</x-app-layout>

