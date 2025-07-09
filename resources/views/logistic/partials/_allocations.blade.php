@foreach ($allocations as $item)
    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 mt-5 hover:shadow-md transition duration-300">
        <div class="flex gap-5 items-center justify-between">
            <h1 class="text-lg font-semibold text-zinc-900">
                {{ $item->allocation_id }}
                {{-- ALLOC-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
            - ALLOC-{{ str_pad($item->id  + $item->order_count -1, 4, '0', STR_PAD_LEFT) }} --}}
            </h1>
            <span
                class="text-xs rounded-full px-2 py-1
                @if ($item->status === 'in transit') bg-blue-500
                @elseif($item->status === 'delivered') bg-yellow-500
                @else bg-gray-400 @endif text-white">
                {{ $item->status }}
            </span>
        </div>

        <div class="flex text-gray-500 text-xs items-center gap-1">
            <x-lucide-calendar class="h-4 w-4 " />
            <span>{{ date('Y-m-d', strtotime($item->transaction_date)) }}</span>
        </div>
        <div class="flex justify-between w-1/2">

            <div class=" mt-5">
                <span class="text-zinc-700 text-sm font-semibold">Customer Information</span>

                <div class="flex flex-col gap-1 mt-3">

                    <span class="text-zinc-700 text-sm">{{ $item->customer_name }}</span>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-map-pin class="h-3 w-3 " />

                        <span>
                            {{ $item->address }}
                        </span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-phone class="h-3 w-3 " />
                        <span>
                            {{ $item->numbers }}
                        </span>
                    </div>
                </div>

            </div>

            <div class="mt-5">
                <span class="text-zinc-700 text-sm font-semibold">Delivery Details</span>

                <div class="flex flex-col gap-1 mt-3">


                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <span class="text-zinc-700">
                            Delivery Date:
                        </span>
                        <span>{{ date('m/d/Y', strtotime($item->transaction_date)) }}</span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <span class="text-zinc-700">
                            Quantity:
                        </span>
                        <span>{{ $item->total_quantity }}</span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <span class="text-zinc-700">
                            Kilogram:
                        </span>
                        <span>{{ $item->total_kilogram }} kg</span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <span class="text-zinc-700">
                            Products:
                        </span>
                        <span>{{ $item->order_count }}</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="flex  gap-2">

            <!-- View Button (trigger) -->
            <button onclick="viewModal{{ $item->id }}.showModal()"
                class="flex gap-2 px-4 py-2 text-zinc-700 items-center text-sm border border-zinc-300 rounded-md cursor-pointer hover:bg-zinc-100 transition">
                <x-lucide-package class="h-4 w-4" />
                <span>View Products</span>
            </button>

            <!-- Modal -->
            <dialog id="viewModal{{ $item->id }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box bg-zinc-50 border border-zinc-300 w-11/12 max-w-4xl max-h-[50vh] ">
                    <form method="dialog">
                        <button
                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                    </form>
                    <h1 class="text-lg font-bold text-zinc-900">
                        ALLOC-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        - ALLOC-{{ str_pad($item->id + $item->order_count - 1, 4, '0', STR_PAD_LEFT) }}
                    </h1>
                    <h3 class="text-sm font-bold text-zinc-500 mb-4">Product breakdown for {{ $item->customer_name }}
                    </h3>

                    <div class="overflow-x-auto text-zinc-500">
                        <table class="table text-sm">
                            <thead class=" broder-t">
                                <tr class="text-zinc-500">
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Kilogram</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->products as $index => $product)
                                    <tr class="border-t  hover:bg-zinc-100 transition text-zinc-700 font-semibold">
                                        <td class="border-t">{{ $index + 1 }}</td>
                                        <td class="border-t">{{ $product->item_code ?? 'N/A' }}</td>
                                        <td class="border-t">{{ $product->quantity }}</td>
                                        <td class="border-t">{{ $product->kilogram }} kg</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </dialog>


            @if ($item->status === 'pending')
                <button onclick="signModal{{ $item->id }}.showModal()"
                    class="flex gap-2 px-4 py-2 border-orange-500 text-orange-500 items-center text-sm border cursor-pointer hover:bg-orange-100  transition rounded-md">
                    <x-lucide-pen-tool class="h-4 w-4 " />
                    <span>Sign POD</span>
                </button>
            @elseif ($item->status === 'signed')
                <button onclick="assignModal{{ $item->id }}.showModal()"
                    class="flex gap-2 px-4 py-2 bg-orange-500 text-white items-center text-sm border cursor-pointer hover:bg-orange-400 transition rounded-md">
                    <x-lucide-truck class="h-4 w-4 " />
                    <span>Assign Truck</span>
                </button>
            @else
            @endif
            <dialog id="assignModal{{ $item->id }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box bg-zinc-50 border border-zinc-300 w-11/12 max-w-xl max-h-[70vh] overflow-visible">
                    <form method="dialog">
                        <button
                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                    </form>
                    <h1 class="text-lg font-bold text-zinc-900">
                        {{ $item->allocation_id }}
                    </h1>
                    <h3 class="text-sm font-bold text-zinc-500 mb-4">Assign allocations to a truck for delivery</h3>

                    <div>
                        <form method="POST" action="{{ route('delivery.load') }}">
                            @csrf
                            <div x-data="{ open: false, search: '', selected: null }" class="relative w-full mb-5">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Truck</legend>
                                </fieldset>
                                <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                                    placeholder="Search truck available..."
                                    class="w-full border border-zinc-300 rounded-md px-3 py-2 text-zinc-800" />

                                <div x-show="open"
                                    class="absolute z-[9999] mt-1 w-full bg-white border border-zinc-300 rounded-md max-h-48 overflow-y-auto">
                                    @foreach ($item->truck as $index => $trucks)
                                        @if ($trucks->capacity_kg >= $item->total_kilogram)
                                            <div x-show="`{{ $trucks->plate_number }}`.toLowerCase().includes(search.toLowerCase())"
                                                @click="selected = '{{ $trucks->id }}'; search = '{{ $trucks->plate_number }}'; open = false"
                                                class="px-3 py-2 cursor-pointer hover:bg-zinc-100 text-sm text-zinc-700 flex flex-col">
                                                <span>{{ $trucks->plate_number }}</span>
                                                <span class="text-gray-500 text-xs">{{ $trucks->driver_name }}</span>
                                                <span class="text-gray-500 text-xs">Capacity:
                                                    {{ $trucks->capacity_kg }}kg</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <input type="hidden" name="truck_id" :value="selected" required />
                                <input type="hidden" name="warehouse" value="{{ $item->warehouse }}" />
                                <input type="hidden" name="allocation_id" value="{{ $item->allocation_id }}"
                                    required />

                            </div>


                            <hr>
                            <div class="flex justify-end mt-5">
                                <button type="submit"
                                    class="flex gap-2 px-4 py-2 bg-orange-500 text-white items-center text-sm border cursor-pointer hover:bg-orange-400 transition rounded-md">
                                    <x-lucide-truck class="h-4 w-4 " />
                                    <span>Load</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </dialog>

            <dialog id="signModal{{ $item->id }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box bg-zinc-50 border border-zinc-300 w-11/12 max-w-xl max-h-[70vh] overflow-visible">
                    <form method="dialog">
                        <button
                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                    </form>
                    <h1 class="text-lg font-bold text-zinc-900">
                        {{ $item->allocation_id }} - Signature
                    </h1>
                    <h3 class="text-sm font-bold text-zinc-500 mb-4">Use your finger or stylus to sign in the area below</h3>

                    <div>
                        <canvas id="signatures-{{ $item->id }}"
                            class="w-full h-64 border border-gray-300 bg-white rounded-lg"></canvas>
                    </div>
                    <div class="flex justify-between mt-3">
                        <button id="clears-{{ $item->id }}"
                            class="px-6 py-2 text-zinc-700 flex gap-3 text-sm border rounded-md items-center hover:bg-gray-100 transition duration-300">
                            <x-lucide-undo-2 class="h-4 w-4 " />
                            <span>Clear</span>

                        </button>
                        <button id="saves-{{ $item->id }}"
                            class="px-6 py-2  text-white bg-orange-500 flex gap-3 text-sm border rounded-md items-center hover:bg-orange-400 transition duration-300">
                            <x-lucide-check class="h-4 w-4 " />
                            <span>Submit Signature</span>

                        </button>
                    </div>
                    {{-- <img id="signature-images-{{ $item->id }}" class="mt-4 hidden border rounded"
                        alt="Signature Preview"> --}}
                    {{-- <input type="hidden" name="allocation_id" value="{{ $item->allocation_id }}"> --}}

                </div>
            </dialog>
        </div>

    </div>
@endforeach
<script>
    // Store signature pads for each allocation
    const signaturePads = {};

    // Function to initialize signature pad for a specific allocation
    function initializeSignaturePad(allocationId) {
        const canvas = document.getElementById(`signatures-${allocationId}`);
        if (!canvas) return;

        // Create new signature pad instance
        signaturePads[allocationId] = new SignaturePad(canvas);

        // Resize canvas
        resizeCanvas(canvas, signaturePads[allocationId]);

        // Add event listeners for this specific allocation
        const clearBtn = document.getElementById(`clears-${allocationId}`);
        const saveBtn = document.getElementById(`saves-${allocationId}`);

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                signaturePads[allocationId].clear();
            });
        }
        if (saveBtn) {
            saveBtn.addEventListener('click', () => {
                if (signaturePads[allocationId].isEmpty()) {
                    alert("Please provide a signature.");
                    return;
                }

                const dataURL = signaturePads[allocationId].toDataURL(); // base64 PNG

                fetch('/save-signature', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            image: dataURL,
                            allocation_id: allocationId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Signature saved!');
                            // Optionally show image preview:
                            const signModal = document.getElementById(`signModal${allocationId}`);
                            if (signModal && typeof signModal.close === 'function') {
                                signModal.close();
                                location.reload();
                            }
                        } else {
                            alert('Failed to save signature.');
                        }
                    });
            });
        }
        // if (saveBtn) {
        //     saveBtn.addEventListener('click', () => {
        //         if (signaturePads[allocationId].isEmpty()) {
        //             alert("Please provide a signature.");
        //             return;
        //         }
        //         const dataURL = signaturePads[allocationId].toDataURL();
        //         const img = document.getElementById(`signature-images-${allocationId}`);
        //         if (img) {
        //             img.src = dataURL;
        //             img.classList.remove('hidden');
        //         }
        //     });
        // }
    }

    function resizeCanvas(canvas, signaturePad) {
        const ratio = window.devicePixelRatio || 1;
        const styles = getComputedStyle(canvas);
        const width = parseInt(styles.width);
        const height = parseInt(styles.height);

        canvas.width = width * ratio;
        canvas.height = height * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // Important: clear previous drawing
        signaturePad.clear();
    }

    // Initialize signature pads for all allocations when page loads
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[id^="signatures-"]').forEach(element => {
            const allocationId = element.id.replace('signatures-', '');
            initializeSignaturePad(allocationId);
        });
    });
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.nodeType === 1) { // Element node
                    const canvases = node.querySelectorAll?.('[id^="signatures-"]') || [];
                    canvases.forEach(canvas => {
                        const allocationId = canvas.id.replace('signatures-', '');
                        initializeSignaturePad(allocationId);
                    });
                }
            });
        });
    });
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Handle window resize for all signature pads
    window.addEventListener('resize', () => {
        Object.keys(signaturePads).forEach(allocationId => {
            const canvas = document.getElementById(`signatures-${allocationId}`);
            if (canvas && signaturePads[allocationId]) {
                resizeCanvas(canvas, signaturePads[allocationId]);
            }
        });
    });
</script>
