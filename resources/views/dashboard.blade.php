<x-app-layout>
    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden">
                <div class="lg:p-6 ">

                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <h1 class="text-2xl font-bold text-gray-900 mb-5">Dashboard</h1>
                        @if (session('success'))
                            <div id="alert" role="alert" class="alert alert-success mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @elseif (session('error'))
                            <div id="alert" role="alert" class="alert alert-error mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        @elseif ($errors->any())
                            <div id="alert" role="alert" class="alert alert-error mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
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

                            </div>
                            <div class="flex gap-6 mb-5 mt-5 w-full">
                                <div x-show="tab === 'dashboardOverview'" class="w-full">
                                    @include('components.dashboard.overview')
                                </div>
                                <template x-if="tab === 'analytics'">
                                    @include('components.dashboard.analytics')
                                </template>
                                <template x-if="tab === 'reports'">
                                    @include('components.dashboard.reports')
                                </template>

                            </div>
                        </div>
                    @endif

                    @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                        <h1 class="text-2xl font-bold text-gray-900">Inventory Manager Dashboard</h1>
                        @if (session('success'))
                            <div id="alert" role="alert" class="alert alert-success mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @elseif (session('error'))
                            <div id="alert" role="alert" class="alert alert-error mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        @elseif ($errors->any())
                            <div id="alert" role="alert" class="alert alert-error mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                    fill="none" viewBox="0 0 24 24">
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
                                                <p class="text-gray-700 font-semibold text-sm">Total Products</p>
                                            </div>

                                            <x-lucide-package
                                                class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($available) ?? '24,500' }}</p> --}}
                                                {{-- <span class="text-xs text-gray-500">+20.1% from last month</span> --}}
                                                {{ $totalProducts }}
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
                                                <p class="text-gray-700 font-semibold text-sm">Low Stock Items</p>
                                            </div>


                                            <x-lucide-alert-circle
                                                class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />

                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($expiring) ?? '24,500' }}</p> --}}
                                                {{$lowStockItem}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                                <div class="flex items-center">

                                    <div class="flex flex-col w-full gap-3">
                                        <div class="flex justify-between items-center w-full">
                                            <div class="flex flex-col">
                                                <p class="text-gray-700 font-semibold text-sm">Pending Orders</p>
                                            </div>
                                            <x-lucide-clock
                                                class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($expiring) ?? '24,500' }}</p> --}}
                                                {{ $pendingCount }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total rejects and return --}}
                            <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
                                <div class="flex items-center">

                                    <div class="flex flex-col w-full gap-3">
                                        <div class="flex justify-between items-center w-full">
                                            <div class="flex flex-col">
                                                <p class="text-gray-700 font-semibold text-sm">Rejects and Return</p>
                                            </div>
                                            <x-lucide-rotate-ccw
                                                class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-gray-800">
                                                {{-- {{ number_format($expiring) ?? '24,500' }}</p> --}}
                                                {{$returnCount}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col lg:flex-row justify-between w-full gap-6">
                            <div
                                class="flex flex-col gap-6 mt-5 p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full ">
                                <div>
                                    <h1 class="text-zinc-800 font-semibold">Top Moving Items</h1>
                                    <p class="text-zinc-600 text-sm">Most Frequently In & Out</p>
                                </div>

                                <div class="w-11/12 mx-auto">
                                    <canvas id="myChart" class="w-full h-full"></canvas>
                                </div>
                            </div>

                            <div
                                class= "flex flex-col gap-6 flex-wrap lg:flex-nowrap mt-5 p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full ">
                                <div>
                                    <h1 class="text-zinc-800 font-semibold">Stock by Categories</h1>
                                    <p class="text-zinc-600 text-sm">Live status of your inventory across all
                                        categories
                                    </p>
                                </div>

                                <div class="w-11/12 mx-auto">
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
<script>
    const ctx = document.getElementById('myChart');

    const labels = @json($topItems->pluck('description'));
    const data = @json($topItems->pluck('total_moved'));
    window.myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total moved',
                data: data,
                backgroundColor: 'rgb(253 186 116)', // Tailwind blue-500 with opacity
                borderColor: 'rgb(249 115 22)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,


        },

    });


    const ctxDeadStock = document.getElementById('deadStockChart');
    const categoriesLabelsRaw = @json($stockSummary->pluck('item_group'));
    const categoriesData = @json($stockSummary->pluck('total_quantity'));

    const labelMap = {
        'DRESSED CHICKEN': 'DC',
        'FILLET': 'FF',
        'CHOICE CUT': 'CC',
        'VALUE ADDED PRODUCT': 'VA',
        'BY PRODUCT': 'BP',
    };

    const categoriesLabels = categoriesLabelsRaw.map(label => labelMap[label] || label);

    window.myChart2 = new Chart(ctxDeadStock, {
        type: 'bar',
        data: {
            labels: categoriesLabels,
            datasets: [{
                label: 'Stock',
                data: categoriesData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', // 30 days
                    'rgba(75, 192, 192, 0.7)', // 90 days
                    'rgba(255, 206, 86, 0.7)', // 60 days
                    'rgba(255, 206, 86, 0.7)', // 60 days
                    'rgba(75, 192, 192, 0.7)' // 90 days
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {

            responsive: true,
            maintainAspectRatio: false,


        }
    });
</script>
