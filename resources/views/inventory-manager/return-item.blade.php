<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Rejects and Returns</h1>

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



                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">


                    <div class=" p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
                        <div class="flex gap-2 mb-5">
                            <label class="input bg-transparent border border-zinc-300 rounded-lg">
                                <x-lucide-search class="h-4 w-4 text-gray-400 " />
                                <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

                            </label>

                            <div
                                class=" h-10 px-3 flex rounded-lg text-zinc-900 border border-zinc-300 items-center justify-center text-center hover:border-zinc-400 transition duration-200 ease-in-out cursor-pointer">
                                <x-lucide-filter class="h-4 w-4" />
                            </div>
                        </div>
                        <div id="returnGrid" class="ag-theme-alpine bg-zinc-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let returnGridOptions;
    document.getElementById('search-box').addEventListener('input', function() {
        returnGridOptions.api.setQuickFilter(this.value);
    });


    document.addEventListener('DOMContentLoaded', function() {
        const returnColumnDefs = [{
                headerName: "ID",
                field: "id",
                pinned: 'left',
                width: 98,
            },
            {
                headerName: "Customer",
                field: "customer",
            },
            {
                headerName: "Prod. Category",
                field: "prod_category",
            },
            {
                headerName: "Production Date",
                field: "production_date",
            },
            {
                headerName: "Quantity",
                field: "qty",
            },
            {
                headerName: "Kilogram",
                field: "kilogram",
            },
            {
                headerName: "Description",
                field: "description",
            },
            {
                headerName: "Reason for Return",
                field: "reason_for_return",
            },
            {
                headerName: "Pod Number",
                field: "pod_number",
            },
            {
                headerName: "Warehouse",
                field: "warehouse",
            },
            {
                headerName: "Request Date",
                field: "created_at",
            },
            {
                headerName: "Actions",
                field: "actions",
                pinned: 'right',
                headerClass: 'ag-center-cols-header',
                cellRenderer: params => {
                    const id = params.data.id;

                    return `
            <div class="flex gap-1 items-center h-full">
                <button onclick="handleView(${id})" class="border border-gray-400 p-2 rounded-lg hover:bg-gray-300 transition duration-300 ease-in-out" title="View">
                    <x-lucide-file-text class="h-5 w-5 text-zinc-500"/>
                </button>
                <button onclick="handleView(${id})" class="bg-emerald-500 p-2 rounded-lg hover:bg-emerald-400 transition duration-300 ease-in-out" title="Approve">
                    <x-lucide-stamp class="h-5 w-5 text-white"/>
                </button>
                <button onclick="handleView(${id})" class="bg-red-500 p-2 rounded-lg hover:bg-red-400 transition duration-300 ease-in-out" title="Reject">
                    <x-lucide-ban class="h-5 w-5 text-white"/>
                </button>
            </div>
        `;
                },
            },

        ];
        const returnRowData = [{
                id: 1,
                customer: "Juan Dela Cruz",
                prod_category: "Dressed Chicken",
                production_date: "2025-06-25",
                qty: 25,
                kilogram: 18.5,
                description: "Returned due to spoilage",
                reason_for_return: "Spoiled",
                pod_number: 100123,
                warehouse: "PCSI",
                created_at: "2025-06-28",
            },
            {
                id: 2,
                customer: "Maria Santos",
                prod_category: "Fillets",
                production_date: "2025-06-20",
                qty: 15,
                kilogram: 10.2,
                description: "Returned for wrong item",
                reason_for_return: "Wrong item delivered",
                pod_number: 100124,
                warehouse: "JFPC",
                created_at: "2025-06-28",
            },
            {
                id: 3,
                customer: "Carlos Reyes",
                prod_category: "Value Added",
                production_date: "2025-06-15",
                qty: 8,
                kilogram: 6.0,
                description: "Damaged packaging",
                reason_for_return: "Packaging damage",
                pod_number: 100125,
                warehouse: "PCSI",
                created_at: "2025-06-27",
            }
        ];

        returnGridOptions = {
            columnDefs: returnColumnDefs,
            rowData: returnRowData,
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


        const returnGridDiv = document.getElementById('returnGrid');
        console.log('Grid Div:', returnGridDiv);

        const returnGrid = new agGrid.Grid(returnGridDiv, returnGridOptions);
        returnGridOptions.api.addEventListener('firstDataRendered', function() {

            const allColumnIds = [];
            returnGridOptions.columnApi.getAllColumns().forEach(col => {
                allColumnIds.push(col.getColId());
            });
            returnGridOptions.columnApi.autoSizeColumns(allColumnIds);
        });



    });
</script>
