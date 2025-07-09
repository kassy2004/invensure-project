<div class="w-full">
    <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5">

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
    </div>

    <div class="flex gap-5">

        <div
            class= "flex flex-col gap-6 flex-wrap lg:flex-nowrap p-6 bg-zinc-50 rounded-xl border border-gray-200 w-full ">
            <div>
                <h1 class="text-zinc-800 font-semibold">Stock by Categories</h1>
                <p class="text-zinc-600 text-sm">Live status of your inventory across all categories
                </p>
            </div>

            <div class="w-11/12 mx-auto">
                <canvas id="stockCategory" class="w-full"></canvas>
            </div>
        </div>

        <div class="p-6 border-2 border-gray-200 rounded-lg w-full bg-gray-50">
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
        </div>
    </div>
    <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5 w-full justify-between">

        <!-- Total Equipment Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Delivery Perfomance</p>
                        <div class="text-green-400 flex gap-2 items-center">
                            <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                            <span>+4.3%</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '92%' }}</p>
                        <span class="text-xs text-gray-500">On-time delivery rate</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Borrowings Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <p class="text-gray-700 font-semibold text-sm">Inventory Turnover</p>
                        <div class="text-green-400 flex gap-2 items-center">
                            <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                            <span>+1.2x</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '8.5x' }}</p>
                        <span class="text-xs text-gray-500">Monthly turnover rate</span>
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
                        <div class="text-green-400 flex gap-2 items-center">
                            <x-lucide-arrow-up-right class="h-5 w-5 shrink-0" />
                            <span>+0.3</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? '4.7/5' }}</p>
                        <span class="text-xs text-gray-500">Average rating</span>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxStockCategory = document.getElementById('stockCategory');
        const stockcategoriesLabels = @json($stockSummary->pluck('item_group'));
        const stockcategoriesData = @json($stockSummary->pluck('total_quantity'));

        console.log(stockcategoriesLabels, stockcategoriesData);
        window.myChart3 = new Chart(ctxStockCategory, {
            type: 'bar',
            data: {
                labels: stockcategoriesLabels,
                datasets: [{
                    label: 'Stock',
                    data: stockcategoriesData,
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
    });
</script>
