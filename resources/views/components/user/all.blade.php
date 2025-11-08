<div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5 w-full">

    <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
        <h1 class="text-xl text-gray-800 font-semibold">User Directory</h1>
        <p class="text-sm text-gray-500">Manages all users across the platform</p>

        <div class="mt-5">

            <div id="usersGrid" class="ag-theme-alpine bg-zinc-300"></div>

        </div>

        <div class="mt-10">
            <h1 class="text-xl text-gray-800 font-semibold">Pending Role</h1>
            <p class="text-sm text-gray-500">Manage all pending role</p>

            <div class="mt-5">

                <div id="roleGrid" class="ag-theme-alpine bg-zinc-300"></div>

            </div>
        </div>
    </div>



</div>

<script>
    let gridUsersOptions;
    let gridRoleOptions;
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
                cellStyle: {
                    display: 'flex',
                    justifyContent: 'center',
                    alignItems: 'center'
                },
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

        const gridUsers = new agGrid.Grid(usersGrid, gridUsersOptions);





        const columnRoleDefs = [{
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
                field: "role",

                cellStyle: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    overflow: 'visible' // important fix!
                },

                cellRenderer: params => {
                    const currentRole = params.value || '';
                    const id = params.data.id;

                    // DaisyUI Select Dropdown
                    return `
                    
                        <div class="flex items-center">
                            <select id="role-select-${id}"
                                class="select  w-full border border-gray-300 bg-white focus:bg-white focus:border-gray-300 text-gray-700 flex items-center text-xs cursor-pointer"
                               
                            >
                                <option class="bg-white text-gray-700 text-xs" disabled selected>Assign role</option>
                               
                                <option class="bg-white text-gray-700" value="customer" ${currentRole === 'customer' ? 'selected' : ''}>Customer</option>
                                <option class="bg-white text-gray-700" value="logistics_coordinator" ${currentRole === 'logistics_coordinator' ? 'selected' : ''}>Logistics Coordinator</option>
                                  <option class="bg-white text-gray-700" value="inventory_manager" ${currentRole === 'inventory_manager' ? 'selected' : ''}>Inventory Manager</option>
                                   <option class="bg-white text-gray-700" value="admin" ${currentRole === 'admin' ? 'selected' : ''}>Admin</option>
                                  
                            </select>
                        </div>
                        `;
                }
            },

            {
                headerName: "Date Created",
                field: "created_at"
            },
            {
                headerName: "Actions",
                field: "actions",
                pinned: 'right',
                cellStyle: {
                    display: 'flex',
                    justifyContent: 'center',
                    alignItems: 'center'
                },
                // headerClass: 'ag-center-cols-header',
                cellRenderer: params => {
                    const id = params.data.id;
                    return `
                    <div class="flex gap-4">
                      
                        <button   onclick="submitRole('${id}')"
                        class="bg-green-500 p-2 rounded-lg hover:bg-green-400 transition duration-300 ease-in-out flex gap-1 items-center"
                        >
                            <span class="text-xs text-white">Apply</span>
                           
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
        const rowRoleData = @json($usersRole);


        gridRoleOptions = {
            columnDefs: columnRoleDefs,
            rowData: rowRoleData,
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


        const roleGrid = document.getElementById('roleGrid');
        console.log('Grid Div:', roleGrid);

        const gridUser = new agGrid.Grid(roleGrid, gridRoleOptions);


    });

    setTimeout(() => {
        const alertBox = document.getElementById('alert');
        if (alertBox) {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500); // remove after fade-out
        }
    }, 5000);


    function submitRole(userId) {
    const select = document.getElementById(`role-select-${userId}`);
    const selectedRole = select.value;
    console.log(selectedRole);
    if (!selectedRole) {
        alert('Please select a role first.');
        return;
    }

    // Create a form dynamically and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/users/${userId}/update-role`;

    // CSRF token for Laravel
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrf);

    // Role input
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'role';
    input.value = selectedRole;
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
}

</script>
