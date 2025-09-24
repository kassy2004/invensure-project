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
                headerName: "Email",
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
                 cellRenderer: params => {
                      const id = params.data.id;
                return `
                    <div class="flex gap-4">
                        <a  href="{{ route('users.edit', ':id') }}"
                        class=" p-2 transition duration-300 ease-in-out flex gap-1 items-center  text-gray-400  hover:text-gray-700">
                           
                            <span class="text-xs">Edit</span>
                        </a>
                        <button   onclick="document.getElementById('my_modal_${id}').showModal()" 
                        class="bg-red-500 p-2 rounded-lg hover:bg-red-400 transition duration-300 ease-in-out flex gap-1 items-center"
                        >
                            <x-lucide-trash class="h-4 w-4 text-white"/>
                        </button>
                        
                      
                    </div>
                    <dialog id="my_modal_${id}" class="modal  modal-bottom sm:modal-middle">
                        <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                            <h3 class="font-bold text-lg">Remove User</h3>
                            <p class="py-4">Are you sure you want to remove <b>${params.data.name}</b>?</p>

                            <div class="modal-action">
                                <div class="flex items-center gap-3">
                                    <form method="dialog">
                                        <button class="text-gray-400 px-4">Cancel</button>
                                    </form>
                                      <form method="POST" action="{{ route('users.destroy', ':id') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 transition duration-300 ease-in-out px-4 text-white rounded-lg">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </dialog>
                    `.replace(':id', id);
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
    
    setTimeout(() => {
        const alertBox = document.getElementById('alert');
        if (alertBox) {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500); // remove after fade-out
        }
    }, 5000);
</script>
