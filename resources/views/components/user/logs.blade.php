<div class="p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-full">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl text-gray-800 font-semibold">Activity Logs</h1>
            <p class="text-sm text-gray-500">Track user management activities</p>
        </div>
        <button  onclick="window.location='{{ url('/export-audits') }}'"
            class="px-4 py-2 flex items-center gap-3 rounded-md text-zinc-900 text-sm border border-zinc-300 hover:border-zinc-400 transition duration-200 ease-in-out"><x-lucide-download
                class="h-4 w-4" />Export</button>
    </div>

    <div class="flex mt-5 gap-3">

        <label class="input bg-transparent border border-zinc-300 rounded-lg">
            <x-lucide-search class="h-4 w-4 text-gray-400 " />
            <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

        </label>


        <div>
            <details class="dropdown ">
                <summary
                    class="btn h-10 rounded-lg bg-transparent text-zinc-800 font-normal border-zinc-300 shadow-none hover:border-zinc-400 transition duration-200 ease-in-out">
                    Role
                    <x-lucide-chevron-down class="h-4 w-4" />

                </summary>
                <ul
                    class="dropdown-content flex flex-col gap-2 px-3 border border-zinc-300 bg-gray-100 rounded-box z-10 w-64 p-2 overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap mt-2 pb-5">
                    <li class="text-xs text-zinc-500 uppercase font-semibold px-1 mt-3">Filter by Role</li>

                    <li class="text-xs text-zinc-500  font-semibold px-1 flex justify-between mt-3">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" value="admin" onchange="filterByRoles()" class="role-filter"
                                checked>
                            Admin
                        </label>
                    </li>
                    <li class="text-xs text-zinc-500  font-semibold px-1 flex justify-between mt-3">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" value="logistics_coordinator" onchange="filterByRoles()"
                                class="role-filter" checked>
                            Logistic Coordinator
                        </label>
                    </li>
                    <li class="text-xs text-zinc-500  font-semibold px-1 flex justify-between mt-3">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" value="customer" onchange="filterByRoles()" class="role-filter"
                                checked>
                            Customer
                        </label>
                    </li>
                    <li class="text-xs text-zinc-500  font-semibold px-1 flex justify-between mt-3">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" value="inventory_manager" onchange="filterByRoles()"
                                class="role-filter" checked>
                            Inventory Manager
                        </label>
                    </li>
                </ul>
            </details>
        </div>
    </div>
    <div class="mt-5">
        <div id="logsGrid" class="ag-theme-alpine bg-zinc-300"></div>
    </div>
</div>





<script>
    function filterByRoles() {
        const selectedRoles = Array.from(document.querySelectorAll('.role-filter:checked'))
            .map(cb => cb.value);

        gridAuditOptions.api.setQuickFilter(""); // Reset

        gridAuditOptions.api.setFilterModel(null); // Clear existing filters

        gridAuditOptions.api.onFilterChanged();

        gridAuditOptions.api.setRowData(
            @json($audit).filter(row => selectedRoles.includes(row.user_role))
        );
    }
    let gridAuditOptions;

    document.addEventListener('DOMContentLoaded', function() {
        const columnDefs = [{
                headerName: "ID",
                field: "id",
                pinned: 'left',
                width: 82
            },
            {
                headerName: "Event",
                field: "event",

            },
            {
                headerName: "User Name",
                field: "user_name"
            },
            {
                headerName: "Role",
                field: "user_role"
            },
            {
                headerName: "URL",
                field: "url"
            },
            {
                headerName: "IP Address",
                field: "ip_address"
            },
            {
                headerName: "Date",
                field: "created_at"
            },
        ];
        const rowData = @json($audit);

        console.log('Audit JSON:', rowData);
        gridAuditOptions = {
            columnDefs: columnDefs,
            rowData: rowData,
            domLayout: 'autoHeight',
            defaultColDef: {
                resizable: true,
                flex: 1,
                sortable: true,
                filter: true
            },
            // onGridReady: function(params) {
            //     gridAuditOptions.api = params.api;
            //     gridAuditOptions.columnApi = params.columnApi;
            //     document.querySelectorAll('input[type="checkbox"][onchange^="toggleColumn"]').forEach(
            //         cb => {
            //             const colKey = cb.getAttribute('onchange').match(/'([^']+)'/)[1];
            //             gridAuditOptions.columnApi.setColumnVisible(colKey, cb.checked);
            //         });

            // },
            pagination: true,
            paginationPageSize: 10,

        };


        const logsGrid = document.getElementById('logsGrid');
        console.log('Grid Div:', logsGrid);

        const grid = new agGrid.Grid(logsGrid, gridAuditOptions);
        // gridOptions.api.addEventListener('firstDataRendered', function() {

        //     const allColumnIds = [];
        //     gridOptions.columnApi.getAllColumns().forEach(col => {
        //         allColumnIds.push(col.getColId());
        //     });
        //     gridOptions.columnApi.autoSizeColumns(allColumnIds);
        // });



    });
</script>
