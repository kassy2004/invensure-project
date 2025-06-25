<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Finished Goods Inventory</h1>
                        <h4 class="text-zinc-700">3JFPC Warehouse</h4>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="onExport()"
                            class="px-4 py-2 flex items-center gap-3 rounded-md text-zinc-900 text-sm border border-zinc-300 hover:border-zinc-400 transition duration-200 ease-in-out"><x-lucide-download
                                class="h-4 w-4" />Export</button>
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



                        <form method="POST" action="{{ route('warehouse.jfpc.add') }}" id="addItemForm">
                            @csrf
                            <div class="flex flex-col gap-5">

                                <div class="flex gap-5 justify-between">
                                    <div class="flex flex-col w-full">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Data Entry</legend>
                                        </fieldset>
                                        <select name="data_entry" id="data_entry" class="tom-select"
                                            class="border border-zinc-300 bg-white text-zinc-800 rounded-md px-3 py-2 h-auto focus:outline-none focus:ring-2 focus:ring-blue-500 focus:text-blue-600 w-full">
                                            <option value="">Select an item...</option>
                                        </select>
                                    </div>

                                    <!-- Hidden inputs to store additional item data -->

                                    <div class="flex flex-col w-2/3">
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

                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Remarks</legend>
                                            <input type="text" name="remarks"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                                  />
                                            <p class="label text-zinc-400">Optional</p>
                                        </fieldset>
                                        
                                        
                                    </div>
                                </div>
                                <input type="hidden" name="item_group" id="item_group">
                                <input type="hidden" name="idnum" id="idnum">
                                <input type="hidden" name="variant" id="variant">
                                <input type="hidden" name="kilogram_tray" id="kilogram_tray">
                                <input type="hidden" name="class" id="class">
                                <input type="hidden" name="sku" id="sku">
                                <input type="hidden" name="fg" id="fg">
                                <input type="hidden" name="primary_packaging" id="primary_packaging">
                                <input type="hidden" name="secondary_packaging" id="secondary_packaging">
                                <input type="hidden" name="prod_date" id="prod_date">
                                <input type="hidden" name="item_code" id="item_code">
                            </div>
                            <hr class="my-5">
                            <div class="flex justify-end gap-5">

                                <button type="button" onclick="document.getElementById('my_modal_5').close()"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                                <button type="submit"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out">Add</button>
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

                    <div class=" p-10 bg-zinc-50  h-auto mt-10 rounded-lg border border-zinc-300">
                        <div class=" mb-5 flex gap-5 items-center">
                            <h1 class="text-lg font-semibold text-zinc-900">
                                Finished Goods Inventory (Pinnacle Cold Storage Solutions)
                            </h1>
                            <details class="dropdown ">
                                <summary
                                    class="btn h-10 rounded-lg bg-transparent text-zinc-500 font-semibold border-zinc-300 shadow-none hover:border-zinc-400 transition duration-200 ease-in-out text-xs">
                                    2025
                                    <x-lucide-chevron-down class="h-4 w-4" />

                                </summary>
                                <ul
                                    class="dropdown-content flex flex-col px-2 border border-zinc-300 bg-gray-100 rounded-box z-10 w-24  overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap pb-2">
                                    <li
                                        class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                        2024</li>
                                    <li
                                        class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                        2023</li>
                                    <li
                                        class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                        2022</li>
                                    <li
                                        class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                        2021</li>
                                </ul>
                            </details>

                        </div>

                        <div class="flex gap-2 mb-5">

                            <label class="input bg-transparent border border-zinc-300 rounded-lg">
                                <x-lucide-search class="h-4 w-4 text-gray-400 " />
                                <input id="search-box" type="search" class="grow text-zinc-600"
                                    placeholder="Search" />

                            </label>
                            {{-- <input type="text" id="quickFilterInput"
                            placeholder="Search by ID, borrower, or equipment..."
                            class="h-10 rounded-lg bg-transparent  text-gray-300 border border-zinc-300  w-2/8"> --}}
                            <div
                                class=" h-10 px-3 flex rounded-lg text-zinc-900 border border-zinc-300 items-center justify-center text-center hover:border-zinc-400 transition duration-200 ease-in-out cursor-pointer">
                                <x-lucide-filter class="h-4 w-4" />
                            </div>
                            <div>
                                <details class="dropdown ">
                                    <summary
                                        class="btn h-10 rounded-lg bg-transparent text-zinc-800 font-normal border-zinc-300 shadow-none hover:border-zinc-400 transition duration-200 ease-in-out">
                                        <x-lucide-columns-3 class="h-4 w-4" />
                                        View
                                    </summary>
                                    <ul
                                        class="dropdown-content flex flex-col gap-2 px-3 border border-zinc-300 bg-gray-100 rounded-box z-10 w-64 p-2 overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap mt-2">

                                        <!-- Basic Info -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3">
                                            Basic Info
                                            <input type="checkbox"
                                                onchange="toggleSection(this, ['id','data_entry','item_group'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('id', this)" checked> Line</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('data_entry', this)" checked> Data
                                                Entry</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('item_group', this)" checked> Item
                                                Group</label>
                                        </li>
                                        <hr class="my-2">
                                        <!-- Product Details -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Product Details
                                            <input type="checkbox"
                                                onchange="toggleSection(this, ['sku','fg','kilogram/tray','variant','class'])">
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('variant', this)"> Variant</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('kilogram/tray', this)">
                                                Kilogram/Tray</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('class', this)"> Class</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('sku', this)"> SKU Description</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('fg', this)"> FG Description</label></li>

                                        <hr class="my-2">
                                        <!-- Packaging -->

                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Packaging <input type="checkbox"
                                                onchange="toggleSection(this, ['primary_packaging','secondary_packaging'])">
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('primary_packaging', this)"> Primary
                                                Packaging</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('secondary_packaging', this)"> Secondary
                                                Packaging</label></li>
                                        <hr class="my-2">

                                        <!-- Inventory -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Inventory <input type="checkbox"
                                                onchange="toggleSection(this, ['inventory_head','inventory_kilo'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('inventory_head', this)" checked>
                                                Head/Pack</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('inventory_kilo', this)" checked>
                                                Kilogram</label></li>

                                        <hr class="my-2">

                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Balance <input type="checkbox"
                                                onchange="toggleSection(this, ['balance_head','balance_kilo'])"
                                                checked>
                                        </li>

                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('balance_head', this)" checked>
                                                Head/Pack</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('balance_kilo', this)"
                                                    checked>Kilogram</label>
                                        </li>
                                        <hr class="my-2">


                                        <!-- Movement -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Movement <input type="checkbox"
                                                onchange="toggleSection(this, ['received_by','qty_head','qty_kilo'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('received_by', this)"> Received by</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('qty_head', this)"> Qty Issued
                                                (Head/Pack)</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('qty_kilo', this)"> Qty Issued
                                                (Kilogram)</label></li>
                                        <hr class="my-2">

                                        <!-- Dates -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Dates <input type="checkbox"
                                                onchange="toggleSection(this, ['prod_date','left','exp_date','date'])"
                                                checked></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('prod_date', this)" checked>
                                                Prod_Date</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('left', this)"> Left</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('exp_date', this)" checked> Exp_Date</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('date', this)"> Created At</label>
                                        </li>
                                        <hr class="my-2">
                                        <!-- Status -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Status <input type="checkbox"
                                                onchange="toggleSection(this, ['status','storage_num'])" checked></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('status', this)" checked> Status</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('storage_num', this)"> Storage #</label>
                                        </li>
                                    </ul>

                                </details>
                            </div>

                        </div>




                        <div id="myGrid" class="ag-theme-alpine bg-zinc-300"></div>
                    </div>
                    <div class=" p-10 bg-zinc-50  h-auto mt-10 rounded-lg border border-zinc-300">
                        <div class=" mb-5 flex gap-5 items-center">
                            <h1 class="text-lg font-semibold text-zinc-900">
                                Remarks
                            </h1>
                       
                        </div>

                        <div class="flex gap-2 mb-5">

                            <label class="input bg-transparent border border-zinc-300 rounded-lg">
                                <x-lucide-search class="h-4 w-4 text-gray-400 " />
                                <input id="search-box" type="search" class="grow text-zinc-600"
                                    placeholder="Search" />

                            </label>
                            {{-- <input type="text" id="quickFilterInput"
                            placeholder="Search by ID, borrower, or equipment..."
                            class="h-10 rounded-lg bg-transparent  text-gray-300 border border-zinc-300  w-2/8"> --}}
                            <div
                                class=" h-10 px-3 flex rounded-lg text-zinc-900 border border-zinc-300 items-center justify-center text-center hover:border-zinc-400 transition duration-200 ease-in-out cursor-pointer">
                                <x-lucide-filter class="h-4 w-4" />
                            </div>
                           

                        </div>




                        <div id="myGridTwo" class="ag-theme-alpine bg-zinc-300"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Convert PHP data to JavaScript options
    var itemOptions = JSON.parse('{!! $item_master->toJson() !!}').map(function(item) {
        console.log(itemOptions);
        return {
            idnum: item.id,
            id: item.item,
            title: item.item + ' - ' + (item.item_group || '') + ' - ' + (item.variant || ''),
            item_group: item.item_group,
            item_code: item.new_mrp_code,
            variant: item.variant,
            kilogram_tray: item.kilogram_tray,
            class: item.class,
            sku: item.sku,
            fg: item.fg,
            primary_packaging: item.primary_packaging,
            secondary_packaging: item.secondary_packaging
        };
    });

    new TomSelect('#data_entry', {
        maxItems: 1,
        maxOptions: 100,
        valueField: 'id',
        labelField: 'title',
        searchField: ['title', 'item_group', 'variant', 'sku'],
        sortField: 'title',
        options: itemOptions,
        create: false,
        placeholder: "Search item...",
        render: {
            option: function(data, escape) {
                return '<div class="option h-12">' +
                    '<div class="font-medium">' + escape(data.title) + '</div>' +
                    '<div class="text-sm text-gray-500">' +
                    (data.item_group ? 'Group: ' + escape(data.item_group) + ' | ' : '') +
                    (data.variant ? 'Variant: ' + escape(data.variant) : '') +
                    '</div>' +
                    '</div>';
            }
        },
        onInitialize: function() {
            console.log('TomSelect initialized with', this.options.length, 'options');
        },
        onChange: function(value) {
            if (value) {
                // Find the selected item data
                var selectedItem = itemOptions.find(function(item) {
                    return item.id === value;
                });

                if (selectedItem) {
                    // Populate hidden fields with selected item data
                    document.getElementById('idnum').value = selectedItem.idnum || '';

                    document.getElementById('item_group').value = selectedItem.item_group || '';
                    document.getElementById('item_code').value = selectedItem.item_code || '';
                    document.getElementById('variant').value = selectedItem.variant || '';
                    document.getElementById('kilogram_tray').value = selectedItem.kilogram_tray || '';
                    document.getElementById('class').value = selectedItem.class || '';
                    document.getElementById('sku').value = selectedItem.sku || '';
                    document.getElementById('fg').value = selectedItem.fg || '';
                    document.getElementById('primary_packaging').value = selectedItem.primary_packaging ||
                        '';
                    document.getElementById('secondary_packaging').value = selectedItem
                        .secondary_packaging || '';

                    console.log('Selected item:', selectedItem);
                }
            } else {
                // Clear hidden fields if no item is selected
                document.getElementById('item_group').value = '';
                document.getElementById('idnum').value = '';
                document.getElementById('variant').value = '';
                document.getElementById('kilogram_tray').value = '';
                document.getElementById('class').value = '';
                document.getElementById('sku').value = '';
                document.getElementById('fg').value = '';
                document.getElementById('primary_packaging').value = '';
                document.getElementById('secondary_packaging').value = '';
            }
        }
    });
    let gridOptions;

    function toggleColumn(columnKey, checkbox) {
        if (!gridOptions || !gridOptions.api || !gridOptions.columnApi) return;
        gridOptions.columnApi.setColumnVisible(columnKey, checkbox.checked);
    }

    function toggleSection(checkbox, fieldList) {
        if (!gridOptions || !gridOptions.api || !gridOptions.columnApi) return;
        fieldList.forEach(field => {
            gridOptions.columnApi.setColumnVisible(field, checkbox.checked);
            // Also update the individual checkboxes if they exist
            const input = document.querySelector(`input[type="checkbox"][onchange*="'${field}'"]`);
            if (input) input.checked = checkbox.checked;
        });
    }
    document.getElementById('search-box').addEventListener('input', function() {
        gridOptions.api.setQuickFilter(this.value);
    });


    document.addEventListener('DOMContentLoaded', function() {
        const columnDefs = [{
                headerName: "Basic Info",
                children: [{
                        headerName: "Line No.",
                        field: "id",
                        width: 90
                    },
                    {
                        headerName: "Data Entry",
                        field: "data_entry"
                    },
                    {
                        headerName: "Item Group",
                        field: "item_group"
                    }
                ]
            },
            {
                headerName: "Product Details",
                children: [{
                        headerName: "Variant",
                        field: "variant"
                    },
                    {
                        headerName: "Kilogram/Tray",
                        field: "kilogram/tray"
                    },
                    {
                        headerName: "Class",
                        field: "class"
                    },
                    {
                        headerName: "SKU",
                        field: "sku"
                    },
                    {
                        headerName: "FG",
                        field: "fg"
                    }
                ]
            },
            {
                headerName: "Packaging",
                children: [{
                        headerName: "Primary",
                        field: "primary_packaging"
                    },
                    {
                        headerName: "Secondary",
                        field: "secondary_packaging"
                    }
                ]
            },
            {
                headerName: "Inventory",
                children: [{
                        headerName: "Head/Pack",
                        field: "inventory_head"
                    },
                    {
                        headerName: "Kilogram",
                        field: "inventory_kilo"
                    },

                ]
            },
            {
                headerName: "Balance",
                children: [{
                        headerName: "Head/Pack",
                        field: "balance_head",
                        width: 200,
                    },
                    {
                        headerName: "Kilogram",
                        field: "balance_kilo"
                    }
                ]
            },
            {
                headerName: "Movement",
                children: [{
                        headerName: "Received by",
                        field: "received_by"
                    },
                    {
                        headerName: "Qty Issued (Head/Pack)",
                        field: "qty_head"
                    },
                    {
                        headerName: "Qty Issued (Kilogram)",
                        field: "qty_kilo"
                    },

                ]
            },
            {
                headerName: "Dates",
                children: [{
                        headerName: "Prod Date",
                        field: "prod_date"
                    },
                    {
                        headerName: "Left",
                        field: "left"
                    },
                    {
                        headerName: "Exp Date",
                        field: "exp_date"
                    },
                    {
                        headerName: "Created At",
                        field: "date"
                    }
                ]
            },
            {
                headerName: "Status",
                children: [{
                        headerName: "Status",
                        field: "status"
                    },
                    {
                        headerName: "Storage #",
                        field: "storage_num"
                    },
                    {
                        headerName: "Storage #",
                        field: "remarks"
                    }
                ]
            }
        ];
        const rowData = @json($inventoryJson);

        gridOptions = {
            columnDefs: columnDefs,
            rowData: rowData,
            domLayout: 'autoHeight',
            defaultColDef: {
                resizable: true,
                flex: 1,
                sortable: true,
                filter: true
            },
            onGridReady: function(params) {
                gridOptions.api = params.api;
                gridOptions.columnApi = params.columnApi;
                // Set initial visibility based on checkboxes
                document.querySelectorAll('input[type="checkbox"][onchange^="toggleColumn"]').forEach(
                    cb => {
                        const colKey = cb.getAttribute('onchange').match(/'([^']+)'/)[1];
                        gridOptions.columnApi.setColumnVisible(colKey, cb.checked);
                    });
            },
            pagination: true,
            paginationPageSize: 10,

        };


        const gridDiv = document.getElementById('myGrid');
        console.log('Grid Div:', gridDiv);

        const grid = new agGrid.Grid(gridDiv, gridOptions);
        gridOptions.api.addEventListener('firstDataRendered', function() {
            gridOptions.columnApi.autoSizeColumn('data_entry');
        });
        const columnDefsTwo = [{
                headerName: "Line No.",
                field: "id",
                width: 90
            },
            {
                headerName: "Data Entry",
                field: "data_entry"
            },
            {
                headerName: "Remarks",
                field: "remarks"
            }
        ]

        const rowDataTwo = @json($remarks);

        gridOptionsTwo = {
            columnDefs: columnDefsTwo,
            rowData: rowDataTwo,
            domLayout: 'autoHeight',
            defaultColDef: {
                resizable: true,
                flex: 1,
                sortable: true,
                filter: true
            },
            pagination: true,
            paginationPageSize: 10,

        };
        
        const gridDivTwo = document.getElementById('myGridTwo');
        console.log('Grid Div:', gridDivTwo);

        const gridTwo = new agGrid.Grid(gridDivTwo, gridOptionsTwo);




    });
</script>
