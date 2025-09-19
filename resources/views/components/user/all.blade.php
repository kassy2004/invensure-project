<div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5 w-full">

    <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
        <h1 class="text-xl text-gray-800 font-semibold">User Directory</h1>
        <p class="text-sm text-gray-500">Manages all users across the platform</p>

        <div class="mt-5">

            <div id="usersGrid" class="ag-theme-alpine bg-zinc-300"></div>

        </div>
    </div>



</div>

<script>
    let gridUsersOptions;

    document.addEventListener('DOMContentLoaded', function() {
        const columnUsersDefs = [{
                headerName: "ID",
                field: "id",
                pinned: 'left',
                width: 82
            },
            {
                headerName: "Name",
                field: "name",

            },
            {
                headerName: "Email Name",
                field: "email"
            },
            {
                headerName: "Role",
                field: "role"
            },

            {
                headerName: "Date Created",
                field: "created_at"
            },
            {
                headerName: "Actions",
                field: "actions",
                pinned: 'right',
                cellStyle: { display: 'flex', justifyContent: 'center',alignItems: 'center' },
                // headerClass: 'ag-center-cols-header',
                 cellRenderer: function(params) {
                return `
                    <button class="bg-red-500 p-2 rounded-lg hover:bg-red-400 transition duration-300 ease-in-out flex gap-1 items-center"
                       >
                        <x-lucide-trash class="h-4 w-4 text-white"/>
                       <span class="text-xs text-white">Remove</span>
                    </button>
                `;
            }
            },
           
        ];
        const rowUsersData = @json($users);

        console.log('Audit JSON:', rowUsersData);
        gridUsersOptions = {
            columnDefs: columnUsersDefs,
            rowData: rowUsersData,
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


        const usersGrid = document.getElementById('usersGrid');
        console.log('Grid Div:', usersGrid);

        const gridUser = new agGrid.Grid(usersGrid, gridUsersOptions);




    });
</script>
