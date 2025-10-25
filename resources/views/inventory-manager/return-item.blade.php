<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Rejects and Returns</h1>

                    </div>
                    <button
                        class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                        <x-lucide-plus class="h-4 w-4" />
                        Add Manually</button>
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


                    <div class="p-4 lg:p-10 bg-zinc-50  h-auto rounded-lg border border-zinc-300">
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
                    <dialog id="approveModal" class="modal">
                        <div class="modal-box bg-zinc-50">
                            <h3 class="text-lg font-bold text-zinc-800">Approve Return Request</h3>
                            <p class="text-zinc-600" id="approve-text">Are you sure you want to approve the return
                                request?</p>

                            <div class="text-sm mt-5 ">
                                <div class="flex gap-2 ">
                                    <span class="text-zinc-500">POD #: </span>
                                    <span id="pod" class="text-zinc-700 font-semibold ">0001</span>
                                </div>
                                <div class="flex gap-2 ">
                                    <span class="text-zinc-500">Customer: </span>
                                    <span id="customer" class="text-zinc-700 font-semibold ">Jollibee</span>
                                </div>
                                <div class="flex gap-2 ">
                                    <span class="text-zinc-500">Reason for return: </span>
                                    <span id="reason" class="text-zinc-700 font-semibold ">Hematoma</span>
                                </div>
                                <div class="flex gap-2 ">
                                    <span class="text-zinc-500">Detail Description: </span>
                                    <span id="others" class="text-zinc-700 font-semibold ">nyenye</span>
                                </div>
                                <div class="flex gap-2 ">
                                    <span class="text-zinc-500">Request Date: </span>
                                    <span id="date" class="text-zinc-700 font-semibold ">Today</span>
                                </div>
                            </div>
                           
                            <div class="flex justify-end gap-3 mt-6">
                                <form method="dialog">
                                    <button type="submit"
                                        class="py-2 px-4 text-sm rounded-lg bg-zinc-200 text-zinc-700 shadow-none border-none">Cancel</button>
                                </form>

                                <form method="POST" id="approveForm" x-data="{ loading: false }" @submit="loading = true">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="py-2 px-4 text-sm rounded-lg bg-green-500 text-white hover:bg-green-600 shadow-none border-none disabled:bg-green-500 disabled:text-white disabled:opacity-70"
                                        :disabled="loading">
                                        <span x-show="!loading">Yes, Approve</span>
                                        <span x-show="loading" class="flex items-center gap-2">
                                            <x-lucide-loader class="h-4 w-4 animate-spin" />
                                            Approving...
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>

<dialog id="rejectModal" class="modal">
    <div class="modal-box bg-zinc-50">
        <h3 class="text-lg font-bold text-zinc-800">Reject Return Request</h3>
        <p class="text-zinc-600" id="reject-text">
            Are you sure you want to reject this return request?
        </p>

        <!-- Request Details -->
        <div class="text-sm mt-5 space-y-1">
            <div class="flex gap-2">
                <span class="text-zinc-500">POD #:</span>
                <span id="reject-pod" class="text-zinc-700 font-semibold">0001</span>
            </div>
            <div class="flex gap-2">
                <span class="text-zinc-500">Customer:</span>
                <span id="reject-customer" class="text-zinc-700 font-semibold">Jollibee</span>
            </div>
            <div class="flex gap-2">
                <span class="text-zinc-500">Reason for return:</span>
                <span id="reject-reason" class="text-zinc-700 font-semibold">Hematoma</span>
            </div>
            <div class="flex gap-2">
                <span class="text-zinc-500">Detail Description:</span>
                <span id="reject-others" class="text-zinc-700 font-semibold">nyenye</span>
            </div>
            <div class="flex gap-2">
                <span class="text-zinc-500">Request Date:</span>
                <span id="reject-date" class="text-zinc-700 font-semibold">Today</span>
            </div>
        </div>

        <hr class="mt-5 mb-5">

        <!-- Rejection Form -->
        <form method="POST" id="rejectForm" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('PUT')

            <fieldset class="fieldset mb-4">
                <legend class="fieldset-legend text-zinc-600">
                    Please provide a short explanation for rejecting this request.
                </legend>
                <input type="text" name="rejection_reason" required
                    class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                    placeholder="e.g., Product already thawed or packaging damaged" />
            </fieldset>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="rejectModal.close()"
                    class="py-2 px-4 text-sm rounded-lg bg-zinc-200 text-zinc-700 shadow-none border-none">
                    Cancel
                </button>

                <button type="submit"
                    class="py-2 px-4 text-sm rounded-lg bg-red-500 text-white hover:bg-red-600 shadow-none border-none disabled:bg-red-500 disabled:text-white disabled:opacity-70"
                    :disabled="loading">
                    <span x-show="!loading">Reject</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <x-lucide-loader class="h-4 w-4 animate-spin" />
                        Rejecting...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>


                    <!-- Open the modal using ID.showModal() method -->

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
                headerName: "Description",
                field: "others",
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
                    const pod_number = params.data.pod_number;
                    const customer = params.data.customer;
                    const reason_for_return = params.data.reason_for_return;
                    const others = params.data.others;
                    const created_at = params.data.created_at;
                    const status = params.data.status;
                    const actionButtons = status === 'pending' ? `
            <button onclick="openApproveModal(${id}, '${pod_number}', '${customer}', '${reason_for_return}', '${others}', '${created_at}')" 
                class="bg-emerald-500 p-2 rounded-lg hover:bg-emerald-400 transition duration-300 ease-in-out" title="Approve">
                <x-lucide-stamp class="h-5 w-5 text-white"/>
            </button>
            <button onclick= "openRejectModal(${id}, '${pod_number}', '${customer}', '${reason_for_return}', '${others}', '${created_at}')" 
                class="bg-red-500 p-2 rounded-lg hover:bg-red-400 transition duration-300 ease-in-out" title="Reject">
                <x-lucide-ban class="h-5 w-5 text-white"/>
            </button>
        ` : '';

                    return `
            <div class="flex gap-1 items-center justify-center h-full">
                <button onclick="handleView(${id})" 
                    class="border border-gray-400 p-2 rounded-lg hover:bg-gray-300 transition duration-300 ease-in-out" title="View">
                    <x-lucide-file-text class="h-5 w-5 text-zinc-500"/>
                </button>
                ${actionButtons}
            </div>
        `;
                },
            },

        ];

        const returnRowData = @json($returns);


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
            getRowStyle: params => {

                if (params.data.status === 'approved') {
                    return {
                        backgroundColor: '#DCFCE7'
                    }; // light green
                }
                if (params.data.status === 'rejected') {
                    return {
                        backgroundColor: '#FECACA'
                    }; // light red
                }
                return null;
            },

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


    function openApproveModal(id, pod_number, customer, reason_for_return, others, created_at) {
        const dateObj = new Date(created_at);
        const formattedDate = dateObj.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        document.getElementById('approve-text').textContent =
            `Are you sure you want to approve the return request for:`;
        document.getElementById('pod').textContent = `${pod_number}`;
        document.getElementById('customer').textContent = `${customer}`;

        document.getElementById('reason').textContent = `${reason_for_return}`;
        document.getElementById('others').textContent = `${others}`;
        document.getElementById('date').textContent = formattedDate;
        const form = document.getElementById('approveForm');
        form.action = `/approve-return/${id}`;
        document.getElementById('approveModal').showModal();
    }

    function openRejectModal(id, pod_number, customer, reason_for_return, others, created_at) {
        const dateObj = new Date(created_at);
        const formattedDate = dateObj.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        document.getElementById('reject-text').textContent =
            `Are you sure you want to approve the return request for:`;
        document.getElementById('reject-pod').textContent = `${pod_number}`;
        document.getElementById('reject-customer').textContent = `${customer}`;

        document.getElementById('reject-reason').textContent = `${reason_for_return}`;
        document.getElementById('reject-others').textContent = `${others}`;
        document.getElementById('reject-date').textContent = formattedDate;
        const form = document.getElementById('rejectForm');
        form.action = `/reject-return/${id}`;
        document.getElementById('rejectModal').showModal();
    }
</script>
