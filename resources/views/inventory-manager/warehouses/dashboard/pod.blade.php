<div class="p-4 lg:p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
    <div class=" mb-5 flex gap-5 items-center justify-between">
        <h1 class="text-lg font-semibold text-zinc-900">
            Proof of Delivery (POD) - {{$warehouse_name}}
        </h1>

    </div>

    <div class="flex gap-2 mb-5">

        <label class="input bg-transparent border border-zinc-300 rounded-lg">
            <x-lucide-search class="h-4 w-4 text-gray-400 " />
            <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

        </label>
    </div>
    <div class="mt-5">
        <div class="flex flex-col gap-5">
            @foreach ($pod as $pods)
                <div class="p-4 border rounded-lg border-zinc-300  hover:shadow-md trasition duration-200 ease-in-out">
                    <div class="p-3">
                        <span class="text-zinc-700 font-semibold">POD #{{ $pods->pod_number }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-zinc-400 text-sm">Order #{{ $pods->order_id }}</span>
                        </div>

                        <div class="flex justify-between items-center mt-3 w-2/3">

                            <div class="flex flex-col gap-2 mt-3">
                                <div class="flex items-center gap-2">
                                    <x-lucide-user class="h-4 w-4 text-gray-400 " />
                                    <span class="text-zinc-600 text-xs">{{ $pods->business_name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-lucide-map-pin class="h-4 w-4 text-gray-400 " />
                                    <span class="text-zinc-400 text-xs">{{ $pods->delivery_location }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 mt-3">
                                <div class="flex items-center gap-2">
                                    <x-lucide-truck class="h-4 w-4 text-gray-400 " />
                                    <span class="text-zinc-600 text-xs">{{ $pods->driver_name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-lucide-calendar class="h-4 w-4 text-gray-400 " />
                                    <span class="text-zinc-400 text-xs">
                                        {{ \Carbon\Carbon::parse($pods->date_delivered)->format('F j, Y g:i A') }}
                                    </span>

                                </div>
                            </div>
                        </div>
                        <button onclick="viewModal{{ $pods->id }}.showModal()"
                            class="flex gap-2 px-4 py-2 text-zinc-700 items-center text-sm border border-zinc-300 rounded-md cursor-pointer hover:bg-zinc-100 transition mt-5">
                            <x-lucide-eye class="h-4 w-4" />
                            <span>View</span>
                        </button>



                    </div>

                </div>

                <dialog id="viewModal{{ $pods->id }}" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box bg-zinc-50 border border-zinc-300 lg:w-11/12 lg:max-w-6xl max-h-[80vh] ">
                        <form method="dialog" class="modal-backdrop">
                            <button
                                class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                        </form>
                        <h1 class="text-lg font-bold text-zinc-900">
                            POD #{{ $pods->pod_number }}
                        </h1>
                        <h3 class="text-sm font-bold text-zinc-500 mb-4">Product breakdown for Order
                            #{{ $pods->order_id }}
                        </h3>

                        <div class="overflow-x-auto text-zinc-500">

                            <div class="border rounded-lg border-zinc-300 ">
                                <div
                                    class="flex items-start text-zinc-600 justify-center bg-gray-100 text-sm font-semibold border rounded-t-lg">
                                    <span class="my-2">CUSTOMER INFORMATION</span>
                                </div>

                                <div class="flex justify-between p-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Name:</span>
                                            <span class="text-zinc-500"
                                                id="customer-name">{{ $pods->business_name }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Address:</span>
                                            <span class="text-zinc-500"
                                                id="customer-address">{{ $pods->delivery_location }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Contact:</span>
                                            <span class="text-zinc-500"
                                                id="customer-contact">{{ $pods->email }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Phone:</span>
                                            <span class="text-zinc-500" id="customer-phone">{{ $pods->numbers }}</span>
                                        </div>
                                    </div>


                                    <div class="flex flex-col gap-2">
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Date:</span>
                                            <span class="text-zinc-500" id="pod-date">
                                                {{ \Carbon\Carbon::parse($pods->date_delivered)->format('F j, Y') }}
                                            </span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Time:</span>
                                            <span class="text-zinc-500" id="pod-time">
                                                {{ \Carbon\Carbon::parse($pods->date_delivered)->format('g:i A') }}
                                            </span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">POD No.:</span>
                                            <span class="text-zinc-500" id="pod-number">{{ $pods->pod_number }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Status:</span>
                                            <span class="text-zinc-500 rounded-full  px-2"
                                                id="pod-status">Completed</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="border rounded-lg border-zinc-300 mt-4">
                                <table class="min-w-full border border-zinc-300 rounded-lg overflow-hidden">
                                    <thead class=" broder-t bg-gray-100">
                                        <tr class="text-zinc-500">
                                            <th class="px-4 py-2  text-left font-semibold text-sm text-gray-700">#</th>
                                            <th class="px-4 py-2  text-left font-semibold text-sm text-gray-700">Product
                                            </th>
                                            <th class="px-4 py-2  text-left font-semibold text-sm text-gray-700">
                                                Quantity</th>
                                            <th class="px-4 py-2  text-left font-semibold text-sm text-gray-700">
                                                Kilogram</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @php
                                            $productIdsArray = explode(',', $pods->product_ids);
                                            $outgoings = DB::table('pcsi_outgoing')
                                                ->whereIn('id', $productIdsArray)
                                                ->get();
                                        @endphp

                                        @foreach ($outgoings as $item)
                                            <tr
                                                class="border-t text-sm  hover:bg-zinc-100 transition text-zinc-700 font-semibold">
                                                <td class="px-4 py-2 border-b">{{ $item->id }}</td>
                                                <td class="px-4 py-2 border-b">{{ $item->item_code ?? 'N/A' }}</td>
                                                <td class="px-4 py-2 border-b">{{ $item->quantity }}</td>
                                                <td class="px-4 py-2 border-b">{{ $item->kilogram }} kg</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="border rounded-lg border-zinc-300 mt-4">
                                <div
                                    class="flex items-start text-zinc-600 justify-center bg-gray-100 text-sm font-semibold border rounded-t-lg">
                                    <span class="my-2">DELIVERY INFORMATION</span>
                                </div>

                                <div class="flex justify-between p-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Driver:</span>
                                            <span class="text-zinc-500"
                                                id="driver-name">{{ $pods->driver_name }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">Vehicle:
                                            </span>
                                            <span class="text-zinc-500" id="vehicle-info">Truck
                                                #{{ $pods->truck_id }}</span>
                                        </div>
                                        <div class="text-xs flex gap-2">
                                            <span class="text-zinc-700">License Plate:</span>
                                            <span class="text-zinc-500"
                                                id="plate-number">{{ $pods->plate_number }}</span>
                                        </div>

                                    </div>


                                    <div class="flex flex-col gap-2 items-end">
                                        <div class="text-xs flex gap-2">
                                            <x-lucide-truck class="h-4 w-4 text-orange-500" />
                                            <span class="text-zinc-700">Delivery Route:</span>
                                            <span class="text-zinc-500" id="delivery-route">Route #R-45</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row gap-4 justify-between mt-4">
                                @php
                                    $signatures = $pods->signatures->keyBy('type'); // map by type for easy access
                                @endphp
                                <div class="border rounded-lg border-zinc-300 flex flex-col p-4 gap-4 w-full">
                                    <div class="text-zinc-700 text-sm flex flex-col">
                                        <span class="font-semibold">Prepared by:</span>

                                    </div>

                                    <div class="flex flex-col justify-end text-zinc-500 text-xs text-center">
                                        @if (isset($signatures['planner']))
                                            <img src="{{ asset($signatures['planner']->signature) }}"
                                                alt="Planner Signature" class="h-24 mx-auto">
                                            <p class="text-sm mt-1">{{ $signatures['planner']->name }}</p>
                                        @else
                                            <p class="text-gray-400">No signature</p>
                                        @endif
                                        <hr>

                                        <span>Signature over printed name</span>
                                    </div>

                                    <div class="text-zinc-700 text-sm flex flex-col">
                                        <span class="font-semibold">Driver:</span>

                                    </div>

                                    <div class="flex flex-col  justify-end text-zinc-500 text-xs text-center">
                                        @if (isset($signatures['driver']))
                                            <img src="{{ asset($signatures['driver']->signature) }}"
                                                alt="Driver Signature" class="h-24 mx-auto">
                                            <p class="text-sm mt-1">{{ $signatures['driver']->name }}</p>
                                        @else
                                            <p class="text-gray-400">No signature</p>
                                        @endif
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
                                        @if (isset($signatures['customer']))
                                            <img src="{{ asset($signatures['customer']->signature) }}"
                                                alt="Customer Signature" class="h-24 mx-auto">
                                            <p class="text-sm mt-1">{{ $signatures['customer']->name }}</p>
                                        @else
                                            <p class="text-gray-400">No signature</p>
                                        @endif
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
                                            <span id="trucking-contractor">{{ $pods->driver_name }}</span>
                                        </div>
                                        <div class="flex gap-2">

                                            <span class="font-semibold ">Plate Number:</span>
                                            <span id="trucking-plate-number">{{ $pods->plate_number }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </dialog>
            @endforeach


        </div>

    </div>




</div>
<script>
    const signatures = @json($signatures ?? []);
    signatures.forEach(sig => {
        const type = sig.type.toLowerCase();
        const img = document.getElementById(`${type}-signature`);
        if (img) {
            img.src = '/' + sig.signature; // Add base URL if needed
            img.alt = `${type} signature`;
        }
    });
</script>
