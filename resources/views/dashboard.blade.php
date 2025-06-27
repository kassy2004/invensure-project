<x-app-layout>
    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden">
                <div class="p-6 ">
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

                        <div x-data="{ tab: 'dashboardOverview' }">
                            <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                                <span @click="tab = 'dashboardOverview'"
                                    :class="tab === 'dashboardOverview' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Overview</span>
                                <span @click="tab = 'analytics'"
                                    :class="tab === 'analytics' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Analytics</span>
                                <span @click="tab = 'reports'"
                                    :class="tab === 'reports' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Reports</span>
                                <span @click="tab = 'notifications'"
                                    :class="tab === 'notifications' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Notifications</span>
                            </div>
                            <div class="flex gap-6 mb-5 mt-5 w-full">
                                <template x-if="tab === 'dashboardOverview'">
                                    @include('components.dashboard.overview')
                                </template>
                                <template x-if="tab === 'analytics'">
                                    @include('components.dashboard.analytics')
                                </template>
                                <template x-if="tab === 'reports'">
                                    @include('components.dashboard.reports')
                                </template>
                                <template x-if="tab === 'notifications'">
                                    @include('components.dashboard.notifications')
                                </template>
                            </div>
                        </div>
                    @endif















                    @if (auth()->check() && auth()->user()->role === 'customer')
                        <h1 class="text-2xl font-bold text-gray-900">Customer Dashboard</h1>
                    @endif



                    @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                        <h1 class="text-2xl font-bold text-gray-900">Inventory Manager Dashboard</h1>


                        <div class="flex gap-6 flex-wrap lg:flex-nowrap mt-5">
                            <!-- Total Equipment Card -->
                            <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                                <div class="flex items-center">

                                    <div class="flex flex-col w-full gap-3">
                                        <div class="flex justify-between items-center w-full">
                                            <div class="flex flex-col">
                                                <p class="text-gray-700 font-semibold text-sm">Total Available Stock</p>
                                            </div>
                                            <div class="dropdown dropdown-end">
                                                <div tabindex="0" role="button"
                                                    class="p-0 btn h-0 bg-transparent m-0 shadow-none border-none">
                                                    <x-lucide-eye
                                                        class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                                                </div>


                                                <ul tabindex="0"
                                                    class="dropdown-content flex flex-col px-2 border border-zinc-300 bg-gray-100 rounded-box z-10 w-98  overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap pb-2">
                                                    {{-- @foreach ($availableItem as $item)
                                               
                                                        <li
                                                            class=" text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                                            <span>No. {{ $item->id }}</span>
                                                            <span
                                                                class="truncate block max-w-[200px] text-ellipsis overflow-hidden whitespace-nowrap">{{ $item->data_entry }}</span>
                                                            <span>{{ $item->left }} days left</span>

                                                        </li>
                                                    @endforeach --}}

                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($available) ?? '24,500' }}</p> --}}
                                                {{-- <span class="text-xs text-gray-500">+20.1% from last month</span> --}}
                                                23,500
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Borrowings Card -->
                            <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                                <div class="flex items-center">

                                    <div class="flex flex-col w-full gap-3">
                                        <div class="flex justify-between items-center w-full">
                                            <div class="flex flex-col">
                                                <p class="text-gray-700 font-semibold text-sm">Total Expiring Soon</p>
                                            </div>

                                            <div class="dropdown dropdown-end">
                                                <div tabindex="0" role="button"
                                                    class="p-0 btn h-0 bg-transparent m-0 shadow-none border-none">
                                                    <x-lucide-eye
                                                        class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                                                </div>


                                                <ul tabindex="0"
                                                    class="dropdown-content flex flex-col px-2 border border-zinc-300 bg-gray-100 rounded-box z-10 w-98  overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap pb-2">
                                                    {{-- @foreach ($expiringItem as $item)
                                                        <li
                                                            class=" text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                                            <span>No. {{ $item->id }}</span>
                                                            <span
                                                                class="truncate block max-w-[200px] text-ellipsis overflow-hidden whitespace-nowrap">{{ $item->data_entry }}</span>
                                                            <span>{{ $item->left }} days left</span>

                                                        </li>
                                                    @endforeach --}}

                                                </ul>
                                            </div>

                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($expiring) ?? '24,500' }}</p> --}}
                                                23,500
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="flex justify-between w-full gap-6">
                            <div class="flex flex-col gap-6 mt-5 p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full lg:w-1/2">
                                <div>
                                    <h1 class="text-zinc-800 font-semibold">Top Moving Items</h1>
                                    <p class="text-zinc-600 text-sm">Most Frequently In & Out</p>
                                </div>
                            
                                <div class="w-full h-80">
                                    <canvas id="myChart" class="w-full h-full"></canvas>
                                </div>
                            </div>

                            <div
                                class="flex flex-col gap-6 flex-wrap lg:flex-nowrap mt-5 p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full">
                                <div>
                                    <h1 class="text-zinc-800 font-semibold">Dead Stock Report</h1>
                                    <p class="text-zinc-600 text-sm">Items with No Movement</p>
                                </div>

                                <div class=" w-11/12 mx-auto">
                                    <canvas id="deadStockChart" class="w-full"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
