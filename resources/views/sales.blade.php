<x-app-layout>
    @include('layouts.sidebar')

    <div class="w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden">
                <div class="lg:p-6">
                    <div class="flex flex-col gap-6 mb-5 mt-5">

                        <div class="bg-gray-50  rounded-lg p-6 border-2 border-gray-200 w-full">
                            <div class="mb-4">
                                <h1 class="text-xl font-bold text-gray-900">Forecast vs Actual vs Error – 2026 Sales
                                </h1>
                                <p class="text-sm text-gray-500">Includes B2B, B2C, and error analysis per product</p>
                            </div>

                            <div class="w-11/12 mx-auto">
                                <canvas id="forecastChart" width="800" height="400"></canvas>
                            </div>
                            {{-- <div class="flex justify-between mt-5">

                                <div class="flex gap-5">

                                    <div class="flex gap-2">
                                        <span class="text-gray-500">Model:</span>
                                        <span class="text-gray-800">XGBoost v2.3</span>
                                    </div>

                                    <div class="flex gap-2 font-semibold ">
                                        <span class="text-gray-500">Date Range:</span>
                                        <span class="text-gray-800">3 years</span>
                                    </div>
                                </div>

                                <div class="flex gap-5">
                                    <button type="button"
                                        class="border border-gray-300 text-gray-700 rounded-md px-4 py-2 text-sm">Export
                                        Data</button>
                                    <button type="button"
                                        class="bg-gray-900 text-gray-200 rounded-md px-4 py-2 text-sm">Run New
                                        Forecast</button>
                                </div>

                            </div> --}}

                        </div>

                        <div class="bg-gray-50  rounded-lg p-6 border-2 border-gray-200 w-full">

                            <h2 class="text-xl font-semibold text-gray-800">Forecast Data Table – 2026 Sales</h2>
                            <p class="text-sm text-gray-500 mb-5">Displays forecast vs actual sales with errors</p>
                            <div id="forecastGrid" class="ag-theme-alpine bg-zinc-300 mt-10"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
<script>
    // Ensure this script is at the bottom of your Blade template

    fetch('http://127.0.0.1:5000/forecast') // or /forecast_2026
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => `${item.Category} - ${item.Product}`);
            const actualData = data.map(item => item.Actual_Total);
            const forecastData = data.map(item => item.Forecast_Total);

            const ctx = document.getElementById('forecastChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Actual Total',
                            data: actualData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Forecast Total',
                            data: forecastData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Absolute Error',
                            data: data.map(item => item.Abs_Error),
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: false,
                            tension: 0.2,
                            borderDash: [5, 5] // dashed line for error
                        },

                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Forecast vs Actual Total for 2026'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Total'
                            }
                        },

                        x: {
                            title: {
                                display: true,
                                text: 'Product'
                            }
                        }
                    }
                }
            });
            // --- AG Grid part ---
            const columnDefs = [{
                    headerName: "Category",
                    field: "Category",
                    sortable: true,
                    filter: true
                },
                {
                    headerName: "Product",
                    field: "Product",
                    sortable: true,
                    filter: true
                },
                {
                    headerName: "Actual Total",
                    field: "Actual_Total",
                    sortable: true,
                    filter: true,
                    valueFormatter: params => params.value.toLocaleString()
                },
                {
                    headerName: "Forecast Total",
                    field: "Forecast_Total",
                    sortable: true,
                    filter: true,
                    valueFormatter: params => params.value.toLocaleString()
                },
                {
                    headerName: "Absolute Error",
                    field: "Abs_Error",
                    sortable: true,
                    filter: true,
                    valueFormatter: params => params.value.toLocaleString()
                },
                {
                    headerName: "Percentage Error (%)",
                    field: "Perc_Error",
                    sortable: true,
                    filter: true,
                    valueFormatter: params => params.value.toFixed(2) + "%"
                }
            ];


            const gridOptions = {
                columnDefs: columnDefs,
                rowData: data,
                domLayout: 'autoHeight',
                pagination: true,
                paginationPageSize: 10,
                defaultColDef: {
                    flex: 1,
                    minWidth: 120,
                    resizable: true
                }
            };

            const eGridDiv = document.querySelector('#forecastGrid');
            new agGrid.Grid(eGridDiv, gridOptions);
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
