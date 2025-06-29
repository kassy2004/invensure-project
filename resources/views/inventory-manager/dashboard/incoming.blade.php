<div class=" p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
    <div class=" mb-5 flex gap-5 items-center">
        <h1 class="text-lg font-semibold text-zinc-900">
            Incoming
        </h1>


    </div>

    <div class="flex gap-2 mb-5">

        <label class="input bg-transparent border border-zinc-300 rounded-lg">
            <x-lucide-search class="h-4 w-4 text-gray-400 " />
            <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

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
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3">
                        Basic Info
                        <input type="checkbox" onchange="toggleSection(this, ['id','data_entry','item_group'])" checked>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('id', this) "checked>
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
                                checked> Class</label></li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('sku', this) "
                                checked> SKU Description</label>
                    </li>
                    <li><label class="text-zinc-900"><input type="checkbox" onchange="toggleColumn('fg', this) "
                                checked> FG Description</label></li>

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
                            checked></li>
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
                flex: 1,
                sortable: true,
                filter: true
            },
            onGridReady: function(params) {
                gridOptions.api = params.api;
                gridOptions.columnApi = params.columnApi;
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

            const allColumnIds = [];
            gridOptions.columnApi.getAllColumns().forEach(col => {
                allColumnIds.push(col.getColId());
            });
            gridOptions.columnApi.autoSizeColumns(allColumnIds);
        });



    });
</script>
