<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Add Warehouse</h1>
                        <h4 class="text-zinc-700">Fill out the details below to register a new warehouse location.</h4>
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



                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">
                    <div class="bg-gray-50 rounded-lg border-2 border-gray-200 w-full">

                        <div class="flex items-center gap-3  p-2 rounded-t-lg bg-gray-100">
                            <div
                                class="h-8 w-8 border border-gray-300 rounded-lg flex justify-center items-center bg-gray-50">
                                <x-lucide-warehouse class="h-4 w-4 text-gray-500" />
                            </div>

                            <div class="flex flex-col">

                                <h1 class="text-lg text-gray-800 font-medium">Warehouse Information</h1>
                                <p class="text-sm text-gray-500">Fill out the fields below to add or update
                                    warehouse
                                    details.
                                </p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-b-lg">
                            <div class="flex items-center gap-5">

                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Warehouse Name</legend>
                                    <input type="text" name="warehouse"
                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                        placeholder="Enter warehouse name" required />
                                    <p class="label text-gray-500">Suggestion: use an abbreviation (e.g., PCSI or JFPC)</p>
                                </fieldset>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Location</legend>
                                    <input type="text" name="location"
                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                        placeholder="Enter warehouse location (e.g., Main Site, Cavite, or Laguna)"
                                        required />

                                </fieldset>
                            </div>

                        </div>
                    </div>


                </div>




            </div>

        </div>
    </div>
    </div>
</x-app-layout>
