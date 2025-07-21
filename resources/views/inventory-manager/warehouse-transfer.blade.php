<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Warehouse Transfer System</h1>
                        <h4 class="text-zinc-700">Manage inventory transfers between warehouses</h4>

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

                    <div class="flex justify-between gap-5">

                        <div class="p-4 lg:p-6 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-full">
                            <div class="text-zinc-700 flex items-center gap-2 mb-4">
                                <x-lucide-arrow-left-right class="h-6 w-6" />
                                <span class="font-semibold text-lg">From Warehouse</span>
                            </div>

                            <div class="w-full">
                                <div class="relative w-full z-[999]">
                                    <!-- Trigger -->
                                    <button id="dropdownFromButton"
                                        class="flex  justify-between z-[999] w-full bg-white border border-zinc-300 rounded-lg text-zinc-700 text-left px-4 py-2 focus:outline-none items-center">
                                        <span id="selectedFromText">Select warehouse</span>
                                        <x-lucide-chevron-down class="w-4 h-4 text-zinc-500" />
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <ul id="dropdownFromMenu"
                                        class="absolute z-[99] mt-1 w-full bg-white border border-orange-500 rounded-xl shadow-md hidden text-zinc-600">
                                        <li class="px-4 z-[99] py-2 hover:bg-orange-100 cursor-pointer border-b  border-orange-200 rounded-t-lg"
                                            data-value="PCSI">PCSI</li>
                                        <li class="px-4 z-[99] py-2 hover:bg-orange-100 cursor-pointer rounded-b-lg"
                                            data-value="3JFPC">3JFPC</li>
                                    </ul>
                                </div>


                            </div>
                        </div>

                        <div class="p-4 lg:p-6 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-full">
                            <div class="text-zinc-700 flex items-center gap-2 mb-4">
                                <x-lucide-arrow-left-right class="h-6 w-6" />
                                <span class="font-semibold text-lg">To Warehouse</span>
                            </div>

                            <div class="w-full">
                                <div class="relative w-full">
                                    <!-- Trigger -->
                                    <button id="dropdownToButton"
                                        class="flex  justify-between w-full bg-white border border-zinc-300 rounded-lg text-zinc-700 text-left px-4 py-2 focus:outline-none items-center">
                                        <span id="selectedToText">Select warehouse</span>
                                        <x-lucide-chevron-down class="w-4 h-4 text-zinc-500" />
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <ul id="dropdownToMenu"
                                        class="absolute z-[999] mt-1 w-full bg-white border border-orange-500 rounded-xl shadow-md hidden text-zinc-600">
                                        <li class="px-4 z-[999] py-2 hover:bg-orange-100 cursor-pointer border-b  border-orange-200 rounded-t-lg"
                                            data-value="PCSI">PCSI</li>
                                        <li class="px-4 py-2 hover:bg-orange-100 cursor-pointer rounded-b-lg"
                                            data-value="3JFPC">3JFPC</li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div id="pcsi" class="p-4 lg:p-6 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-full">
                        <div class="flex items-center gap-2">
                            <x-lucide-search class="h-5 w-5 text-zinc-500" />
                            <span class="text-zinc-700 font-semibold text-lg">Select Items to Transfer</span>
                        </div>
                        <h4 class="text-zinc-500 text-sm">Choose items from the source warehouse and specify quantities
                        </h4>


                        <div class="mt-4 border rounded-lg">
                            <table class="table text-sm ">
                                <thead class=" broder-t">
                                    <tr class="text-zinc-500">
                                        <th>Select</th>
                                        <th>Data Entry</th>
                                        <th>Item Code</th>
                                        <th>FG</th>
                                        <th>Available Qty</th>
                                        <th>Transfer Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $pcsi as $item )

                                    <tr class="border-t  hover:bg-zinc-100 transition text-zinc-700 font-semibold">
                                        <td class="border-t">
                                            <input type="checkbox"
                                                class="form-checkbox toggle-checkbox h-5 w-5 text-orange-500 border-orange-500 rounded focus:ring-orange-500 transition duration-150 cursor-pointer" />
                                        </td>
                                        <td class="border-t">
                                            {{$item->data_entry}}
                                        </td>
                                        <td class="border-t">
                                            {{$item->item_code}}

                                        </td>
                                         <td class="border-t">
                                            {{$item->fg}}

                                        </td>
                                        <td class="border-t">
                                            {{$item->balance_head}}
                                        </td>
                                        <td class="border-t">
                                            <span class="quantity-placeholder ">-</span>
                                            <input type="number" min="1" max= {{$item->balance_head}}
                                             oninput="this.value = Math.min(this.max, Math.max(this.min, this.value))"
                                                class="quantity-input hidden w-20 border border-zinc-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-orange-500 transition duration-150 text-sm" />
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-4">
                            <Button class="text-white text-sm bg-orange-500 px-4 py-2 mt-4 flex items-center gap-2 rounded-lg hover:bg-orange-400 transition duration-300 ease-in-out">
                                <x-lucide-arrow-left-right class="h-5 w-5 text-white" />
                                <span>Transfer Item</span>
                            </Button>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.querySelectorAll(".toggle-checkbox").forEach((checkbox) => {
        checkbox.addEventListener("change", function() {
            const row = checkbox.closest("tr");
            const input = row.querySelector(".quantity-input");
            const span = row.querySelector(".quantity-placeholder");

            if (checkbox.checked) {
                input.classList.remove("hidden");
                span.classList.add("hidden");
            } else {
                input.classList.add("hidden");
                span.classList.remove("hidden");
            }
        });
    });


    const fromButton = document.getElementById("dropdownFromButton");
    const toButton = document.getElementById("dropdownToButton");

    const fromMenu = document.getElementById("dropdownFromMenu");
    const toMenu = document.getElementById("dropdownToMenu");

    const selectedFromText = document.getElementById("selectedFromText");
    const selectedToText = document.getElementById("selectedToText");

    let fromValue = null;
    let toValue = null;

    // Toggle dropdowns
    fromButton.addEventListener("click", () => fromMenu.classList.toggle("hidden"));
    toButton.addEventListener("click", () => toMenu.classList.toggle("hidden"));

    // Handle From selection
    document.querySelectorAll("#dropdownFromMenu li").forEach((item) => {
        item.addEventListener("click", () => {
            fromValue = item.dataset.value;
            selectedFromText.textContent = fromValue;
            fromMenu.classList.add("hidden");
            updateMenus();
        });
    });

    // Handle To selection
    document.querySelectorAll("#dropdownToMenu li").forEach((item) => {
        item.addEventListener("click", () => {
            toValue = item.dataset.value;
            selectedToText.textContent = toValue;
            toMenu.classList.add("hidden");
            updateMenus();
        });
    });

    // Hide selected option from the opposite menu
    function updateMenus() {
        // Reset visibility first
        document.querySelectorAll("#dropdownFromMenu li").forEach((li) => li.classList.remove("hidden"));
        document.querySelectorAll("#dropdownToMenu li").forEach((li) => li.classList.remove("hidden"));

        // Hide selected "To" in "From"
        if (toValue) {
            document.querySelectorAll("#dropdownFromMenu li").forEach((li) => {
                if (li.dataset.value === toValue) li.classList.add("hidden");
            });
        }

        // Hide selected "From" in "To"
        if (fromValue) {
            document.querySelectorAll("#dropdownToMenu li").forEach((li) => {
                if (li.dataset.value === fromValue) li.classList.add("hidden");
            });
        }
    }

    // Close menus if clicked outside
    document.addEventListener("click", (e) => {
        if (!fromButton.contains(e.target) && !fromMenu.contains(e.target)) {
            fromMenu.classList.add("hidden");
        }
        if (!toButton.contains(e.target) && !toMenu.contains(e.target)) {
            toMenu.classList.add("hidden");
        }
    });
</script>
