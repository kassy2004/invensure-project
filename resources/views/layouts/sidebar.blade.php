<div class="flex w-full min-h-screen">
    <!-- Sidebar toggle -->
    <input id="sidebar-toggle" type="checkbox" class="hidden" />

    <!-- Sidebar -->
    <div id="sidebar"
        class="bg-white hidden lg:block text-grey min-h-screen transition-all duration-300 border-r border-zinc-300
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
        <hr class="border-gray-200 w-[80%] mx-auto">
        <ul class="space-y-2 py-2">


            @if (auth()->check() && auth()->user()->role === 'admin')
                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3  cursor-pointer
   {{ Request::is('dashboard') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 " />

                    <span class="ml-3 hidden group-[.w-64]:inline ">Dashboard</span>
                </li>
                <li onclick="window.location='{{ url('/sales') }}'"
                    class="flex items-center  px-5 py-3 cursor-pointer
       {{ Request::is('sales') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-line-chart class="h-5 w-5 shrink-0 " />
                    <span  class="ml-3 hidden group-[.w-64]:inline ">Sales Forecasting</span>
                </li>

            

                <li onclick="window.location='{{ url('/customer') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
       {{ Request::is('customer') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-book-user class="h-5 w-5 shrink-0 " />
                    <span  class="ml-3 hidden group-[.w-64]:inline ">Customer</span>
                </li>
                <li onclick="window.location='{{ url('/user') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
       {{ Request::is('user') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-users class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">User Management</span>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'customer')
              
                <li onclick="window.location='{{ url('/orders') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
{{ Request::is('orders') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-package-2 class="h-5 w-5 shrink-0 " />
                    <div class="ml-3 hidden group-[.w-64]:inline ">Orders</div>
                </li>
            @endif

            {{-- Inventory Manager --}}

            @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                <li class="flex items-center mt-4">
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700 text-sm">Main</span>
                </li>

                <li onclick="window.location='{{ url('/dashboard') }}'"
                    class="flex items-center px-5 py-3  cursor-pointer
 {{ Request::is('dashboard') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5 shrink-0 " />

                    <span class="ml-3 hidden group-[.w-64]:inline ">Dashboard</span>
                </li>




                <li onclick="window.location='{{ url('/item-master') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
 {{ Request::is('item-master') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-archive class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">Item Master</span>
                </li>
                <li onclick="window.location='{{ url('/return-item') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
{{ Request::is('return-item') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-rotate-ccw class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">Return Item</span>
                </li>


                {{-- Warehouse --}}
                <li class="flex items-center">
                    <span class="ml-3 hidden group-[.w-64]:inline text-gray-700 text-sm">Warehouse</span>
                </li>
                {{-- PCSI Warehouse --}}
                <li onclick="window.location='{{ url('/warehouse/pcsi') }}'"
                    class="flex items-center  px-5 py-3 cursor-pointer
{{ Request::is('warehouse/pcsi') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-warehouse class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">PCSI</span>
                </li>
                {{-- 3JFPC Warehouse --}}
                <li onclick="window.location='{{ url('/warehouse/jfpc') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
{{ Request::is('warehouse/jfpc') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-warehouse class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">3JFPC</span>
                </li>


                <li onclick="window.location='{{ url('/warehouse/transfer') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
{{ Request::is('warehouse/transfer') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-package class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">Transfer</span>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role === 'logistics_coordinator')
               
                <li onclick="window.location='{{ url('/operations') }}'"
                    class="flex items-center  px-5 py-3 cursor-pointer
{{ Request::is('operations') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">
                    <x-lucide-truck class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">Delivery Ops.</span>
                </li>
                <li onclick="window.location='{{ url('/pod') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
   {{ Request::is('pod') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">

                    <x-lucide-clipboard-check class="h-5 w-5 shrink-0 " />
                    <span class="ml-3 hidden group-[.w-64]:inline ">POD Automation</span>
                </li>
                <li onclick="window.location='{{ url('/signatures') }}'"
                    class="flex items-center  px-5 py-3  cursor-pointer
  {{ Request::is('signatures') ? 'bg-orange-500 text-zinc-50' : 'hover:bg-gray-200 transition duration-300 ease-in-out text-gray-700' }}">
                    <x-lucide-pen-tool class="h-5 w-5 shrink-0 " />
                    {{-- icon --}}{{-- bladeicon --}}
                    <span class="ml-3 hidden group-[.w-64]:inline ">Digital Signatures</span>
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
