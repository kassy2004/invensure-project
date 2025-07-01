<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between w-1/2 mx-auto">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">My Orders</h1>
                        <p class="text-sm text-zinc-500">View your order history, provide feedback, and request returns
                            within 12 hours of delivery.</p>

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
                    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                        <div class="flex justify-between">

                            <div class="flex flex-col">

                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-lg font-semibold">Order 1</span>
                                </div>
                                <span class="text-zinc-500">Ordered on 12/28/2024 • Delivered on 12/30/2024 at 2:30:00
                                    PM</span>
                            </div>

                            <div class="flex flex-col justify-end items-end">
                                <div
                                    class="flex text-xs bg-orange-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                    <x-lucide-truck class="h-3 w-3" />
                                    <span>Delivered</span>
                                </div>
                                <span class="text-lg text-orange-500 font-bold">₱ 9,500</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 mt-5">
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <hr>
                            {{-- <div class="flex gap-2 p-2 bg-zinc-100 rounded-md">
                                <x-lucide-clock-8 class="h-4 w-4 text-zinc-700" />
                                <span class="text-xs text-red-500">Return period expired - <span
                                        class="text-xs text-zinc-700">Returns must be requested within 12 hours of
                                        delivery</span></span>
                            </div> --}}
                            <div class="flex items-start">
                                <div
                                    class="text-zinc-700 cursor-pointer flex gap-2 text-sm items-center border border-zinc-300 rounded-lg py-2 px-4 w-auto">
                                    <x-lucide-message-square class="h-4 w-4" />
                                    <span>Give Feedback</span>
                                </div>
                            </div>

                        </div>



                    </div>

                    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                        <div class="flex justify-between">

                            <div class="flex flex-col">

                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-lg font-semibold">Order 1</span>
                                </div>
                                <span class="text-zinc-500">Ordered on 12/28/2024 • Delivered on 12/30/2024 at 2:30:00
                                    PM</span>
                            </div>

                            <div class="flex flex-col justify-end items-end">
                                <div
                                    class="flex text-xs bg-orange-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                    <x-lucide-truck class="h-3 w-3" />
                                    <span>Delivered</span>
                                </div>
                                <span class="text-lg text-orange-500 font-bold">₱ 9,500</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 mt-5">
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                {{-- <div class="text-zinc-500 text-sm">
                                    <span>Return</span>
                                </div> --}}

                            </div>
                            <div class="flex flex-col border rounded-lg p-3 border-zinc-300">
                                <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 0.5KG</span>
                                <span class="text-xs text-zinc-600">200 - 100.0kg</span>
                            </div>
                            <hr>
                            <div class="flex gap-2 p-2 bg-zinc-100 rounded-md">
                                <x-lucide-clock-8 class="h-4 w-4 text-zinc-700" />
                                <span class="text-xs text-red-500">Return period expired - <span
                                        class="text-xs text-zinc-700">Returns must be requested within 12 hours of
                                        delivery</span></span>
                            </div>
                            <div class="flex flex-col gap-3 rounded-lg bg-emerald-100 p-3">
                                <div class="flex gap-2 item-center">
                                    <x-lucide-circle-check-big class="h-4 w-4 text-emerald-500" />
                                    <span class="text-zinc-700 text-xs">Feedback Submitted</span>

                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">

                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />

                                    </div>
                                    <span class="text-zinc-500 text-xs">(5/5)</span>

                                </div>
                                <span class="text-zinc-700 text-xs">no comment</span>
                            </div>

                        </div>



                    </div>

                    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                        <div class="flex justify-between">

                            <div class="flex flex-col">

                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-lg font-semibold">Order 1</span>
                                </div>
                                <span class="text-zinc-500">Ordered on 12/28/2024 • Delivered on 12/30/2024 at 2:30:00
                                    PM</span>
                            </div>

                            <div class="flex flex-col justify-end items-end">
                                <div
                                    class="flex text-xs bg-orange-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                    <x-lucide-truck class="h-3 w-3" />
                                    <span>Delivered</span>
                                </div>
                                <span class="text-lg text-orange-500 font-bold">₱ 9,500</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 mt-5">
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <hr>
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-md font-semibold">Return Requests</span>
                                </div>

                                <div class="border border-zinc-300 rounded-lg p-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-semibold text-zinc-700">Return #RET-001</span>
                                        <div
                                            class="flex text-xs bg-emerald-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                            <x-lucide-circle-check-big class="h-3 w-3" />
                                            <span>Approved </span>
                                        </div>
                                    </div>
                                    <span class="text-zinc-500 text-xs">GROUND CHICKEN SKIN ON - 1KG - Requested on
                                        12/22/2024</span>

                                    <div class="mt-5">
                                        <span class="text-zinc-700 text-xs font-semibold">Reason for Return</span>
                                        <div class="bg-zinc-200 p-2 rounded-md ">
                                            <span class="text-zinc-500 text-xs">
                                                Hematoma
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="text-zinc-700 cursor-pointer flex gap-2 text-sm items-center border border-zinc-300 rounded-lg py-2 px-4 w-auto">
                                    <x-lucide-message-square class="h-4 w-4" />
                                    <span>Give Feedback</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
