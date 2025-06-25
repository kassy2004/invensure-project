<div class="flex gap-6 flex-col">
    
    <div class="flex gap-6 flex-wrap lg:flex-nowrap">
        <!-- Total Equipment Card -->
        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total Inventory</p>
                            <p class="text-zinc-500 font-semibold text-xs">Head/Pack</p>
                        </div>
                        <x-lucide-sigma class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ number_format($inventory_head) ?? '24,500' }}</p>
                        {{-- <span class="text-xs text-gray-500">+20.1% from last month</span> --}}
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
                            <p class="text-gray-700 font-semibold text-sm">Total Inventory</p>
                            <p class="text-zinc-500 font-semibold text-xs">Kilogram</p>
                        </div>

                        <x-lucide-package class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($inventory_kilo) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Requests Card -->
        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total QTY Issued</p>
                            <p class="text-zinc-500 font-semibold text-xs">Head/Pack</p>
                        </div>
                        <x-lucide-box class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($qty_head) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="flex gap-6 flex-wrap lg:flex-nowrap">



        <!-- Total Rooms Card -->
        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total QTY Issued</p>
                            <p class="text-zinc-500 font-semibold text-xs">Kilogram</p>
                        </div>
                        <x-lucide-users class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($qty_kilo) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total Available Balance</p>
                            <p class="text-zinc-500 font-semibold text-xs">Head/Pack</p>
                        </div>
                        <x-lucide-users class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($balance_head) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total Available Balance</p>
                            <p class="text-zinc-500 font-semibold text-xs">Kilogram</p>
                        </div>
                        <x-lucide-users class="h-5 w-5 shrink-0 text-gray-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($balance_kilo) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>