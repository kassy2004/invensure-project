<div class="flex w-full min-h-screen">
    <!-- Sidebar toggle -->
    <input id="sidebar-toggle" type="checkbox" class="hidden" />

    <!-- Sidebar -->
    <div id="sidebar"
        class="bg-white text-grey min-h-screen transition-all duration-300
              w-16 overflow-hidden group"
        :class="{ 'w-64': document.getElementById('sidebar-toggle').checked }">
        <div class="flex items-center justify-between px-5 py-4">
            @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                <span class="text-lg font-bold hidden group-[.w-64]:inline text-gray-700 ">Inventory Manager</span>
            @elseif(auth()->check() && auth()->user()->role === 'admin')
                <span class="text-lg font-bold hidden group-[.w-64]:inline text-gray-700 ">Admin</span>
            @elseif(auth()->check() && auth()->user()->role === 'customer')
                <span class="text-lg font-bold hidden group-[.w-64]:inline text-gray-700 ">Customer</span>
            @elseif(auth()->check() && auth()->user()->role === 'logistics_coordinator')
                <span class="text-lg font-bold hidden group-[.w-64]:inline text-gray-700 ">Logistics Coordinator</span>
            @endif
            <label for="sidebar-toggle" class="cursor-pointer text-grey">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </label>
        </div>
        <hr class="border-gray-300">
        <ul class="space-y-2 py-2">


            @if (auth()->check() && auth()->user()->role === 'admin')
                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('dashboard') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 text-gray-700" />

                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700 font-semibold">Dashboard</a>
                </li>
                <li onclick="window.location='{{ url('/sales') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
       {{ Request::is('sales') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-line-chart class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Sales Forecasting</a>
                </li>

                <li onclick="window.location='{{ url('/inventory') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
         {{ Request::is('inventory') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-package class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Inventory</a>
                </li>



                <li onclick="window.location='{{ url('/delivery') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
      {{ Request::is('delivery') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-truck class="h-5 w-5 shrink-0 text-gray-700" /> {{-- icon --}}{{-- bladeicon --}}
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700">Delivery & Logistic</span>
                </li>


                <li onclick="window.location='{{ url('/user') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
       {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-users class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">User Management</a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'customer')
                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('dashboard') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 text-gray-700" />

                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700 font-semibold">Dashboard</a>
                </li>

                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
     {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-star class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Service Ratings</a>
                </li>

                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
     {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-package-check class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Proof of Delivery</a>
                </li>
                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
     {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-clipboard-list class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Receipt & Invoices</a>
                </li>
                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-trending-up class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Satisfaction Metrics</a>
                </li>
            @endif

            {{-- Inventory Manager --}}

            @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                <li class="flex items-center mt-4">
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700 text-sm">Main</span>
                </li>

                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer
 {{ Request::is('dashboard') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 text-gray-700" />

                    <a class="ml-3 hidden group-[.w-64]:inline text-gray-700">Dashboard</a>
                </li>




                <li onclick="window.location='{{ url('/item-master') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
 {{ Request::is('item-master') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-archive class="h-5 w-5 shrink-0 text-gray-700" />
                    <a class="ml-3 hidden group-[.w-64]:inline text-gray-700">Item Master</a>
                </li>
                <li onclick="window.location='{{ url('/return-item') }}'"
                class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
{{ Request::is('return-item') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                <x-lucide-rotate-ccw class="h-5 w-5 shrink-0 text-gray-700" />
                <a class="ml-3 hidden group-[.w-64]:inline text-gray-700">Return Item</a>
            </li>


                {{-- Warehouse --}}
                <li class="flex items-center">
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700 text-sm">Warehouse</span>
                </li>
                {{-- PCSI Warehouse --}}
                <li onclick="window.location='{{ url('/warehouse/pcsi') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
{{ Request::is('warehouse/pcsi') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-warehouse class="h-5 w-5 shrink-0 text-gray-700" />
                    <a class="ml-3 hidden group-[.w-64]:inline text-gray-700">PCSI</a>
                </li>
                {{-- 3JFPC Warehouse --}}
                <li onclick="window.location='{{ url('/warehouse/jfpc') }}'"
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
{{ Request::is('warehouse/jfpc') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-warehouse class="h-5 w-5 shrink-0 text-gray-700" />
                    <a class="ml-3 hidden group-[.w-64]:inline text-gray-700">3JFPC</a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role === 'logistics_coordinator')
                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer
{{ Request::is('dashboard') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 text-gray-700" />

                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700 font-semibold">Dashboard</a>
                </li>
                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('sales') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-clipboard-check class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">POD Automation</a>
                </li>

                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
     {{ Request::is('inventory') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                    <x-lucide-map-pin class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">GPS Verification</a>
                </li>



                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
  {{ Request::is('delivery') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-pen-tool class="h-5 w-5 shrink-0 text-gray-700" />
                    {{-- icon --}}{{-- bladeicon --}}
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700">Digital Signatures</span>
                </li>


                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-file-check class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">POD IDs & Audit
                        Trails</a>
                </li>

                <li
                    class="flex items-center  px-5 py-3 hover:bg-gray-200 cursor-pointer
   {{ Request::is('user') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">

                    <x-lucide-truck class="h-5 w-5 shrink-0 text-gray-700" />
                    <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-700">Delivery Operations</a>
                </li>
            @endif
        </ul>

    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle.addEventListener('change', function() {
                if (this.checked) {
                    sidebar.classList.add('w-64');
                    sidebar.classList.remove('w-16');
                    sidebar.classList.remove('justify-center');


                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');

                }
                setTimeout(() => {
                    if (window.myChart) {
                        window.myChart.resize();
                    }
                    if (window.myChart2) {
                        window.myChart2.resize();
                    }
                }, 310);


            });
        });
    </script>
