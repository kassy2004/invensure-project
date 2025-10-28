<div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full text-black">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl text-gray-800 font-semibold">Reports</h1>
            <p class="text-sm text-gray-500">View and generate supply chain reports</p>
        </div>

        <a href="{{ route('reports.generate') }}"
            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
            <x-lucide-sparkles class="h-4 w-4" />
            <span>Generate Report</span>
        </a>
    </div>

    <div class="mt-5">
        <select
            class="w-full max-w-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
            <option disabled selected>Select Report Type</option>
            <option>Inventory Reports</option>
            <option>Finance Reports</option>
            <option>Sales Reports</option>
        </select>

        <!-- Table container with border + rounded corners -->
        <div class="mt-5 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium">Report Name</th>
                        <th class="py-3 px-4 text-left font-medium">Type</th>
                        <th class="py-3 px-4 text-left font-medium">Warehouse</th>
                        <th class="py-3 px-4 text-left font-medium">Generated</th>
                        <th class="py-3 px-4 text-left font-medium">Size</th>
                        <th class="py-3 px-4 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Monthly Inventory Report</td>
                        <td class="py-3 px-4">PDF</td>
                        <td class="py-3 px-4">PCSI</td>
                        <td class="py-3 px-4">Oct 28, 2025</td>
                        <td class="py-3 px-4">1.2 MB</td>
                        <td class="py-3 px-4 text-center">

                            <button class="p-2 hover:bg-orange-500 hover:text-white rounded-lg"
                                popovertarget="popover-1" style="anchor-name:--anchor-1">
                                <x-lucide-ellipsis-vertical class="h-4 w-4" />
                            </button>
                            <ul class="bg-white dropdown menu w-52 rounded-box bg-base-100 shadow-sm" popover
                                id="popover-1" style="position-anchor:--anchor-1">
                                <li class="hover:bg-gray-200 rounded-md">
                                    <a class="flex items-center gap-2">
                                        <x-lucide-eye class="h-4 w-4" />
                                        <span>View</span>
                                    </a>
                                </li>
                                <li class="hover:bg-gray-200 rounded-md">
                                    <a class="flex items-center gap-2">
                                        <x-lucide-download class="h-4 w-4" />
                                        <span>Download</span>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Weekly Supply Chain Summary</td>
                        <td class="py-3 px-4">Excel</td>
                        <td class="py-3 px-4">3JFPC</td>
                        <td class="py-3 px-4">Oct 25, 2025</td>
                        <td class="py-3 px-4">850 KB</td>
                        <td class="py-3 px-4 text-center">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
