<div class="p-4 lg:p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
    <div class=" mb-5 flex gap-5 items-center justify-between">
        <h1 class="text-lg font-semibold text-zinc-900">
            Incoming
        </h1>
        <button onclick="my_modal_6.showModal()"
            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
            <x-lucide-truck class="h-4 w-4" />
            Ship Item</button>
    </div>
    <dialog id="my_modal_6" class="modal  modal-bottom sm:modal-middle ">
        <div class="modal-box bg-zinc-50 border border-zinc-300 h-128">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
            </form>
            <h3 class="text-lg font-bold text-zinc-900">Ship an item</h3>

            <form method="POST" action="{{ route('warehouse.inventory.ship') }}">
                @csrf

                <div class="mb-4">
                    <hr class="my-5">
                    <div>
                        <legend class="fieldset-legend text-orange-400">Item Details</legend>
                        <div x-data="{ search: '', selected: '', open: false, productionDate: '', qty: '', kilo: '' }" class="relative z-[9999]">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend text-zinc-600">Search Item</legend>


                            </fieldset>
                            <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                                placeholder="Search item..."
                                class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800" />

                            <div x-show="open"
                                class="absolute z-[9999] mt-1 w-full bg-white border border-zinc-300 rounded-md max-h-48 overflow-y-auto">
                                @foreach ($inventory as $item)
                                    <div x-show="{{ json_encode($item->item_code) }}.toLowerCase().includes(search.toLowerCase()) || 
                '{{ strtolower($item->data_entry) }}'.includes(search.toLowerCase())"
                                        @click="selected = '{{ $item->id }}';
                                        search = '{{ $item->item_code }} ({{ $item->balance_head }})';
                                        productionDate = '{{ $item->prod_date }}';
                                        document.getElementById('production_date').value = productionDate;
                                        document.getElementById('cally3').innerText = productionDate;
                                        document.getElementById('max-qty').innerText = '{{ $item->balance_head }}';
                                        document.getElementById('max-kilo').innerText = '{{ $item->balance_kilo }}';
                                        document.getElementById('quantity-input').setAttribute('max', '{{ $item->balance_head }}');
                                        document.getElementById('kilogram-input').setAttribute('max', '{{ $item->balance_kilo }}');
                                        open = false"
                                        class="px-3 py-2 cursor-pointer hover:bg-zinc-100 text-sm text-zinc-700 flex flex-col">
                                        <span>{{ $item->item_code }}</span>
                                        <span class="text-gray-500 text-xs">{{ $item->data_entry }}
                                            ({{ $item->balance_head }})
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="item_id" :value="selected" required />
                            <input type="hidden" name="warehouse_id" value="{{$warehouseId}}" required />
                        </div>

                        <div class="flex justify-between gap-4">

                            <div class="flex flex-col w-full">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Transaction Date</legend>
                                </fieldset>
                                <button type="button" popovertarget="cally-popover2"
                                    class="input input-border bg-zinc-50 border border-zinc-300 text-zinc-600 w-full cursor-pointer"
                                    id="cally2" style="anchor-name:--cally2">
                                    <x-lucide-calendar class="h-4 w-4" />
                                </button>
                                <div popover id="cally-popover2" class="dropdown bg-zinc-200 rounded-box shadow-lg"
                                    style="position-anchor:--cally2">
                                    <calendar-date class="cally  text-zinc-900 "
                                        onchange="
                        const selectedDate = this.value || this.getAttribute('value');
                        document.getElementById('transaction_date').value = selectedDate;
                        document.getElementById('cally2').innerText = selectedDate;
                        
                    ">
                                        <svg aria-label="Previous" class="fill-current size-4 text-zinc-900 "
                                            slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                        </svg>
                                        <svg aria-label="Next" class="fill-current size-4  text-zinc-900 "
                                            slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                        </svg>
                                        <calendar-month></calendar-month>
                                    </calendar-date>
                                </div>
                            </div>

                            <div class="flex flex-col w-full">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Production Date</legend>
                                </fieldset>
                                <button type="button" popovertarget="cally-popover3"
                                    class="input input-border bg-zinc-50 border border-zinc-300 text-zinc-600 w-full cursor-pointer"
                                    id="cally3" style="anchor-name:--cally3">
                                    <x-lucide-calendar class="h-4 w-4" />
                                </button>
                                <div popover id="cally-popover3" class="dropdown bg-zinc-200 rounded-box shadow-lg"
                                    style="position-anchor:--cally3">
                                    <calendar-date class="cally  text-zinc-900 "
                                        onchange="
                        const selectedDate = this.value || this.getAttribute('value');
                        document.getElementById('production_date').value = selectedDate;
                        document.getElementById('cally3').innerText = selectedDate;
                        
                    ">
                                        <svg aria-label="Previous" class="fill-current size-4 text-zinc-900 "
                                            slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                        </svg>
                                        <svg aria-label="Next" class="fill-current size-4  text-zinc-900 "
                                            slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                        </svg>
                                        <calendar-month></calendar-month>
                                    </calendar-date>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="production_date" name="production_date">
                        <input type="hidden" id="transaction_date" name="transaction_date">
                        {{-- <fieldset class="fieldset">
                            <legend class="fieldset-legend text-zinc-600">Customer</legend>
                            <input type="text" name="customer"
                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                placeholder="Customer" />

                        </fieldset> --}}
                        <div x-data="{ search: '', selected: '', customer_id: '', open: false }" class="relative z-[999]">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend text-zinc-600">Customer</legend>


                            </fieldset>
                            <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                                placeholder="Search customer..."
                                class="w-full border border-zinc-300 rounded-md px-3 py-2 text-sm text-zinc-800" />

                            <div x-show="open"
                                class="absolute z-[9999] mt-1 w-full bg-white border border-zinc-300 rounded-md max-h-48 overflow-y-auto">
                                @foreach ($customer as $customers)
                                    <div x-show="{{ json_encode($customers->business_name) }}.toLowerCase().includes(search.toLowerCase())"
                                        @click="
                                        selected = '{{ $customers->business_name }}';
                                        customer_id = '{{ $customers->id }}';
                                        search = '{{ $customers->business_name }} ({{ $customers->email }})';
                                      
                                        
                                        open = false"
                                        class="px-3 py-2 cursor-pointer hover:bg-zinc-100 text-sm text-zinc-700 flex flex-col">
                                        <span>{{ $customers->business_name }}</span>
                                        <span class="text-xs text-zinc-500">{{ $customers->email }}</span>
                                        {{-- <span class="text-gray-500 text-xs">{{ $item->data_entry }}
                                            ({{ $item->qty_head }})
                                        </span> --}}
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="customer" :value="selected" required />
                            <input type="hidden" name="customer_id" :value="customer_id" required />
                        </div>
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-zinc-600">CM Code</legend>
                            <input type="text" name="cm_code"
                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                placeholder="CMXXXXX" />

                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-zinc-600">CM Category</legend>
                            <input type="text" name="cm_category"
                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                placeholder="Wholesale" />

                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend text-zinc-600">Description</legend>
                            <input type="text" name="description"
                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                placeholder="Description" required />

                        </fieldset>

                    </div>
                    <hr class="my-5">
                    <div>
                        <legend class="fieldset-legend text-orange-400">Issuance</legend>
                        <div class="flex justify-between gap-4">

                            <fieldset class="fieldset">
                                <div class="flex gap-2">
                                    <legend class="fieldset-legend text-zinc-600">Quantity |</legend>
                                    <legend class="fieldset-legend text-red-400 text-xs">Max: <span
                                            id="max-qty"></span></legend>
                                </div>
                                <input type="number" name="quantity" id="quantity-input"
                                    class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                    placeholder="0" required
                                    oninput="if (this.max) this.value = Math.min(this.value, this.max);" />

                            </fieldset>
                            <fieldset class="fieldset">
                                <div class="flex gap-2">
                                    <legend class="fieldset-legend text-zinc-600">Kilogram |</legend>
                                    <legend class="fieldset-legend text-red-400 text-xs">Max: <span
                                            id="max-kilo"></span></legend>
                                </div>
                                <input type="text" name="kilogram" id="kilogram-input"
                                    class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                    placeholder="0.00" required
                                    oninput="if (this.max) this.value = Math.min(this.value, this.max);" />

                            </fieldset>
                        </div>

                    </div>

                    <hr class="my-5">


                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-zinc-600">Remarks</legend>
                        <input type="text" name="remarks"
                            class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                            placeholder="optional" />
                        <p class="label text-gray-500">Optional</p>

                    </fieldset>

                </div>

                <hr class="my-5">
                <div class="flex justify-end gap-5">

                    <button type="button" onclick="document.getElementById('my_modal_6').close()"
                        class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                    <button type="submit"
                        class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out">Submit
                        Shipment</button>
                </div>

            </form>

        </div>
    </dialog>
    <div class="flex gap-2 mb-5">

        <label class="input bg-transparent border border-zinc-300 rounded-lg">
            <x-lucide-search class="h-4 w-4 text-gray-400 " />
            <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

        </label>
        {{-- <input type="text" id="quickFilterInput"
        placeholder="Search by ID, borrower, or equipment..."
        class="h-10 rounded-lg bg-transparent  text-gray-300 border border-zinc-300  w-2/8"> --}}
        <div class="dropdown dropdown-end">
            {{-- <div  class="btn m-1">Click ⬇️</div> --}}
            <div tabindex="0" role="button"
                class=" h-10 px-3 flex rounded-lg text-zinc-900 border border-zinc-300 items-center justify-center text-center hover:border-zinc-400 transition duration-200 ease-in-out cursor-pointer">
                <x-lucide-filter class="h-4 w-4" />
            </div>
            <ul tabindex="0"
                class="filter dropdown-content menu bg-gray-100 border border-zinc-300 text-zinc-900 rounded-box z-1 w-52 p-2 shadow-sm">
                <li class="hover:bg-gray-200 rounded-md"><a href="#" data-filter="all">All</a></li>
                <li class="hover:bg-gray-200 rounded-md"><a href="#" data-filter="return">Returns</a></li>
            </ul>
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
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3">
                        Basic Info
                        <input type="checkbox" onchange="toggleSection(this, ['id','data_entry','item_group'])"
                            checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('id', this) "checked>
                            Line</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('data_entry', this) "checked> Data
                            Entry</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('item_group', this) "checked> Item Group</label>
                    </li>
                    <hr class="my-2">
                    <!-- Product Details -->
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Product Details
                        <input type="checkbox"
                            onchange="toggleSection(this, ['sku','fg','kilogram_tray','variant','class'])" checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('variant', this) "checked> Variant</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('kilogram_tray', this) "checked>
                            Kilogram/Tray</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('class', this) "
                                checked>
                            Class</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('sku', this) "
                                checked>
                            SKU Description</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('fg', this) "
                                checked>
                            FG
                            Description</label></li>

                    <hr class="my-2">
                    <!-- Packaging -->

                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Packaging <input type="checkbox"
                            onchange="toggleSection(this, ['primary_packaging','secondary_packaging'])" checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('primary_packaging', this) "checked> Primary
                            Packaging</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('secondary_packaging', this) "checked> Secondary
                            Packaging</label></li>
                    <hr class="my-2">

                    <!-- Inventory -->
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Inventory <input type="checkbox"
                            onchange="toggleSection(this, ['inventory_head','inventory_kilo'])" checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('inventory_head', this) "checked>
                            Head/Pack</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('inventory_kilo', this) "checked>
                            Kilogram</label></li>

                    <hr class="my-2">

                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Balance <input type="checkbox" onchange="toggleSection(this, ['balance_head','balance_kilo'])"
                            checked>
                    </li>

                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('balance_head', this) "checked>
                            Head/Pack</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('balance_kilo', this) "checked checked>Kilogram</label>
                    </li>
                    <hr class="my-2">


                    <!-- Movement -->
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Movement <input type="checkbox"
                            onchange="toggleSection(this, ['received_by','qty_head','qty_kilo'])" checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('received_by', this) "checked> Received by</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('qty_head', this) "checked> Qty Issued
                            (Head/Pack)</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('qty_kilo', this) "checked> Qty Issued
                            (Kilogram)</label></li>
                    <hr class="my-2">

                    <!-- Dates -->
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Dates <input type="checkbox"
                            onchange="toggleSection(this, ['prod_date','left','exp_date','date'])" checked></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('prod_date', this) "checked>
                            Prod_Date</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('left', this) "checked> Left</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('exp_date', this) "checked> Exp_Date</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('date', this) "checked> Created At</label>
                    </li>
                    <hr class="my-2">
                    <!-- Status -->
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                        Status <input type="checkbox" onchange="toggleSection(this, ['status','storage_num'])"
                            checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('status', this) "checked>Status</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox"
                                onchange="toggleColumn('storage_num', this) "checked> Storage #</label>
                    </li>
                </ul>

            </details>
        </div>

    </div>




    <div id="myGrid" class="ag-theme-alpine bg-zinc-300"></div>
</div>

<script>
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
                headerName: "Line No.",
                field: "id",
                pinned: 'left'
            },
            {
                headerName: "Basic Info",
                children: [{
                        headerName: "Data Entry",
                        field: "data_entry"
                    },
                    {
                        headerName: "Item Code",
                        field: "item_code"
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
                        field: "kilogram_tray"
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
                        field: "created_at"
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

                        field: 'return_date'

                    }
                ]
            }
        ];
        const rowData = JSON.parse('{!! $inventoryJson !!}');

        gridOptions = {
            columnDefs: columnDefs,
            rowData: rowData,
            domLayout: 'autoHeight',
            defaultColDef: {
                resizable: true,
                editable: true,
                flex: 1,
                sortable: true,
                filter: true
            },
            rowSelection: 'single',
            getRowClass: function(params) {
                if (params.data && params.data.isUpdating) {
                    return 'updating-row';
                }
                return '';
            },
            onCellValueChanged: function(event) {
                const updatedRow = event.data;
                console.log('Cell value changed:', updatedRow);
                updateRowData(updatedRow);
            },
            onGridReady: function(params) {
                gridOptions.api = params.api;
                gridOptions.columnApi = params.columnApi;
                document.querySelectorAll('input[type="checkbox"][onchange^="toggleColumn"]').forEach(
                    cb => {
                        const colKey = cb.getAttribute('onchange').match(/'([^']+)'/)[1];
                        gridOptions.columnApi.setColumnVisible(colKey, cb.checked);
                    });
                const menu = document.querySelector('.filter');
                if (menu) {
                    menu.addEventListener('click', function(e) {
                        const link = e.target.closest('a[data-filter]');
                        if (!link) return;
                        e.preventDefault();

                        const mode = link.dataset.filter;
                        const currentModel = gridOptions.api.getFilterModel() || {};

                        if (mode === 'return') {
                            // Keep other filters; add "return_date is not blank"
                            currentModel.return_date = {
                                filterType: 'text',
                                type: 'notBlank',
                            };
                            gridOptions.api.setFilterModel(currentModel);
                            gridOptions.api.onFilterChanged();
                        } else if (mode === 'all') {
                            // Keep other filters; remove only the return_date filter
                            delete currentModel.return_date;
                            // If nothing left, pass null to clear; else set the remaining model
                            gridOptions.api.setFilterModel(Object.keys(currentModel).length ?
                                currentModel : null);
                            gridOptions.api.onFilterChanged();
                        }
                    });
                }

            },
            pagination: true,
            paginationPageSize: 10,

        };


        const gridDiv = document.getElementById('myGrid');
        console.log('Grid Div:', gridDiv);

        const grid = new agGrid.Grid(gridDiv, gridOptions);
        gridOptions.api.addEventListener('firstDataRendered', function() {

            const allColumnIds = [];
            gridOptions.columnApi.getAllColumns().forEach(col => {
                allColumnIds.push(col.getColId());
            });
            gridOptions.columnApi.autoSizeColumns(allColumnIds);
        });

        function updateRowData(rowData) {
            console.log('Updating row data:', rowData);

            // Mark row as updating
            rowData.isUpdating = true;
            gridOptions.api.refreshCells({
                force: true
            });

            fetch(`/pcsi/incoming/${rowData.id}/update`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(rowData),
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Row updated:", data);
                    if (data.success) {
                        // Show success message
                        showNotification('Item updated successfully!', 'success');
                        // Remove updating state
                        rowData.isUpdating = false;
                        gridOptions.api.refreshCells({
                            force: true
                        });
                    } else {
                        showNotification('Failed to update item: ' + data.message, 'error');
                        // Remove updating state
                        rowData.isUpdating = false;
                        gridOptions.api.refreshCells({
                            force: true
                        });
                    }
                })
                .catch((err) => {
                    console.error("Update failed:", err);
                    showNotification('Error updating item. Please try again.', 'error');
                    // Remove updating state
                    rowData.isUpdating = false;
                    gridOptions.api.refreshCells({
                        force: true
                    });
                });
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }
    });
</script>
