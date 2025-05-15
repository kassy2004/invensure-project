
<div class="w-full">
<div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5 w-full justify-between">

        <!-- Total Equipment Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">
                
                <div class="flex flex-col w-full gap-3">
                     <div class="flex justify-between items-center w-full">
                         <p class="text-gray-700 font-semibold text-sm">Active Deliveries</p>
                         <div class="text-gray-500 flex gap-2 items-center">
                            <x-lucide-truck class="h-5 w-5 shrink-0" />
                         </div>
                     </div>
                     <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "92%" }}</p>
                        <div class="flex items-center text-green-500">
                            <x-lucide-arrow-up-right class="h-4 w-4 shrink-0" />
                            <span class="text-xs">+5 from yesterday</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Active Borrowings Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
            <div class="flex items-center">
                
                <div class="flex flex-col w-full gap-3">
                     <div class="flex justify-between items-center w-full">
                         <p class="text-gray-700 font-semibold text-sm">Completed Today</p>
                         <div class="text-gray-500 flex gap-2 items-center">
                            <x-lucide-check-circle-2 class="h-5 w-5 shrink-0" />
                            
                         </div>
                     </div>
                     <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "18" }}</p>
                        <div class="flex items-center text-green-500">
                            <x-lucide-arrow-up-right class="h-4 w-4 shrink-0" />
                            <span class="text-xs">+3 from average</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Maintenance Requests Card -->
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">
                
                <div class="flex flex-col w-full gap-3">
                     <div class="flex justify-between items-center w-full">
                         <p class="text-gray-700 font-semibold text-sm">On-Time Delivery Rate</p>
                         <div class="text-gray-500 flex gap-2 items-center">
                            <x-lucide-clock class="h-5 w-5 shrink-0" />
                         </div>
                     </div>
                     <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "92.5%" }}</p>
                        <div class="flex items-center text-red-500">
                            <x-lucide-arrow-down-right class="h-4 w-4 shrink-0" />
                            <span class="text-xs">-1.2% from last week</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5">
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">

            <h1 class="text-xl text-gray-800 font-semibold">Delivery Status Overview</h1>
            <p class="text-sm text-gray-500">Real-time status of all deliveries in the system</p>

            <div class="flex flex-col mt-10 ">
                <div class="flex justify-between text-gray-500">
                <span class="text-gray-700">In Transit</span>
                    <span class="text-gray-500 text-sm">14 deliveries</span>

                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 44%"></div>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 text-xs">44% of active deliveries</span>
                    <span class="text-gray-500 text-xs">Est. completion: 2-4 hours</span>

                </div>
                  
            </div>


            <div class="flex flex-col mt-5 ">
                <div class="flex justify-between text-gray-500">
                <span class="text-gray-700">Loading</span>
                    <span class="text-gray-500 text-sm">8 deliveries</span>

                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 text-xs">25% of active deliveries</span>
                    <span class="text-gray-500 text-xs">Est. departure: 30-60 minutes</span>

                </div>
                  
            </div>

            <div class="flex flex-col mt-5 ">
                <div class="flex justify-between text-gray-500">
                <span class="text-gray-700">Arrived at Destination</span>
                    <span class="text-gray-500 text-sm">6 deliveries</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 19%"></div>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 text-xs">19% of active deliveries</span>
                    <span class="text-gray-500 text-xs">Awaiting POD completion</span>

                </div>
            </div>
            <div class="flex flex-col mt-5 ">
                <div class="flex justify-between text-gray-500">
                <span class="text-gray-700">Scheduled</span>
                    <span class="text-gray-500 text-sm">4 deliveries</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 12%"></div>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 text-xs">12% of active deliveries</span>
                    <span class="text-gray-500 text-xs">Scheduled for today</span>

                </div>
            </div>

            <div class="flex item-center w-full justify-center bg-gray-900 rounded-md py-2 mt-4 cursor-pointer">
                <span class="text-white">View All Deliveries</span>

            </div>
        </div>


    </div>
    <div class="flex flex-wrap justify-between lg:flex-nowrap gap-6 mb-5 mt-5">
        <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <h1 class="text-xl text-gray-800 font-semibold">POD Completion Rate </h1>
            <p class="text-sm text-gray-500">Digital proof of delivery status</p>

            <div class="rounded-md p-10 border-2 border-gray-200 mt-5 bg-gray-50 w-full ">
                <div class="flex flex-col items-center">
                    <span class="text-2xl text-gray-900 font-bold">87%</span>
                    <span class="text-sm text-gray-900">Digital POD completion rate</span>
                </div>

                <div class="flex flex-col mt-10 ">
                    <div class="flex justify-between text-gray-500">
                    <span class="text-gray-700">Completed</span>
                        <span class="text-gray-500 text-sm">87%</span>

                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 87%"></div>
                    </div>
                    
                </div>

                
            </div>
            <div class="flex justify-between mt-5">
                <span class="px-4 py-2 border border-gray-200 text-gray-900 rounded-md text-sm cursor-pointer">View POD Analytics</span>
                <span class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm cursor-pointer">Manage PODs</span>
            </div>
           

        </div>
        <div class="rounded-md p-6 border-2 border-gray-200 bg-gray-50 w-full">
            <h1 class="text-xl text-gray-800 font-semibold">POD Completion Rate </h1>
            <p class="text-sm text-gray-500">Digital proof of delivery status</p>
            <div class="rounded-md p-10 border-2 border-gray-200 mt-5 bg-gray-50 w-full h-53 flex items-center justify-center">
                <x-lucide-map-pin class="h-5 w-5 shrink-0 text-yellow-500"/>
            </div>

            <div class="flex justify-between mt-5">
                <span class="px-4 py-2 text-gray-900  text-xs">Most active region: Metro Manila</span>
                <span class="px-4 py-2 border border-gray-200 text-gray-900 rounded-md text-sm cursor-pointer">View Full Map</span>
            </div>
        </div>
    </div>
</div>