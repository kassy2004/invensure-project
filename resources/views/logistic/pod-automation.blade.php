<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Proof of Delivery Automation</h1>
                    </div>
                </div>
                {{-- @if (session('success'))
                    <div id="alert" role="alert" class="alert alert-success mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div id="alert" role="alert" class="alert alert-error mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @elseif ($errors->any())
                    <div id="alert" role="alert" class="alert alert-error mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <ul class="list-disc pl-5 text-white text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}



                <div class="flex flex-col lg:flex-row  gap-6 mb-5 mt-5 w-full ">
                    <div class="w-full lg:w-[40%] border rounded-lg p-6 bg-zinc-50 border-zinc-300">
                        <div>
                            <h1 class="text-xl font-bold text-zinc-900">Recent PODs</h1>
                            <h4 class="text-zinc-700">Recently created and processed PODs</h4>
                        </div>

                        <div class="flex flex-col gap-4 mt-5 pr-2 overflow-y-auto max-h-128">
                            @forelse($pods as $pod)
                                <label class="cursor-pointer">
                                    <input type="radio" name="pod_selection" value="{{ $pod->id }}"
                                        class="peer hidden" data-pod="{{ json_encode($pod) }}">
                                    <div
                                        class="p-5 border border-gray-300 rounded-lg peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:bg-gray-100 transition duration-300 ease-in-out">
                                        <div class="flex flex-col gap-2">

                                            <div class="flex justify-between">
                                                <div class="flex items-center gap-2">
                                                    <x-lucide-file-check class="w-4 h-4 text-orange-500" />
                                                    <span class="text-sm text-zinc-700 font-semibold">POD
                                                        #{{ $pod->pod_number }}</span>
                                                </div>
                                                <div
                                                    class="p-1 {{ $pod->status === 'incomplete' ? 'bg-gray-200' : 'bg-orange-300' }} px-2 rounded-full text-xs  text-zinc-700">
                                                    <span>{{ ucfirst($pod->status) }}</span>
                                                </div>
                                            </div>

                                            <div class="text-sm text-zinc-500 flex flex-col">
                                                <span>{{ $pod->business_name }}</span>
                                                <span>{{ $pod->created_at }}</span>
                                            </div>
                                            {{-- <span class="text-sm text-zinc-500 flex">Order #{{ $pod->order_id }}</span> --}}
                                            <span class="text-xs text-zinc-500 flex">{{ $pod->allocation_count }} items
                                                - Total: {{ $pod->loaded_weight }}</span>
                                            <span class="text-xs text-zinc-500 flex">Driver: {{ $pod->driver_name }}
                                                ({{ $pod->plate_number }})
                                            </span>


                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="text-center py-8 text-zinc-500">
                                    <x-lucide-file-check class="w-12 h-12 mx-auto mb-4 text-zinc-300" />
                                    <p>No PODs found</p>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!-- POD to export to PDF -->
                    <div class=" w-full lg:w-[60%] border rounded-lg p-6 bg-zinc-50 border-zinc-300">
                        <div class="flex flex-col lg:flex-row lg:justify-between">
                            <div>

                                <h1 class="text-xl font-bold text-zinc-900">POD Preview</h1>
                                <h4 class="text-zinc-700">Digital proof of delivery document</h4>
                            </div>
                            <div class="mt-5 lg:mt-0">
                                <a id="export_pdf" href="#"
                                    data-route-template="{{ route('pod.pdf', ['id' => '__ID__']) }}"
                                    {{-- href="{{ route('pod.pdf', ['id' => $pod->id]) }}" --}} target="_blank"
                                    class="text-white bg-orange-500 px-4 py-2 rounded-md">
                                    Export to PDF
                                </a>
                            </div>

                        </div>
                        <div id="pod-preview"
                            class="flex flex-col mt-5 border rounded-lg border-zinc-300 p-4 gap-4 max-h-128 overflow-y-auto">
                            <!-- Default state when no POD is selected -->
                            <div id="no-pod-selected" class="text-center py-12 text-zinc-500">
                                <x-lucide-file-check class="w-16 h-16 mx-auto mb-4 text-zinc-300" />
                                <p class="text-lg font-semibold">Select a POD to preview</p>
                                <p class="text-sm">Choose a POD from the list to view its details</p>
                            </div>

                            <!-- POD content (hidden by default) -->
                            <div id="pod-content" class="hidden flex flex-col gap-4">
                                <div class="flex justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-zinc-700 text-sm font-bold" id="company-name">Sunny & Scramble
                                            Corporation</span>
                                        <span class="text-zinc-500 text-xs" id="company-type">Chicken & Egg
                                            Station</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-orange-500 text-sm font-bold">PROOF OF DELIVERY</span>
                                        <div class="text-zinc-500 text-xs flex gap-1 items-center justify-end">
                                            <x-lucide-file-check class="h-3 w-3" />
                                            <span>Digital POD</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="border rounded-lg border-zinc-300 ">
                                    <div
                                        class="flex items-start text-zinc-600 justify-center bg-gray-100 text-sm font-semibold border rounded-t-lg">
                                        <span class="my-2">CUSTOMER INFORMATION</span>
                                    </div>

                                    <div class="flex justify-between p-4">
                                        <div class="flex flex-col gap-2">
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Name:</span>
                                                <span class="text-zinc-500" id="customer-name">Restaurant Chain
                                                    Inc.</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Address:</span>
                                                <span class="text-zinc-500" id="customer-address">123 Main St, Metro
                                                    City</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Contact:</span>
                                                <span class="text-zinc-500" id="customer-contact">John Smith</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Phone:</span>
                                                <span class="text-zinc-500" id="customer-phone">+1 (555) 123-4567</span>
                                            </div>
                                        </div>


                                        <div class="flex flex-col gap-2">
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Date:</span>
                                                <span class="text-zinc-500" id="pod-date">April 5, 2024</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Time:</span>
                                                <span class="text-zinc-500" id="pod-time">10:23 AM</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">POD No.:</span>
                                                <span class="text-zinc-500" id="pod-number">0005230</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Status:</span>
                                                <span class="text-zinc-500 rounded-full  px-2"
                                                    id="pod-status">Completed</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="border rounded-lg border-zinc-300 ">
                                    <table class="min-w-full border border-zinc-300 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-100">
                                            <tr class="">
                                                <th class="px-4 py-2  text-left font-semibold text-sm text-gray-700">
                                                    PARTICULARS</th>
                                                <th class="px-4 py-2 text-center font-semibold text-sm text-gray-700">
                                                    QUANTITY</th>
                                                <th class="px-4 py-2 text-center font-semibold text-sm text-gray-700">
                                                    KILOGRAM</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white text-sm text-gray-800" id="items-table-body">
                                            <tr>
                                                <td class="px-4 py-2 border-b text-center" colspan="3">Select a POD
                                                    to view items</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="border rounded-lg border-zinc-300 ">
                                    <div
                                        class="flex items-start text-zinc-600 justify-center bg-gray-100 text-sm font-semibold border rounded-t-lg">
                                        <span class="my-2">DELIVERY INFORMATION</span>
                                    </div>
                                    <div class="flex justify-between p-4">
                                        <div class="flex flex-col gap-2">
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Driver:</span>
                                                <span class="text-zinc-500" id="driver-name">Michael Rodriguez</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Vehicle:
                                                </span>
                                                <span class="text-zinc-500" id="vehicle-info">Truck #T-103</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">License Plate:</span>
                                                <span class="text-zinc-500" id="plate-number">ABC-1234</span>
                                            </div>

                                        </div>


                                        <div class="flex flex-col gap-2 items-end">
                                            <div class="text-xs flex gap-2">
                                                <x-lucide-truck class="h-4 w-4 text-orange-500" />
                                                <span class="text-zinc-700">Delivery Route:</span>
                                                <span class="text-zinc-500" id="delivery-route">Route #R-45</span>
                                            </div>
                                            {{-- <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Time:</span>
                                                <span class="text-zinc-500">10:23 AM</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">POD No.:</span>
                                                <span class="text-zinc-500">0005230</span>
                                            </div>
                                            <div class="text-xs flex gap-2">
                                                <span class="text-zinc-700">Status:</span>
                                                <span class="text-zinc-500 rounded-full bg-green-300 px-2">Completed</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col lg:flex-row gap-4 justify-between">
                                    <div class="border rounded-lg border-zinc-300 flex flex-col p-4 gap-4 w-full">
                                        <div class="text-zinc-700 text-sm flex flex-col">
                                            <span class="font-semibold">Prepared by:</span>
                                            <span id="prepared-by">KIM HARLEY C. BONSOL</span>
                                        </div>

                                        <div class="flex flex-col justify-end text-zinc-500 text-xs text-center">
                                            <img src="" alt="" id="planner-signature">
                                            <hr>

                                            <span>Signature over printed name</span>
                                        </div>

                                        <div class="text-zinc-700 text-sm flex flex-col">
                                            <span class="font-semibold">Driver:</span>
                                            <span id="dispatched-by">KIM HARLEY C. BONSOL</span>
                                        </div>

                                        <div class="flex flex-col  justify-end text-zinc-500 text-xs text-center">
                                            <img src="" alt="" id="driver-signature">
                                            <hr>
                                            <span>Signature over printed name</span>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg border-zinc-300 flex flex-col p-4 gap-4 w-full">
                                        <div class="text-zinc-700 text-sm flex flex-col">
                                            <span class="font-semibold">Customer:</span>
                                            <span id="customer-name-sig"></span>
                                        </div>

                                        <div class="flex flex-col justify-end text-zinc-500 text-xs text-center">
                                            <img src="" alt="" id="customer-signature">
                                            <hr>

                                            <span>Signature over printed name</span>
                                        </div>

                                        <div class="text-zinc-700 text-sm flex flex-col">
                                            <span class="font-semibold mb-2">Trucking Details:</span>
                                            <div class="flex justify-between text-zinc-700 text-xs mb-4">
                                                <div class="w-full">
                                                    <span>STS/TR No.:</span>
                                                    <span id="sts-tr-number"></span>
                                                </div>
                                                <div class="flex items-start w-full">
                                                    <span>SEAL No.:</span>
                                                    <span id="seal-number"></span>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">

                                                <span class="font-semibold mb-4">Trucking Contractor:</span>
                                                <span id="trucking-contractor"></span>
                                            </div>
                                            <div class="flex gap-2">

                                                <span class="font-semibold ">Plate Number:</span>
                                                <span id="trucking-plate-number"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end w-full ">
                            <button id="complete-button" disabled
                                class="border rounded-md text-zinc-500 border-zinc-300 text-sm flex gap-2 items-center px-4 py-2 mt-5">
                                <span id="button-icon">
                                    <x-lucide-check class="h-5 w-5" />
                                </span>
                                <span id="button-text">Completed</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const podRadios = document.querySelectorAll('input[name="pod_selection"]');
            const noPodSelected = document.getElementById('no-pod-selected');
            const podContent = document.getElementById('pod-content');
            const completeButton = document.getElementById('complete-button');
            const status = document.getElementById('pod-status');
            const statusBg = document.getElementById('status-bg');
            // Function to update POD preview
            function updatePodPreview(podData) {
                // Hide no selection message and show POD content
                noPodSelected.classList.add('hidden');
                podContent.classList.remove('hidden');
                // if (status === 'incomplete') {
                //     statusBg.classList.remove('bg-orange-500');
                //     statusBg.classList.add('bg-gray-200');
                // }
                // Update POD information
                document.getElementById('pod-number').textContent = podData.pod_number || 'N/A';
                document.getElementById('pod-status').textContent = podData.status ? podData.status.charAt(0)
                    .toUpperCase() + podData.status.slice(1) : 'N/A';
                document.getElementById('pod-date').textContent = podData.created_at ? new Date(podData.created_at)
                    .toLocaleDateString() : 'N/A';
                document.getElementById('pod-time').textContent = podData.created_at ? new Date(podData.created_at)
                    .toLocaleTimeString() : 'N/A';

                // Update customer information
                document.getElementById('customer-name').textContent = podData.business_name || 'N/A';
                document.getElementById('customer-address').textContent = podData.address || 'N/A';
                document.getElementById('customer-contact').textContent = podData.business_name || 'N/A';
                document.getElementById('customer-phone').textContent = podData.phone || 'N/A';

                // Update delivery information
                document.getElementById('driver-name').textContent = podData.driver_name || 'N/A';
                document.getElementById('plate-number').textContent = podData.plate_number || 'N/A';
                document.getElementById('vehicle-info').textContent = `Truck #${podData.truck_id || 'N/A'}`;
                document.getElementById('delivery-route').textContent = `Route #${podData.allocation_id || 'N/A'}`;

                // Update trucking details
                document.getElementById('trucking-plate-number').textContent = podData.plate_number || 'N/A';
                document.getElementById('trucking-contractor').textContent = podData.driver_name || 'N/A';
                document.getElementById('sts-tr-number').textContent = podData.allocation_id || 'N/A';
                document.getElementById('seal-number').textContent = podData.pod_number || 'N/A';

                // Update signatures
                document.getElementById('prepared-by').textContent = podData.planner_name;
                document.getElementById('planner-signature').src = podData.planner_signature ? '/' + podData
                    .planner_signature : '';
                document.getElementById('driver-signature').src = podData.driver_signature ? '/' + podData
                    .driver_signature : '';
                document.getElementById('customer-signature').src = podData.customer_signature ? '/' + podData
                    .customer_signature : '';
                document.getElementById('dispatched-by').textContent = podData.driver_name;
                document.getElementById('customer-name-sig').textContent = podData.customer_name;

                
                const podId = podData.pod_number;
                updateExportPdfLink(podId);

                // Enable complete button if POD is completed
                if (!podData.driver_signature || !podData.customer_signature) {
                    completeButton.disabled = false;
                    completeButton.classList.remove('text-zinc-500', 'border-zinc-300');
                    completeButton.classList.add('bg-orange-500', 'text-white', 'border-orange-500');
                    document.getElementById('button-text').textContent = "Complete Signature";
                    document.getElementById('button-icon').innerHTML = `<x-lucide-pen-tool class="h-4 w-4" />`;
                    completeButton.onclick = function() {
                        window.location.href = "/signatures";
                    };

                } else {
                    completeButton.disabled = true;
                    completeButton.classList.remove('bg-orange-500', 'text-white', 'border-orange-500');
                    completeButton.classList.add('text-zinc-500', 'border-zinc-300');
                    document.getElementById('button-text').textContent = "Completed";
                    document.getElementById('button-icon').innerHTML = `<x-lucide-check class="h-5 w-5" />`;
                    completeButton.onclick = null;
                }

                // Update items table (you'll need to implement this based on your allocation data)
                updateItemsTable(podData);
            }

            function updateExportPdfLink(podId) {
                const routeTemplate = document.getElementById('export_pdf').dataset.routeTemplate;
                const finalRoute = routeTemplate.replace('__ID__', podId);
                const exportPdf = document.getElementById('export_pdf');
                exportPdf.href = finalRoute;
                exportPdf.textContent = 'Download PDF for ' + podId;
            }

            function resetExportPdfLink() {
                const exportPdf = document.getElementById('export_pdf');
                exportPdf.href = "#";
                exportPdf.textContent = "Export to PDF";
            }

            // Function to update items table
            function updateItemsTable(podData) {
                const tableBody = document.getElementById('items-table-body');

                if (!podData.items || podData.items.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td class="px-4 py-2 border-b text-center" colspan="3">No items found</td>
                        </tr>
                        <tr class="font-semibold">
                            <td class="px-4 py-2 border-b text-right">TOTAL QUANTITY:</td>
                            <td class="px-4 py-2 border-b text-center">0</td>
                            <td class="px-4 py-2 border-b text-center">0</td>
                        </tr>
                    `;
                    return;
                }

                let tableHTML = '';

                // Add each item to the table
                podData.items.forEach(item => {
                    tableHTML += `
                        <tr>
                            <td class="px-4 py-2 border-b">${item.particulars}</td>
                            <td class="px-4 py-2 border-b text-center">${item.quantity}</td>
                            <td class="px-4 py-2 border-b text-center">${item.kilogram}</td>
                        </tr>
                    `;
                });

                // Add total row
                tableHTML += `
                    <tr class="font-semibold">
                        <td class="px-4 py-2 border-b text-right">TOTAL QUANTITY:</td>
                        <td class="px-4 py-2 border-b text-center">${podData.total_quantity || 0}</td>
                        <td class="px-4 py-2 border-b text-center">${podData.total_kilogram || 0}</td>
                    </tr>
                `;

                tableBody.innerHTML = tableHTML;
            }

            // Function to reset to default state
            function resetPodPreview() {
                noPodSelected.classList.remove('hidden');
                podContent.classList.add('hidden');
                completeButton.disabled = true;
                completeButton.classList.remove('bg-green-500', 'text-white', 'border-green-500');
                completeButton.classList.add('text-zinc-500', 'border-zinc-300');
                resetExportPdfLink();
            }

            // Add event listeners to radio buttons
            podRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const podData = JSON.parse(this.getAttribute('data-pod'));
                        updatePodPreview(podData);
                    }
                });
            });

            // Initialize with no POD selected
            resetPodPreview();
        });
    </script>
</x-app-layout>
