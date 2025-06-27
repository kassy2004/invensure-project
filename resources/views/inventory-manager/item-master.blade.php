<x-app-layout>
    <style>
        .updating-row {
            background-color: #fef3c7 !important;
            opacity: 0.7;
        }

        .ag-row-selected {
            background-color: #dbeafe !important;
        }
    </style>
    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Item Master</h1>
                        <h4 class="text-zinc-700">Manage your item master</h4>
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

                {{-- Input form --}}
                <dialog id="my_modal_5" class="modal  modal-bottom sm:modal-middle">
                    <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                        <form method="dialog">
                            <button
                                class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
                        </form>
                        <h3 class="text-lg font-bold text-zinc-900">Add item to Item Master</h3>



                        <form method="POST" action="{{ route('item-master.add') }}" id="addItemForm">
                            @csrf
                            <div class="flex flex-col gap-5 mt-5">

                                <div class="flex flex-col justify-between">
                                    <legend class="fieldset-legend text-zinc-600 mb-2">Item Details</legend>
                                    <div class="flex flex-col gap-2">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Item</legend>
                                            <input type="text" name="item" id="item"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                required readonly placeholder="auto-generated" />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">New MRP Code</legend>
                                            <input type="text" name="new_mrp_code" id="new_mrp_code"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="auto-generated" required readonly />

                                        </fieldset>
                                        <div class="flex justify-between gap-4">
                                            <fieldset class="fieldset">
                                                <legend class="fieldset-legend text-zinc-500">Item Group</legend>
                                                <input type="text" name="item_group"
                                                    class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                    placeholder="Enter item code" required />

                                            </fieldset>
                                            <fieldset class="fieldset">
                                                <legend class="fieldset-legend text-zinc-500">Abbreviation</legend>
                                                <input type="text" name="abbrev"
                                                    class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                    placeholder="e.g. DC" required />

                                            </fieldset>
                                        </div>

                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500 ">Variant</legend>
                                            <input type="text" name="variant"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Enter variant" required />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Kilogram/Tray</legend>
                                            <input type="text" name="kilogram_tray"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="0.00" required />

                                        </fieldset>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600 mb-2">Categorization</legend>
                                    <div class="flex gap-5">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Category 1</legend>
                                            <input type="text" name="category"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Off size" required />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Category 2</legend>
                                            <input type="text" name="category_2"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Neck on" required />

                                        </fieldset>
                                    </div>
                                    <div>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Class</legend>
                                            <input type="text" name="class"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="A" required />

                                        </fieldset>




                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600 mb-2">Packaging Information</legend>
                                    <div class="flex gap-5">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Primary Packaging</legend>
                                            <input type="text" name="primary_packaging"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Sunny Pack - Spring" required />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">Secondary Packaging</legend>
                                            <input type="text" name="secondary_packaging"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Galantina Bag" required />

                                        </fieldset>
                                    </div>
                                    <div>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-500">FG Description - Packaging
                                            </legend>
                                            <input type="text" name="fg_packaging"
                                                class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                                placeholder="Final description of packaging" required />

                                        </fieldset>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600 mb-2">Expiration & Shelf Life</legend>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-500">Expiration Stage</legend>
                                        <input type="text" name="expiration_stage"
                                            class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                            placeholder="0" required />

                                    </fieldset>


                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600 mb-2">Descriptions</legend>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-500">SKU Description</legend>
                                        <input type="text" name="sku"
                                            class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                            placeholder="Whole chicken" required />

                                    </fieldset>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-500">FG Description</legend>
                                        <input type="text" name="fg"
                                            class="border border-gray-300 focus:ring-0 px-3 py-2 rounded-md text-gray-800 focus:outline-none  focus:text-orange-600 focus:border-orange-500 w-full"
                                            placeholder="Whole chicken off size A 0.5" required />

                                    </fieldset>


                                </div>

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


                    <div class="p-10 bg-zinc-50  h-auto mt-10 rounded-lg border border-zinc-300">


                        <div class="flex gap-2 mb-5">

                            <label class="input bg-transparent border border-zinc-300 rounded-lg">
                                <x-lucide-search class="h-4 w-4 text-gray-400 " />
                                <input id="search-box" type="search" class="grow text-zinc-600"
                                    placeholder="Search" />

                            </label>

                            <div
                                class=" h-10 px-3 flex rounded-lg text-zinc-900 border border-zinc-300 items-center justify-center text-center hover:border-zinc-400 transition duration-200 ease-in-out cursor-pointer">
                                <x-lucide-filter class="h-4 w-4" />
                            </div>
                            <div>
                                <details class="dropdown">
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
                                                onchange="toggleSection(this, ['id','item','new_mrp_code','item_group','abbrev'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('id', this)" checked> Line No.</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('item', this)" checked> Item</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('new_mrp_code', this)" checked> MRP
                                                Code</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('item_group', this)" checked> Item
                                                Group</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('abbrev', this)" checked> Abbrev</label>
                                        </li>

                                        <hr class="my-2">

                                        <!-- Categorization -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Categorization
                                            <input type="checkbox"
                                                onchange="toggleSection(this, ['category','category_2','class','expiration_stage'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('category', this)" checked> Category</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('category_2', this)" checked> Category
                                                2</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('class', this)" checked> Class</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('expiration_stage', this)" checked>
                                                Expiration Stage</label></li>

                                        <hr class="my-2">

                                        <!-- Packaging -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Packaging
                                            <input type="checkbox"
                                                onchange="toggleSection(this, ['primary_packaging','secondary_packaging'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('primary_packaging', this)" checked> Primary
                                                Packaging</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('secondary_packaging', this)" checked>
                                                Secondary Packaging</label></li>

                                        <hr class="my-2">

                                        <!-- Product -->
                                        <li
                                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between">
                                            Product
                                            <input type="checkbox"
                                                onchange="toggleSection(this, ['variant','kilogram_tray','sku','fg','fg_packaging'])"
                                                checked>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('variant', this)" checked> Variant</label>
                                        </li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('kilogram_tray', this)" checked>
                                                Kilogram/Tray</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('sku', this)" checked> SKU</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('fg', this)" checked> FG</label></li>
                                        <li><label class="text-zinc-900"><input type="checkbox"
                                                    onchange="toggleColumn('fg_packaging', this)" checked> FG
                                                Packaging</label></li>

                                    </ul>
                                </details>

                            </div>

                        </div>




                        <div id="myGrid" class="ag-theme-alpine bg-zinc-300"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                        headerName: "Item",
                        field: "item",
                        editable: true
                    },
                    {
                        headerName: "MRP Code",
                        field: "new_mrp_code"
                    },
                    {
                        headerName: "Item Group",
                        field: "item_group"
                    },
                    {
                        headerName: "Abbrev",
                        field: "abbrev"
                    }
                ]
            },
            {
                headerName: "Categorization",
                children: [{
                        headerName: "Category",
                        field: "category"
                    },
                    {
                        headerName: "Category 2",
                        field: "category_2"
                    },
                    {
                        headerName: "Class",
                        field: "class"
                    },
                    {
                        headerName: "Expiration Stage",
                        field: "expiration_stage"
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
                headerName: "Product",
                children: [{
                        headerName: "Variant",
                        field: "variant"
                    },
                    {
                        headerName: "Kilogram/Tray",
                        field: "kilogram_tray"
                    },
                    {
                        headerName: "SKU",
                        field: "sku"
                    },
                    {
                        headerName: "FG",
                        field: "fg"
                    },
                    {
                        headerName: "FG Packaging",
                        field: "fg_packaging"
                    }
                ]
            }
        ];

        const rowData = JSON.parse('{!! $itemJson !!}');

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

        // Function to handle row updates
        function updateRowData(rowData) {
            console.log('Updating row data:', rowData);

            // Mark row as updating
            rowData.isUpdating = true;
            gridOptions.api.refreshCells({
                force: true
            });

            fetch(`/items/${rowData.id}/update`, {
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

        // Function to show notifications
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


        const itemGroupCounts = @json($count->pluck('count', 'item_group'));

        const itemInput = document.getElementById("item");
        const newMrpCodeInput = document.getElementById("new_mrp_code");

        const classInput = document.querySelector("[name='class']");
        const kiloInput = document.querySelector("[name='kilogram_tray']");
        const primaryPack = document.querySelector("[name='primary_packaging']");
        const secondaryPack = document.querySelector("[name='secondary_packaging']");
        const abbrev = document.querySelector("[name='abbrev']");
        const categoryTwo = document.querySelector("[name='category_2']");
        const itemGroup = document.querySelector("[name='item_group']");
        let currentRowNumber = '0001';

        function getAbbreviation(text) {
            return text
                .split(/\s+/) // split by space
                .filter(word => word.length > 0)
                .map(word => word[0].toUpperCase()) // get first letter
                .join('');
        }

        function updateRowNumberFromGroup(group) {
            const baseCount = itemGroupCounts[group] || 0;
            currentRowNumber = String(baseCount + 1).padStart(4, "0");
        }

        function updateFields() {
            const _class = classInput.value.trim();
            const _kg = kiloInput.value.trim();
            const _pri = primaryPack.value.trim();
            const _sec = secondaryPack.value.trim();
            const _cat = categoryTwo.value.trim();
            console.log(_cat);
            console.log(_pri);

            const _abbrev = abbrev.value.trim();
            const _group = itemGroup.value.trim();
            updateRowNumberFromGroup(_abbrev);
            // First column: "FZ" + class + " " + kilo + "-" + first letters + "GB"
            // const firstCharPri = _pri.charAt(0) || "";
            // const seventhCharPri = _pri.charAt(6) || "";
            // const firstCharSec = _sec.charAt(0) || "";
            // const sixthCharSec = _sec.charAt(5) || "";

            // const firstCharCat = _cat.charAt(0) || "";
            // const sixthCharCat = _cat.charAt(5) || "";

            const primaryAbbrev = getAbbreviation(_pri); // e.g., "Sunny Pack" => "SP"
            const secondaryAbbrev = getAbbreviation(_sec);
            const categoryAbbrev = getAbbreviation(_cat);
            console.log(categoryAbbrev);
            itemInput.value = `FZ${_class} ${_kg}-${primaryAbbrev}${categoryAbbrev}${secondaryAbbrev}`;

            // Second column (e.g., "DC_FZSP0998GBB0.9NO")
            // Example only – you may want to replace the row number logic
            const rowNumber = 999; // change dynamically if needed
            const paddedRow = String(rowNumber).padStart(4, "0");

            newMrpCodeInput.value =
                `${_abbrev}_FZ${primaryAbbrev}${currentRowNumber}${secondaryAbbrev}${_class}${_kg}${categoryAbbrev}`;
        }
        // Listen for key inputs on relevant fields
        [classInput, kiloInput, primaryPack, secondaryPack, abbrev, itemGroup, categoryTwo].forEach(input => {
            input.addEventListener("input", updateFields);
        });
    });
</script>
