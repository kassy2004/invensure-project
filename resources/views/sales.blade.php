<x-app-layout>
    @include('layouts.sidebar')

    <div class="w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden">
                <div class="lg:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <h1 class="text-2xl font-bold text-zinc-900">Sales Forecasting</h1>
                            <h4 class="text-zinc-700">Analyze actual vs forecasted sales and inventory trends</h4>

                        </div>

                    </div>
                    <div class="flex flex-col gap-6 mb-5 mt-5">

                        <div class="bg-gray-50  rounded-lg p-6 border-2 border-gray-200 w-full">
                            <div class="mb-4">
                                <h1 id="chartTitle" class="text-xl font-bold text-gray-900">Forecast vs Actual vs Error
                                    – 2026 Sales
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

                            <h2 id="tableTitle" class="text-xl font-semibold text-gray-800">Forecast Data Table – 2026
                                Sales</h2>
                            <p class="text-sm text-gray-500 mb-5">Displays forecast vs actual sales with errors</p>
                            <div id="forecastGrid" class="ag-theme-alpine bg-zinc-300 mt-10"></div>

                        </div>

                        <div class="bg-gray-50  rounded-lg p-6 border-2 border-gray-200 w-full">
                            <div class="flex justify-between items-center">

                                <div>
                                    <h2 id="tableTitle" class="text-xl font-semibold text-gray-800">Historical Sales
                                        Data
                                    </h2>
                                    <p class="text-sm text-gray-500 mb-5">Displays actual sales across all categories
                                        and
                                        months
                                    </p>
                                </div>
                                {{-- <button
                                    class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                                    <x-lucide-plus class="h-4 w-4" />
                                    New Entry</button> --}}
                                <div class="">

                                    <div class="drawer drawer-end z-50">
                                        <input id="my-drawer-5" type="checkbox" class="drawer-toggle" />
                                        <div class="drawer-content">
                                            <!-- Page content here -->
                                            <label for="my-drawer-5"
                                                class="drawer-button bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 cursor-pointer transition duration-200 ease-in-out">
                                                <x-lucide-plus class="h-4 w-4" />
                                                New Entry

                                            </label>
                                        </div>
                                        <div class="drawer-side">
                                            <label for="my-drawer-5" aria-label="close sidebar"
                                                class="drawer-overlay"></label>
                                            <div class="menu bg-gray-100 min-h-full w-[80%] p-4">
                                                <form action="{{ route('sales.store') }} " method="POST">
                                                    @csrf
                                                    <span class="text-black text-lg font-semibold">Add New Sale</span>

                                                    <div>

                                                        {{-- <fieldset class="fieldset">
                                                            <legend class="fieldset-legend text-zinc-600">Year</legend>
                                                            <input type="number"
                                                                class="border bg-transparent  border-gray-300 px-3 py-2  text-gray-800 focus:outline-none focus:ring-2  focus:text-gray-600 focus:ring-orange-300 focus:border-orange-300 w-full focus:ring-opacity-50 rounded-lg"
                                                                placeholder="2025" name="year"/>
                                                        </fieldset> --}}
                                                        <fieldset class="fieldset">
                                                            <legend class="fieldset-legend text-zinc-600 ">Year</legend>
                                                            <?php
                                                            $currentYear = date('Y');
                                                            $years = [$currentYear - 1, $currentYear, $currentYear + 1];
                                                            ?>
                                                            <select id="yearSelect" name="year"
                                                                class="select rounded-lg bg-transparent border border-gray-300 text-gray-800">
                                                                <?php foreach ($years as $year): ?>
                                                                <option value="<?= $year ?>"
                                                                    <?= $year == $currentYear ? 'selected' : '' ?>>
                                                                    <?= $year ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </fieldset>


                                                    </div>
                                                    @php
                                                        $products = [
                                                            ['product' => 'Dressed Chicken', 'category' => 'B2C'],
                                                            ['product' => 'Dressed Chicken', 'category' => 'B2B'],
                                                            ['product' => 'Choice Cuts', 'category' => 'B2C'],
                                                            ['product' => 'Choice Cuts', 'category' => 'B2B'],
                                                            ['product' => 'Chicken Fillet', 'category' => 'B2C'],
                                                            ['product' => 'Chicken Fillet', 'category' => 'B2B'],
                                                            ['product' => 'General', 'category' => 'Papak Sarap'],
                                                            [
                                                                'product' => 'General',
                                                                'category' => 'Value Added Products',
                                                            ],
                                                        ];

                                                        $months = [
                                                            'JAN',
                                                            'FEB',
                                                            'MAR',
                                                            'APR',
                                                            'MAY',
                                                            'JUN',
                                                            'JUL',
                                                            'AUG',
                                                            'SEP',
                                                            'OCT',
                                                            'NOV',
                                                            'DEC',
                                                        ];
                                                    @endphp

                                                    <hr class="my-5">
                                                    <table id="salesTable"
                                                        class="w-full border border-gray-200 rounded-lg overflow-hidden">
                                                        <thead class="bg-gray-100">
                                                            <tr class="text-gray-700">
                                                                <th class="p-2 border w-64">Product</th>
                                                                @foreach ($months as $month)
                                                                    <th class="p-2 border w-32">{{ $month }}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-gray-800">
                                                            @foreach ($products as $productInfo)
                                                                <tr>
                                                                    @php
                                                                        $label = "{$productInfo['product']} - {$productInfo['category']}";
                                                                    @endphp
                                                                    <td class="p-2 border">{{ $label }}</td>
                                                                    @foreach ($months as $month)
                                                                        <td class="p-2 border">
                                                                            <input type="number"
                                                                                name="{{ Str::slug($label, '_') }}_{{ strtolower($month) }}"
                                                                                data-product-slug="{{ Str::slug($label, '_') }}"
                                                                                data-product-key="{{ Str::slug($productInfo['product'], '_') }}::{{ Str::slug($productInfo['category'], '_') }}"
                                                                                data-month="{{ strtolower($month) }}"
                                                                                class="w-full px-2 py-1 border rounded"
                                                                                value="" />
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="flex justify-center items-center mt-5">

                                                        <button
                                                            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out w-full text-center justify-center">
                                                            <span>Add Sales Record</span>
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div id="actualGrid" class="ag-theme-alpine bg-zinc-300 mt-10"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>


<script>
    const salesData = @json($sales);
    const monthKeys = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    const slugifyProduct = (value = '') => value
        .toString()
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '_')
        .replace(/^_+|_+$/g, '')
        .replace(/_+/g, '_');
    const buildProductKey = (record) => {
        const productSlug = slugifyProduct(record.product || '');
        const categorySlug = slugifyProduct(record.category || '');
        return `${productSlug}::${categorySlug}`;
    };

    const populateSalesForm = (year) => {
        console.log('[sales form] populate for year:', year);
        const inputs = document.querySelectorAll('#salesTable input[type="number"]');
        inputs.forEach((input) => {
            input.value = '';
        });

        const records = salesData.filter((item) => Number(item.year) === Number(year));
        console.log('[sales form] matching records:', records);
        records.forEach((record) => {
            const productKey = buildProductKey(record);
            const productExists = document.querySelector(
                `#salesTable input[data-product-key="${productKey}"]`);
            if (!productExists) {
                console.warn('[sales form] product not rendered in table; skipping', record.product);
                return;
            }
            monthKeys.forEach((month) => {
                const selector =
                    `#salesTable input[data-product-key="${productKey}"][data-month="${month}"]`;
                const inputEl = document.querySelector(selector);
                if (!inputEl) {
                    return;
                }

                const monthValue = record[month];
                if (monthValue !== null && monthValue !== undefined) {
                    inputEl.value = monthValue;
                    console.log('[sales form] applied value', {
                        product: record.product,
                        month,
                        value: monthValue
                    });
                }
            });
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        const yearSelect = document.getElementById('yearSelect');
        if (!yearSelect) {
            return;
        }

        populateSalesForm(yearSelect.value);
        yearSelect.addEventListener('change', (event) => {
            populateSalesForm(event.target.value);
        });
    });

    // Ensure this script is at the bottom of your Blade template

    fetch('http://127.0.0.1:5000/forecast') // or /forecast_2026
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => `${item.category} - ${item.product}`);
            const actualData = data.map(item => item.Actual_Total);
            const forecastData = data.map(item => item.Forecast_Total);
            const year = data[0].year;

            document.getElementById('chartTitle').innerText = `Forecast vs Actual vs Error – ${year} Sales`;
            document.getElementById('tableTitle').innerText = `Forecast Data Table – ${year} Sales`;
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
                            text: `Forecast vs Actual Total for ${year}`
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
                    field: "category",
                    sortable: true,
                    filter: true
                },
                {
                    headerName: "Product",
                    field: "product",
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

            // // --- Actual Sales Grid ---
            // const actualDataOnly = salesData.map(item => ({
            //     category: item.category,
            //     product: item.product,
            //     Actual_Total: item.Actual_Total
            // }));
            const safeFormatter = params => {
                if (params.value === null || params.value === "") return "";
                return Number(params.value).toLocaleString();
            };
            const columnDefsActual = [{
                    headerName: "Year",
                    field: "year",
                    sortable: true,
                    filter: true
                },
                {
                    headerName: "Category",
                    field: "category",
                    sortable: true,
                    filter: true,
                    width: 160
                },
                {
                    headerName: "Product",
                    field: "product",
                    sortable: true,
                    filter: true
                },

                {
                    headerName: "Jan",
                    field: "jan",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Feb",
                    field: "feb",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Mar",
                    field: "mar",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Apr",
                    field: "apr",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "May",
                    field: "may",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Jun",
                    field: "jun",
                    sortable: true,
                    filter: true,
                    valueFormatter: params => {
                        if (params.value != null) {
                            return params.value.toLocaleString(); // adds commas
                        }
                        return '';
                    }
                },
                {
                    headerName: "Jul",
                    field: "jul",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Aug",
                    field: "aug",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Sep",
                    field: "sep",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Oct",
                    field: "oct",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Nov",
                    field: "nov",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },
                {
                    headerName: "Dec",
                    field: "dec",
                    sortable: true,
                    filter: true,
                    valueFormatter: safeFormatter
                },

            ];

            new agGrid.Grid(document.querySelector('#actualGrid'), {
                columnDefs: columnDefsActual,
                rowData: salesData,
                domLayout: 'autoHeight',
                pagination: true,
                paginationPageSize: 8,
                defaultColDef: {
                    minWidth: 50,
                    resizable: true
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
