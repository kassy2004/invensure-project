<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex flex-col lg:flex-row  lg:items-center lg:justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Finished Goods Inventory</h1>
                        <h4 class="text-zinc-700">PCSI Warehouse</h4>
                    </div>
                    <div class="flex gap-2 mt-5 lg:mt-0">
                        <button popovertarget="popover-1" style="anchor-name:--anchor-1" {{-- onclick="window.location='{{ url('/export-pcsi-incoming') }}'" --}}
                            class="px-4 py-2 flex items-center gap-3 rounded-md text-zinc-900 text-sm border border-zinc-300 hover:border-zinc-400 transition duration-200 ease-in-out"><x-lucide-download
                                class="h-4 w-4" />Export</button>
                        <ul class="dropdown menu w-52 rounded-box bg-zinc-50 text-zinc-600 shadow-sm" popover id="popover-1"
                            style="position-anchor:--anchor-1">
                            <li class="text-zinc-600  hover:bg-zinc-100 rounded-lg  active:bg-orange-500"><a href="{{ url('/export-pcsi-incoming') }}">Incoming</a></li>
                             <li class="text-zinc-600  hover:bg-zinc-100 rounded-lg  active:bg-orange-500"><a href="{{ url('/export-pcsi-outgoing') }}">Outgoing</a></li>
                        </ul>
                        <button onclick="my_modal_5.showModal()"
                            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                            <x-lucide-plus class="h-4 w-4" />
                            Add Item</button>

                    </div>



                </div>
                @if (session('success'))
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
                @endif


                <!-- You can open the modal using ID.showModal() method -->
                <dialog id="my_modal_5" class="modal  modal-bottom sm:modal-middle">
                    <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                        <form method="dialog">
                            <button
                                class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
                        </form>
                        <h3 class="text-lg font-bold text-zinc-900">Add item to PCSI Warehouse</h3>



                        <form method="POST" action="{{ route('warehouse.pcsi.add') }}" x-data="{ loading: false }"
                            @submit.prevent="loading = true; $nextTick(() => $el.submit())" id="addItemForm">
                            @csrf
                            <div class="flex flex-col gap-5">

                                <div class="flex gap-5 justify-between">
                                    {{-- <div class="flex flex-col w-full">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Data Entry</legend>
                                        </fieldset>
                                        <select name="data_entry" id="data_entry" class="tom-select"
                                            class="border border-zinc-300 bg-white text-zinc-800 rounded-md px-3 py-2 h-auto focus:outline-none focus:ring-2 focus:ring-blue-500 focus:text-blue-600 w-full">
                                            <option value="">Select an item...</option>
                                        </select>
                                    </div> --}}
                                    <div x-data="{ open: false, search: '', selected: null }" class="relative w-full">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Data Entry</legend>
                                        </fieldset>
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Search item..."
                                            class="w-full border border-zinc-300 rounded-md px-3 py-2 text-zinc-800" />

                                        <div x-show="open"
                                            class="absolute z-[9999] mt-1 w-full bg-white border border-zinc-300 rounded-md max-h-48 overflow-y-auto">
                                            @foreach ($item_master as $item)
                                                <div x-show="{{ json_encode($item->item) }}.toLowerCase().includes(search.toLowerCase())"
                                                    @click="selected = '{{ $item->id }}'; search = '{{ $item->item }}'; open = false"
                                                    class="px-3 py-2 cursor-pointer hover:bg-zinc-100 text-sm text-zinc-700 flex flex-col">
                                                    <span>{{ $item->item }}</span>
                                                    <span class="text-gray-500 text-xs">{{ $item->new_mrp_code }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="item_master_id" :value="selected" required />

                                    </div>


                                    <!-- Hidden inputs to store additional item data -->

                                    <div class="flex flex-col w-full">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Prod. Date</legend>
                                        </fieldset>
                                        <button type="button" popovertarget="cally-popover1"
                                            class="input input-border bg-zinc-50 border border-zinc-300 text-zinc-600 w-full cursor-pointer"
                                            id="cally1" style="anchor-name:--cally1">
                                            <x-lucide-calendar class="h-4 w-4" />
                                        </button>
                                        <div popover id="cally-popover1"
                                            class="dropdown bg-zinc-200 rounded-box shadow-lg"
                                            style="position-anchor:--cally1">
                                            <calendar-date class="cally  text-zinc-900 "
                                                onchange="
                                        const selectedDate = this.value || this.getAttribute('value');
                                        document.getElementById('prod_date').value = selectedDate;
                                        document.getElementById('cally1').innerText = selectedDate;
                                    ">
                                                <svg aria-label="Previous" class="fill-current size-4 text-zinc-900 "
                                                    slot="previous" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                                </svg>
                                                <svg aria-label="Next" class="fill-current size-4  text-zinc-900 "
                                                    slot="next" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                                </svg>
                                                <calendar-month></calendar-month>
                                            </calendar-date>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600">Inventory</legend>
                                    <div class="flex gap-5">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Head/Pack</legend>
                                            <input type="text" name="inventory_head"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="0" required />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Kilogram</legend>
                                            <input type="text" name="inventory_kilo"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                                placeholder="0.00" required />

                                        </fieldset>
                                    </div>
                                    <div>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Received By</legend>
                                            <input type="text" name="received_by"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                                placeholder="AA00000000/AA00000" required />

                                        </fieldset>
                                    </div>
                                </div>

                                <input type="hidden" name="prod_date" id="prod_date">
                            </div>
                            <hr class="my-5">
                            <div class="flex justify-end gap-5">

                                <button type="button" onclick="document.getElementById('my_modal_5').close()"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                                <button type="submit" :disabled="loading"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out gap-2 items-center">
                                    <template x-if="loading">
                                        <x-lucide-loader class="h-4 w-4 animate-spin" />
                                    </template>
                                    <span x-text="loading ? 'Adding…' : 'Add'"></span>
                                </button>
                            </div>

                        </form>

                    </div>
                </dialog>

                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">

                    <div x-data="{ tab: 'subtotal' }">
                        <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">
                            <span @click="tab = 'subtotal'" :class="tab === 'subtotal' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Subtotal</span>
                            <span @click="tab = 'status'" :class="tab === 'status' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Status </span>
                        </div>
                        <div class="mt-5 w-full">
                            <div x-show="tab === 'subtotal'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.subtotal')
                            </div>

                            <div x-show="tab === 'status'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.status')
                            </div>

                        </div>
                    </div>


                    <div x-data="{ tab: 'incoming' }">
                        <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                            <span @click="tab = 'incoming'" :class="tab === 'incoming' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Incoming</span>
                            <span @click="tab = 'outgoing'" :class="tab === 'outgoing' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Outgoing </span>
                            <span @click="tab = 'pod-pcsi'" :class="tab === 'pod-pcsi' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">POD </span>

                        </div>
                        <div class="mt-5 w-full">
                            <div x-show="tab === 'incoming'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.incoming')
                            </div>

                            <div x-show="tab === 'outgoing'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.outgoing')
                            </div>
                            <div x-show="tab === 'pod-pcsi'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.pod-pcsi')
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Convert PHP data to JavaScript options
    // var itemOptions = JSON.parse('{!! $item_master->toJson() !!}').map(function(item) {
    //     console.log(itemOptions);
    //     return {
    //         idnum: item.id,
    //         id: item.item,
    //         title: item.item + ' - ' + (item.item_group || '') + ' - ' + (item.variant || ''),
    //         item_group: item.item_group,
    //         item_code: item.new_mrp_code,
    //         variant: item.variant,
    //         kilogram_tray: item.kilogram_tray,
    //         class: item.class,
    //         sku: item.sku,
    //         fg: item.fg,
    //         primary_packaging: item.primary_packaging,
    //         secondary_packaging: item.secondary_packaging
    //     };
    // });

    // new TomSelect('#data_entry', {
    //     maxItems: 1,
    //     maxOptions: 100,
    //     valueField: 'id',
    //     labelField: 'title',
    //     searchField: ['title', 'item_group', 'variant', 'sku'],
    //     sortField: 'title',
    //     options: itemOptions,
    //     create: false,
    //     placeholder: "Search item...",
    //     render: {
    //         option: function(data, escape) {
    //             return '<div class="option h-12">' +
    //                 '<div class="font-medium">' + escape(data.title) + '</div>' +
    //                 '<div class="text-sm text-gray-500">' +
    //                 (data.item_group ? 'Group: ' + escape(data.item_group) + ' | ' : '') +
    //                 (data.variant ? 'Variant: ' + escape(data.variant) : '') +
    //                 '</div>' +
    //                 '</div>';
    //         }
    //     },
    //     onInitialize: function() {
    //         console.log('TomSelect initialized with', this.options.length, 'options');
    //     },
    //     onChange: function(value) {
    //         if (value) {
    //             // Find the selected item data
    //             var selectedItem = itemOptions.find(function(item) {
    //                 return item.id === value;
    //             });

    //             if (selectedItem) {
    //                 // Populate hidden fields with selected item data
    //                 document.getElementById('idnum').value = selectedItem.idnum || '';

    //                 document.getElementById('item_group').value = selectedItem.item_group || '';
    //                 document.getElementById('item_code').value = selectedItem.item_code || '';
    //                 document.getElementById('variant').value = selectedItem.variant || '';
    //                 document.getElementById('kilogram_tray').value = selectedItem.kilogram_tray || '';
    //                 document.getElementById('class').value = selectedItem.class || '';
    //                 document.getElementById('sku').value = selectedItem.sku || '';
    //                 document.getElementById('fg').value = selectedItem.fg || '';
    //                 document.getElementById('primary_packaging').value = selectedItem.primary_packaging ||
    //                     '';
    //                 document.getElementById('secondary_packaging').value = selectedItem
    //                     .secondary_packaging || '';

    //                 console.log('Selected item:', selectedItem);
    //             }
    //         } else {
    //             // Clear hidden fields if no item is selected
    //             document.getElementById('item_group').value = '';
    //             document.getElementById('idnum').value = '';
    //             document.getElementById('variant').value = '';
    //             document.getElementById('kilogram_tray').value = '';
    //             document.getElementById('class').value = '';
    //             document.getElementById('sku').value = '';
    //             document.getElementById('fg').value = '';
    //             document.getElementById('primary_packaging').value = '';
    //             document.getElementById('secondary_packaging').value = '';
    //         }
    //     }
    // });
</script>
