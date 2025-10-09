<div class="p-4 lg:p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
    <div class=" mb-5 flex gap-5 items-center">
        <h1 class="text-lg font-semibold text-zinc-900">
            Outgoing
        </h1>


    </div>

    <div class="flex gap-2 mb-5">

        <label class="input bg-transparent border border-zinc-300 rounded-lg">
            <x-lucide-search class="h-4 w-4 text-gray-400 " />
            <input id="outgoing-search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

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
                {{-- <ul
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
                </ul> --}}

            </details>
        </div>

    </div>




    <div id="outgoingGrid" class="ag-theme-alpine"></div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('outgoing-search-box').addEventListener('input', function() {
            outgoingGridOptions.api.setQuickFilter(this.value);
        });
        const outgoingColumnDefs = [{
                headerName: "Line No.",
                field: "id",
                pinned: 'left'
            },
            {
                headerName: "Transaction Date",
                field: "transaction_date"
            },
            {
                headerName: "Customer",
                field: "customer"
            },
            {
                headerName: "CM Code",
                field: "cm_code"
            },
            {
                headerName: "Item Code",
                field: "item_code"
            },
            {
                headerName: "Description",
                field: "description"
            },
            {
                headerName: "SKU Description",
                field: "sku_description"
            },
            {
                headerName: "Primary Packaging",
                field: "primary_packaging"
            },
            {
                headerName: "Secondary Packaging",
                field: "secondary_packaging"
            },
            {
                headerName: "CM Category",
                field: "cm_category"
            },
            {
                headerName: "Product Category",
                field: "product_category"
            },
            {
                headerName: "Variant",
                field: "variant"
            },
            {
                headerName: "Production Date",
                field: "production"
            },
            {
                headerName: "Quantity",
                field: "quantity"
            },
            {
                headerName: "Kilogram",
                field: "kilogram"
            },
            {
                headerName: "Remarks",
                field: "remarks"
            },
            {
                headerName: "Created At",
                field: "created_at"
            },
        ];

        const outogingRowData = JSON.parse('{!! $outogingJson !!}');
        const outgoingGridOptions = {
            columnDefs: outgoingColumnDefs,
            rowData: outogingRowData,
            domLayout: 'autoHeight',
            defaultColDef: {
                resizable: true,
                sortable: true,
                filter: true
            },

            pagination: true,
            paginationPageSize: 10,


        };
        const outgoingGridDiv = document.getElementById('outgoingGrid');
        console.log('Outgoing Grid Div:', outgoingGridDiv);

        const outgoingGrid = new agGrid.Grid(outgoingGridDiv, outgoingGridOptions);

        outgoingGridOptions.api.addEventListener('firstDataRendered', function() {

            outgoingGridOptions.columnApi.getAllColumns().forEach(col => {
                const colId = col.getColId();
                const width = outgoingGridOptions.columnApi.getColumnState().find(c => c
                    .colId === colId).width;
                console.log(`Column ${colId}: ${width}px`);
            });
        });


    });
</script>
