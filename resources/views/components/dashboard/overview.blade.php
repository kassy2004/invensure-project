<div class="w-full">
    {{-- <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5">

        <!-- Total Equipment Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full sm:w-1/2 lg:w-1/4">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Total Revenue</p>
                        <x-lucide-philippine-peso class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">&#8369;{{ $totalEquipment ?? '24,500' }}</p>
                        <span class="text-xs text-gray-500">+20.1% from last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Borrowings Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full sm:w-1/2 lg:w-1/4">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Active Orders</p>
                        <x-lucide-package class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '+573' }}</p>
                        <span class="text-xs text-gray-500">+201 since yesterday</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Requests Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full sm:w-1/2 lg:w-1/4">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Inventory Status</p>
                        <x-lucide-box class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '85.2%' }}</p>
                        <span class="text-xs text-gray-500">-2.5% from last week</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Rooms Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full sm:w-1/2 lg:w-1/4">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Active Users</p>
                        <x-lucide-users class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '+5' }}</p>
                        <span class="text-xs text-gray-500">+3 since last week</span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="flex flex-col lg:grid gap-5 grid-cols-10">

        <div class="col-span-7 flex flex-col gap-6 p-6 bg-zinc-50 rounded-xl border-2 border-gray-200 w-full">
            <div>
                <h1 class="text-zinc-800 font-semibold">Inventory Breakdown: Quantity & Kilograms</h1>
                <p class="text-zinc-600 text-sm">Chart displays side-by-side metrics for each item group</p>
            </div>

            <div class="w-11/12 mx-auto">
                <canvas id="stockCategory" class="w-full"></canvas>
            </div>
        </div>
        <div class="col-span-3 flex flex-col gap-5">
            <div class="p-6 border-2 border-gray-200 rounded-lg bg-gray-50">
                <h1 class="text-lg font-semibold text-gray-800">Recent Activities</h1>
                <p class="text-sm text-gray-500">Latest updates from your supply chain</p>
            </div>

            <div class="p-6 border-2 border-gray-200 rounded-lg bg-gray-50">
                <div x-data="auditPagination({{ $audits->toJson() }})" class="flex flex-col justify-between min-h-[400px]">

                    <!-- Paginated items container -->
                    <div class="space-y-6">
                        <template x-for="audit in paginatedAudits" :key="audit.id">
                            <div class="flex flex-col">
                                <span class="text-gray-700 text-sm font-semibold" x-text="audit.event"></span>
                                <span class="text-gray-500 text-sm"
                                    x-text="`${audit.user_name} (${audit.user_role})`"></span>
                                <div class="flex items-center mt-2 gap-2">
                                    <x-lucide-clock class="h-4 w-4 text-gray-500" />
                                    <span class="text-gray-500 text-sm" x-text="timeAgo(audit.created_at)"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pagination controls -->
                    <div class="flex justify-between items-center mt-4 text-zinc-600 text-sm">
                        <button class="px-2 py-1 border rounded" :class="{ 'bg-orange-500 text-white': page > 1 }"
                            :disabled="page === 1" @click="page--">
                            Previous
                        </button>

                        <span class="text-sm text-gray-600">
                            Page <span x-text="page"></span> of <span x-text="totalPages"></span>
                        </span>

                        <button class="px-2 py-1 border rounded"
                            :class="{ 'bg-orange-500 text-white': page < totalPages }" :disabled="page === totalPages"
                            @click="page++">
                            Next
                        </button>
                    </div>
                </div>

                <script>
                    function auditPagination(data) {
                        return {
                            audits: data,
                            page: 1,
                            perPage: 3,

                            get totalPages() {
                                return Math.ceil(this.audits.length / this.perPage);
                            },
                            get paginatedAudits() {
                                return this.audits.slice((this.page - 1) * this.perPage, this.page * this.perPage);
                            },
                            timeAgo(dateString) {
                                const date = new Date(dateString);
                                const now = new Date();
                                const seconds = Math.floor((now - date) / 1000);

                                const intervals = {
                                    year: 31536000,
                                    month: 2592000,
                                    week: 604800,
                                    day: 86400,
                                    hour: 3600,
                                    minute: 60,
                                    second: 1
                                };

                                for (const [unit, value] of Object.entries(intervals)) {
                                    const amount = Math.floor(seconds / value);
                                    if (amount >= 1) {
                                        return `${amount} ${unit}${amount > 1 ? 's' : ''} ago`;
                                    }
                                }

                                return "just now";
                            }
                        }
                    }
                </script>
            </div>

            {{-- <div
            class= "flex flex-col gap-6 flex-wrap lg:flex-nowrap p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full ">
            <div>
                <h1 class="text-zinc-800 font-semibold">Stock by Categories</h1>
                <p class="text-zinc-600 text-sm">Live status of your inventory across all categories
                </p>
            </div>

            <div class="w-11/12 mx-auto">
                <canvas id="stockCategory" class="w-full"></canvas>
            </div>
        </div> --}}

            {{-- <div class="p-6 border-2 border-gray-200 rounded-lg w-full bg-gray-50">
            <h1 class="text-xl text-gray-800 font-semibold">Recent Activities</h1>
            <p class="text-sm text-gray-500">Latest updates from your supply chain</p>


            <div class="flex flex-col mt-10 ml-5 gap-6">
                <div class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Order #45324 Delivered</span>
                    <span class="text-gray-500 text-sm">Sunny & Scramble chicken products delivered to Customer
                        #563</span>

                    <div class="flex items-center mt-2 gap-2">
                        <x-lucide-clock class="h-4 w-4 shrink-0 text-gray-500" />
                        <span class="text-gray-500 text-sm">2 hours ago</span>

                    </div>
                </div>

                <div class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Inventory Updated</span>
                    <span class="text-gray-500 text-sm">Fresh chicken inventory updated by Inventory Manager</span>

                    <div class="flex items-center mt-2 gap-2">
                        <x-lucide-clock class="h-4 w-4 shrink-0 text-gray-500" />
                        <span class="text-gray-500 text-sm">5 hours ago</span>

                    </div>
                </div>


                <div class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Customer Login</span>
                    <span class="text-gray-500 text-sm">Customer logged in</span>

                    <div class="flex items-center mt-2 gap-2">
                        <x-lucide-clock class="h-4 w-4 shrink-0 text-gray-500" />
                        <span class="text-gray-500 text-sm">1 day ago</span>

                    </div>
                </div>

            </div>
        </div> --}}
        </div>
    </div>
    <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5 w-full justify-between">

        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
    <div class="flex items-center">
        <div class="flex flex-col w-full gap-3">
            <div class="flex justify-between items-center w-full">
                <p class="text-gray-700 font-semibold text-sm">Customer Satisfaction</p>

                @if (isset($yearlyChange))
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1 
                            {{ $yearlyChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            @if ($yearlyChange >= 0)
                                <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                            @else
                                <x-lucide-arrow-down-right class="h-5 w-5 shrink-0" />
                            @endif
                            <span class="font-semibold text-sm">
                                {{ $yearlyChange >= 0 ? '+' : '' }}{{ $yearlyChange }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500 italic">
                            compared to last year
                        </span>
                    </div>
                @else
                    <div class="text-gray-400 text-sm">No data</div>
                @endif
            </div>

            <div>
                <p class="text-3xl font-bold text-gray-800">
                    {{ $yearlyAverage ? number_format($yearlyAverage, 1) : '0.0' }}/5
                </p>
                <span class="text-xs text-gray-500">Average rating this year</span>
            </div>
        </div>
    </div>
</div>


    
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
            <div class="flex items-center">
                <div class="flex flex-col w-full gap-3">

                    {{-- Header and weekly change --}}
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Customer Satisfaction</p>

                        @if (isset($weeklyChange))
                            <div class="flex flex-col">

                                <div
                                    class="flex gap-2 items-center {{ $weeklyChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                    @if ($weeklyChange >= 0)
                                        <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                                    @else
                                        <x-lucide-arrow-down-right class="h-5 w-5 shrink-0" />
                                    @endif
                                    <span>{{ $weeklyChange >= 0 ? '+' : '' }}{{ $weeklyChange }}</span>
                                </div>
                                <span class="text-xs text-gray-500">Compared to last week</span>

                            </div>
                        @else
                            <div class="text-gray-400 text-sm">No data</div>
                        @endif
                    </div>

                    {{-- Average Rating --}}
                    <div>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ $weeklyAverage ? number_format($weeklyAverage, 1) : '0.0' }}/5
                        </p>
                        <span class="text-xs text-gray-500">Average rating this week</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Maintenance Requests Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Customer Satisfaction</p>
                        @if (isset($ratingChange))
                            <div class="flex flex-col">

                                <div
                                    class="flex gap-2 items-center 
                            {{ $ratingChange >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    @if ($ratingChange >= 0)
                                        <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                                    @else
                                        <x-lucide-arrow-down-right class="h-5 w-5 shrink-0" />
                                    @endif

                                    <span>{{ $ratingChange >= 0 ? '+' : '' }}{{ $ratingChange }}</span>
                                </div>
                                <span class="text-xs text-gray-500">Compared to last month</span>
                            </div>
                        @else
                            <div class="text-gray-400 text-sm">No data</div>
                        @endif

                    </div>
                    <div>
                          <p class="text-3xl font-bold text-gray-800">
                            {{ $monthlyAverage ? number_format($monthlyAverage, 1) : '0.0' }}/5
                        </p>
                        <span class="text-xs text-gray-500">Average rating this month</span>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxStockCategory = document.getElementById('stockCategory');

        const stockcategoriesLabelsRaw = @json($stockSummary->pluck('item_group'));
        const quantityData = @json($stockSummary->pluck('total_quantity'));
        const kilogramData = @json($stockKiloSummary->pluck('total_kilogram'));
        const labelMap = {
            'DRESSED CHICKEN': 'DC',
            'FILLET': 'FF',
            'CHOICE CUT': 'CC',
            'VALUE ADDED PRODUCT': 'VA',
            'BY PRODUCT': 'BP',
        };


        const stockcategoriesLabels = stockcategoriesLabelsRaw.map(label => labelMap[label] || label);
        // console.log(stockcategoriesLabels, stockcategoriesData);
        window.myChart3 = new Chart(ctxStockCategory, {
            type: 'line',
            data: {
                labels: stockcategoriesLabels,
                datasets: [{
                        label: 'Quantity',
                        data: quantityData,
                        borderColor: 'rgb(249, 115, 22)',
                        backgroundColor: 'rgba(249, 115, 22, 0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Kilogram',
                        data: kilogramData,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }
                ]
            },
            options: {

                responsive: true,
                maintainAspectRatio: false,


            }
        });
    });
</script>
