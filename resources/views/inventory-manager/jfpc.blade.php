<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Finished Goods Inventory</h1>
                        <h4 class="text-zinc-700">3JFPC Warehouse</h4>
                    </div>
                    <div class="flex gap-2 mt-5 lg:mt-0">
                        <button popovertarget="popover-1" style="anchor-name:--anchor-1" {{-- onclick="window.location='{{ url('/export-pcsi-incoming') }}'" --}}
                            class="px-4 py-2 flex items-center gap-3 rounded-md text-zinc-900 text-sm border border-zinc-300 hover:border-zinc-400 transition duration-200 ease-in-out"><x-lucide-download
                                class="h-4 w-4" />Export</button>
                        <ul class="dropdown menu w-52 rounded-box bg-zinc-50 text-zinc-600 shadow-sm" popover
                            id="popover-1" style="position-anchor:--anchor-1">
                            <li class="text-zinc-600  hover:bg-zinc-100 rounded-lg  active:bg-orange-500"><a
                                    href="{{ url('/export-jfpc-incoming') }}">Incoming</a></li>
                            <li class="text-zinc-600  hover:bg-zinc-100 rounded-lg  active:bg-orange-500"><a
                                    href="{{ url('/export-jfpc-outgoing') }}">Outgoing</a></li>
                        </ul>
                        <button onclick="my_modal_5.showModal()"
                            class="bg-orange-500 px-4 py-2 flex items-center gap-3 rounded-md text-gray-50 text-sm hover:bg-orange-400 transition duration-200 ease-in-out">
                            <x-lucide-plus class="h-4 w-4" />
                            Add Item</button>
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


                <!-- You can open the modal using ID.showModal() method -->
                <dialog id="my_modal_5" class="modal  modal-bottom sm:modal-middle">
                    <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                        <form method="dialog">
                            <button
                                class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
                        </form>
                        <h3 class="text-lg font-bold text-zinc-900">Add item to PCSI Warehouse</h3>



                        <form method="POST" action="{{ route('warehouse.jfpc.add') }}" id="addItemForm">
                            @csrf
                            <div class="flex flex-col gap-5">

                                <div class="flex gap-5 justify-between">
                                    <div class="flex flex-col w-full">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Data Entry</legend>
                                        </fieldset>
                                        <select name="data_entry" id="data_entry" class="tom-select"
                                            class="border border-zinc-300 bg-white text-zinc-800 rounded-md px-3 py-2 h-auto focus:outline-none focus:ring-2 focus:ring-blue-500 focus:text-blue-600 w-full">
                                            <option value="">Select an item...</option>
                                        </select>
                                    </div>

                                    <!-- Hidden inputs to store additional item data -->

                                    <div class="flex flex-col w-2/3">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Prod. Date</legend>
                                        </fieldset>
                                        <button type="button" popovertarget="cally-popover1"
                                            class="input input-border bg-zinc-50 border border-zinc-300 text-zinc-600 w-full cursor-pointer"
                                            id="cally1" style="anchor-name:--cally1">
                                            <x-lucide-calendar class="h-4 w-4" />
                                        </button>
                                        <div popover id="cally-popover1"
                                            class="dropdown bg-zinc-200 rounded-box shadow-lg"
                                            style="position-anchor:--cally1">
                                            <calendar-date class="cally  text-zinc-900 "
                                                onchange="
                                        const selectedDate = this.value || this.getAttribute('value');
                                        document.getElementById('prod_date').value = selectedDate;
                                        document.getElementById('cally1').innerText = selectedDate;
                                    ">
                                                <svg aria-label="Previous" class="fill-current size-4 text-zinc-900 "
                                                    slot="previous" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                                </svg>
                                                <svg aria-label="Next" class="fill-current size-4  text-zinc-900 "
                                                    slot="next" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                                </svg>
                                                <calendar-month></calendar-month>
                                            </calendar-date>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <legend class="fieldset-legend text-zinc-600">Inventory</legend>
                                    <div class="flex gap-5">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Head/Pack</legend>
                                            <input type="text" name="inventory_head"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="0" required />

                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Kilogram</legend>
                                            <input type="text" name="inventory_kilo"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                                placeholder="0.00" required />

                                        </fieldset>
                                    </div>
                                    <div>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Received By</legend>
                                            <input type="text" name="received_by"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full"
                                                placeholder="AA00000000/AA00000" required />

                                        </fieldset>

                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Remarks</legend>
                                            <input type="text" name="remarks"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400 w-full" />
                                            <p class="label text-zinc-400">Optional</p>
                                        </fieldset>


                                    </div>
                                </div>
                                <input type="hidden" name="item_group" id="item_group">
                                <input type="hidden" name="idnum" id="idnum">
                                <input type="hidden" name="variant" id="variant">
                                <input type="hidden" name="kilogram_tray" id="kilogram_tray">
                                <input type="hidden" name="class" id="class">
                                <input type="hidden" name="sku" id="sku">
                                <input type="hidden" name="fg" id="fg">
                                <input type="hidden" name="primary_packaging" id="primary_packaging">
                                <input type="hidden" name="secondary_packaging" id="secondary_packaging">
                                <input type="hidden" name="prod_date" id="prod_date">
                                <input type="hidden" name="item_code" id="item_code">
                            </div>
                            <hr class="my-5">
                            <div class="flex justify-end gap-5">

                                <button type="button" onclick="document.getElementById('my_modal_5').close()"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                                <button type="submit"
                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out">Add</button>
                            </div>

                        </form>

                    </div>
                </dialog>

                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">

                    <div x-data="{ tab: 'subtotal' }">
                        <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">
                            <span @click="tab = 'subtotal'" :class="tab === 'subtotal' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Subtotal</span>
                            <span @click="tab = 'status'" :class="tab === 'status' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Status </span>
                        </div>
                        <div class="mt-5 w-full">
                            <div x-show="tab === 'subtotal'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.subtotal')
                            </div>

                            <div x-show="tab === 'status'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.dashboard.status')
                            </div>

                        </div>
                    </div>



                </div>

                <div class="flex flex-col gap-6 mb-5 mt-5 w-full">



                    <div x-data="{ tab: 'incoming' }">
                        <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                            <span @click="tab = 'incoming'" :class="tab === 'incoming' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Incoming</span>
                            <span @click="tab = 'outgoing'" :class="tab === 'outgoing' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Outgoing </span>
                            <span @click="tab = 'pod-jfpc'" :class="tab === 'pod-jfpc' ? 'bg-gray-50' : 'bg-gray-200'"
                                class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">POD </span>

                        </div>
                        <div class="mt-5 w-full">
                            <div x-show="tab === 'incoming'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.jfpc.incoming')
                            </div>

                            <div x-show="tab === 'outgoing'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.jfpc.outgoing')
                            </div>
                            <div x-show="tab === 'pod-jfpc'" x-transition class="flex flex-col gap-6 w-full ">
                                @include('inventory-manager.jfpc.pod-jfpc')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
