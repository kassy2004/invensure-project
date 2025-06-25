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
                        <button
                            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                            <x-lucide-plus class="h-4 w-4" />
                            Add Item</button>

                    </div>



                </div>


                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">


                    <div class="p-10 bg-zinc-50  h-auto mt-10 rounded-lg border border-zinc-300">


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
                                                    onchange="toggleColumn('abbrev', this)" checked> Abbrev</label></li>

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
                headerName: "Basic Info",
                children: [{
                        headerName: "Line No.",
                        field: "id",

                    },
                    {
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
            gridOptions.columnApi.autoSizeColumn('item');
        });

        // Function to handle row updates
        function updateRowData(rowData) {
            console.log('Updating row data:', rowData);
            
            // Mark row as updating
            rowData.isUpdating = true;
            gridOptions.api.refreshCells({ force: true });
            
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
                    gridOptions.api.refreshCells({ force: true });
                } else {
                    showNotification('Failed to update item: ' + data.message, 'error');
                    // Remove updating state
                    rowData.isUpdating = false;
                    gridOptions.api.refreshCells({ force: true });
                }
            })
            .catch((err) => {
                console.error("Update failed:", err);
                showNotification('Error updating item. Please try again.', 'error');
                // Remove updating state
                rowData.isUpdating = false;
                gridOptions.api.refreshCells({ force: true });
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
    });
</script>
