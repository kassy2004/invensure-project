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
                        <p class="text-3xl font-bold text-gray-800">&#8369;{{ $totalEquipment ?? "24,500" }}</p>
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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "+573" }}</p>
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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "85.2%" }}</p>
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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "+5" }}</p>
                        <span class="text-xs text-gray-500">+3 since last week</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    <div class="flex gap-5">

        <div class="p-6 border-2 border-gray-200 rounded-lg w-full bg-gray-50">
            <h1 class="text-xl text-gray-800 font-semibold">Supply Chain Overview</h1>
            <p class="text-sm text-gray-500">Current status of your supply chain operations</p>

            <div class="flex flex-col mt-10 ml-5">
                <span class="text-gray-700">Inventory Management</span>
                <div class="flex justify-between text-gray-500">
                    <span class="text-gray-500 text-sm">Stock levels at 85%</span>
                    <span class="text-gray-500 text-sm">85%</span>

                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
                  
            </div>


            <div class="flex flex-col mt-5 ml-5">
                <span class="text-gray-700">Logistic & Delivery</span>
                <div class="flex justify-between text-gray-500">
                    <span class="text-gray-500 text-sm">On-time delivery rate</span>
                    <span class="text-gray-500 text-sm">92%</span>

                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                </div>
                  
            </div>

            <div class="flex flex-col mt-5 ml-5">
                <span class="text-gray-700">Quality Control Issues</span>
                <div class="flex justify-between text-gray-500">
                    <span class="text-gray-500 text-sm">Defect rate</span>
                    <span class="text-gray-500 text-sm">3%</span>

                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: 3%"></div>
                </div>
                  
            </div>
        </div>

        <div class="p-6 border-2 border-gray-200 rounded-lg w-full bg-gray-50">
            <h1 class="text-xl text-gray-800 font-semibold">Recent Activities</h1>
            <p class="text-sm text-gray-500">Latest updates from your supply chain</p>


            <div class="flex flex-col mt-10 ml-5 gap-6">
                <div class="flex flex-col">
                    <span class="text-gray-700 text-sm font-semibold">Order #45324 Delivered</span>
                    <span class="text-gray-500 text-sm">Sunny & Scramble chicken products delivered to Customer #563</span>

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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "92%" }}</p>
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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "8.5x" }}</p>
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
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEquipment ?? "4.7/5" }}</p>
                        <span class="text-xs text-gray-500">Average rating</span>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

</div>