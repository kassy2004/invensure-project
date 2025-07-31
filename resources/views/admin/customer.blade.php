<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between w-full mx-auto">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Customer Management</h1>
                        <p class="text-sm text-zinc-500">Manage your customers and view their feedback</p>

                    </div>
                    <button onclick="my_modal_5.showModal()"
                        class="bg-orange-500 px-4 py-2 flex items-center mt-5 lg:mt-0 gap-3 rounded-md text-gray-50 lg:text-sm hover:bg-orange-400 transition duration-200 ease-in-out justify-center">
                        <x-lucide-plus class="h-4 w-4" />
                        <span>Add Customer</span>
                    </button>
                    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                            <form method="dialog">
                                <button
                                    class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
                            </form>
                            <h3 class="text-lg font-bold text-zinc-900">Add Customer and Delivery Details</h3>
                            <form method="POST" action="{{ route('customer.add') }}" x-data="{ loading: false }"
                                @submit.prevent="loading = true; $nextTick(() => $el.submit())" id="addItemForm">
                                @csrf
                                <div class="flex flex-col gap-5 mt-5">
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-600">Email</legend>
                                        <input type="text" name="email"
                                            class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                            placeholder="example@gmail.com" required />

                                    </fieldset>
                                    <div class="flex justify-between items-center gap-2">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Business Name</legend>
                                            <input type="text" name="business_name"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="Enter business name" required />
                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Business Type</legend>
                                            <input type="text" name="business_type"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="e.g., Fast Food Chain, Supermarket" required />
                                        </fieldset>
                                    </div>
                                    <div class="flex justify-between items-center gap-2">
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Address</legend>
                                            <input type="text" name="address"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="Enter business address" required />
                                        </fieldset>
                                        <fieldset class="fieldset">
                                            <legend class="fieldset-legend text-zinc-600">Delivery Location</legend>
                                            <input type="text" name="delivery_location"
                                                class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                placeholder="Enter delivery location" required />
                                        </fieldset>
                                    </div>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-600">Phone Numbers</legend>
                                        <input type="text" name="numbers"
                                            class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                            placeholder="e.g., 9123456789" required />
                                    </fieldset>
                                </div>
                                <hr class="my-5">
                                <div class="flex justify-end gap-5">

                                    <button type="button" onclick="document.getElementById('my_modal_5').close()"
                                        class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                                    <button type="submit" :disabled="loading"
                                        class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out gap-2 items-center">
                                        <template x-if="loading">
                                            <x-lucide-loader class="h-4 w-4 animate-spin" />
                                        </template>
                                        <span x-text="loading ? 'Adding…' : 'Add'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                </div>


                <div class="w-full mx-auto">

                    @if (session('success'))
                        <div id="alert" role="alert" class="alert alert-success mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @elseif (session('error'))
                        <div id="alert" role="alert" class="alert alert-error mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @elseif ($errors->any())
                        <div id="alert" role="alert" class="alert alert-error mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                                fill="none" viewBox="0 0 24 24">
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
                </div>

                <div class="flex flex-col gap-6 mb-5 mt-5 w-full ">

                    <label class="input bg-transparent border border-zinc-300 rounded-lg mt-5">
                        <x-lucide-search class="h-4 w-4 text-gray-400 " />
                        <input id="search-box" type="search" class="grow text-zinc-600" placeholder="Search" />

                    </label>
                    <p class="text-md text-zinc-700">Customers ({{ $customersCount }})</p>

                    <div class="flex gap-5 flex-wrap w-full  ">
                        @foreach ($customers as $customer)
                            <div data-business="{{ strtolower($customer->business_name) }}"
                                data-email="{{ strtolower($customer->email) }}"
                                class="customer-card p-5 rounded-lg border border-zinc-300 w-full lg:w-[32%] bg-zinc-50 hover:shadow-md transition-all duration-300 ease-in-out">
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm text-zinc-700 font-semibold">{{ $customer->name ?? 'N/A' }}</span>
                                    <span class="text-sm text-zinc-500">{{ $customer->business_name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex flex-col gap-2 mt-3 mb-3">

                                    <div class="flex gap-2 items-center ">
                                        <x-lucide-mail class="h-3 w-3 text-zinc-600" />
                                        <span
                                            class="text-sm text-zinc-700 text-center">{{ $customer->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex gap-2 items-center ">
                                        <x-lucide-phone class="h-3 w-3 text-zinc-600" />
                                        <span
                                            class="text-sm text-zinc-700 text-center">{{ $customer->numbers ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex gap-2 items-center ">
                                        <x-lucide-map-pin class="h-3 w-3 text-zinc-600" />
                                        <span
                                            class="text-sm text-zinc-700 text-center">{{ $customer->address ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="flex justify-evenly mt-3">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="text-zinc-700 font-semibold text-lg ">{{ $customer->total_orders }}</span>
                                        <span class="text-sm text-zinc-500">Total Orders</span>
                                    </div>
                                    <div class="flex flex-col items-center">


                                        <span class="text-zinc-700 font-semibold text-lg">
                                            {{ \Carbon\Carbon::parse($customer->created_at)->format('F j, Y') ?? 'N/A' }}
                                        </span>
                                        <span class="text-sm text-zinc-500">Since</span>
                                    </div>
                                </div>
                                <div>
                                    <button onclick="customerModal{{ $customer->id }}.showModal()"
                                        class="rounded-lg border border-zinc-300 w-full text-zinc-700 flex items-center justify-center py-2 mt-5 gap-5 hover:bg-zinc-200 transition duration-200 ease-in-out">
                                        <x-lucide-eye class="h-5 w-5 text-zinc-600" />
                                        <span class="text-sm">View Details & Feedback</span>
                                    </button>
                                </div>

                            </div>

                            <dialog id="customerModal{{ $customer->id }}" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box bg-zinc-50  lg:w-11/12 lg:max-w-4xl max-h-[70vh]">
                                    <span class="text-zinc-700 font-bold">Customer Details</span>
                                    <form method="dialog">
                                        <button
                                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                                    </form>

                                    <div data-business="{{ strtolower($customer->business_name) }}"
                                        data-email="{{ strtolower($customer->email) }}"
                                        class="customer-card p-5 rounded-lg border border-zinc-300 w-full bg-zinc-50 mt-5">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm text-zinc-700 font-semibold">{{ $customer->name ?? 'N/A' }}</span>
                                            <span
                                                class="text-sm text-zinc-500">{{ $customer->business_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex gap-20">

                                            <div class="flex flex-col gap-2 mt-3 mb-3">
                                                <div class="flex gap-2 items-center ">
                                                    <x-lucide-building class="h-3 w-3 text-zinc-600" />
                                                    <span
                                                        class="text-sm text-zinc-700 text-center">{{ $customer->business_type ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex gap-2 items-center ">
                                                    <x-lucide-mail class="h-3 w-3 text-zinc-600" />
                                                    <span
                                                        class="text-sm text-zinc-700 text-center">{{ $customer->email ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex gap-2 items-center ">
                                                    <x-lucide-phone class="h-3 w-3 text-zinc-600" />
                                                    <span
                                                        class="text-sm text-zinc-700 text-center">{{ $customer->numbers ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex gap-2 items-center ">
                                                    <x-lucide-map-pin class="h-3 w-3 text-zinc-600" />
                                                    <span
                                                        class="text-sm text-zinc-700 text-center">{{ $customer->address ?? 'N/A' }}</span>
                                                </div>

                                            </div>
                                            <div>
                                                <div class="flex gap-2 items-center ">
                                                    <span class="text-xs text-zinc-600">Total Orders:</span>
                                                    <span
                                                        class="text-sm text-zinc-700 text-center">{{ $customer->total_orders }}</span>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="flex justify-end gap-5">

                                            <button type="button" onclick="edit{{ $customer->id }}.showModal()"
                                                {{-- onclick="document.getElementById('my_modal_5').close()" --}}
                                                class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Edit</button>

                                            <form action="{{ route('customer.destroy', $customer->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex justify-end mt-2 px-4 py-2 text-sm bg-red-500 text-white rounded-md hover:bg-red-400 transition duration-200 ease-in-out gap-2 items-center">

                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                            <dialog id="edit{{ $customer->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-zinc-50 border border-zinc-300 h-100">
                                                    <form method="dialog">
                                                        <button
                                                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800 ">✕</button>
                                                    </form>
                                                    <h3 class="text-lg font-bold text-zinc-900">Edit Customer
                                                        Details
                                                    </h3>
                                                    <form method="POST"
                                                        action="{{ route('customer.edit', $customer->id) }}"
                                                        x-data="{ loading: false }"
                                                        @submit.prevent="loading = true; $nextTick(() => $el.submit())"
                                                        id="editItemForm">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="flex flex-col gap-5 mt-5">
                                                            <fieldset class="fieldset">
                                                                <legend class="fieldset-legend text-zinc-600">Email
                                                                </legend>
                                                                <input type="text" name="email"
                                                                    class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                    placeholder="example@gmail.com" required
                                                                    value="{{ $customer->email }}" />

                                                            </fieldset>
                                                            <div class="flex justify-between items-center gap-2">
                                                                <fieldset class="fieldset">
                                                                    <legend class="fieldset-legend text-zinc-600">
                                                                        Business Name</legend>
                                                                    <input type="text" name="business_name"
                                                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                        placeholder="Enter business name" required
                                                                        value="{{ $customer->business_name }}" />
                                                                </fieldset>
                                                                <fieldset class="fieldset">
                                                                    <legend class="fieldset-legend text-zinc-600">
                                                                        Business Type</legend>
                                                                    <input type="text" name="business_type"
                                                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                        placeholder="e.g., Fast Food Chain, Supermarket"
                                                                        required
                                                                        value="{{ $customer->business_type }}" />
                                                                </fieldset>
                                                            </div>
                                                            <div class="flex justify-between items-center gap-2">
                                                                <fieldset class="fieldset">
                                                                    <legend class="fieldset-legend text-zinc-600">
                                                                        Address</legend>
                                                                    <input type="text" name="address"
                                                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                        placeholder="Enter business address" required
                                                                        value="{{ $customer->address }}" />
                                                                </fieldset>
                                                                <fieldset class="fieldset">
                                                                    <legend class="fieldset-legend text-zinc-600">
                                                                        Delivery Location</legend>
                                                                    <input type="text" name="delivery_location"
                                                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                        placeholder="Enter delivery location" required
                                                                        value="{{ $customer->delivery_location }}" />
                                                                </fieldset>
                                                            </div>
                                                            <fieldset class="fieldset">
                                                                <legend class="fieldset-legend text-zinc-600">Phone
                                                                    Numbers</legend>
                                                                <input type="text" name="numbers"
                                                                    class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                                    placeholder="e.g., 9123456789" required
                                                                    value="{{ $customer->numbers }}" />
                                                            </fieldset>
                                                        </div>
                                                        <hr class="my-5">
                                                        <div class="flex justify-end gap-5">

                                                            <button type="button"
                                                                onclick="document.getElementById('my_modal_5').close()"
                                                                class="flex justify-end mt-2 px-4 py-2 text-sm bg-transparent text-zinc-500 hover:bg-zinc-200 rounded-md transition duration-200 ease-in-out ">Cancel</button>

                                                            <button type="submit" :disabled="loading"
                                                                class="flex justify-end mt-2 px-4 py-2 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-400 transition duration-200 ease-in-out gap-2 items-center">
                                                                <template x-if="loading">
                                                                    <x-lucide-loader class="h-4 w-4 animate-spin" />
                                                                </template>
                                                                <span x-text="loading ? 'Adding…' : 'Add'"></span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </dialog>


                                        </div>
                                    </div>
                                    <div class="p-5 w-full border border-zinc-300 rounded-lg mt-5">
                                        <span class="text-zinc-700 font-bold">Recent Orders & Feedback</span>
                                        @php
                                            $customerFeedback = $feedback[$customer->email] ?? collect();
                                        @endphp
                                        @if ($customerFeedback->isNotEmpty())
                                            <div class="flex gap-4 mt-3">
                                                @forelse ($feedback as $email => $entries)
                                                    @foreach ($entries as $entry)
                                                        <div class="w-full border p-5 border-zinc-300 rounded-md">
                                                            <div class="flex flex-col gap-2">
                                                                <div class="flex gap-2 items-center">
                                                                    <span class="text-zinc-600 font-semibold text-sm">
                                                                        ORDER #{{ $entry->order_id }}
                                                                    </span>
                                                                    <span
                                                                        class="text-xs text-zinc-600 border rounded-full py-1 px-2">Delivered</span>
                                                                    <span
                                                                        class="text-zinc-500 text-xs">{{ \Carbon\Carbon::parse($entry->feedback_at)->format('m/d/Y') }}</span>
                                                                </div>
                                                                <div class="bg-zinc-100 p-2 rounded-md">
                                                                    <div class="flex gap-2 items-center">
                                                                        <span class="text-zinc-700 text-xs">Customer
                                                                            Rating:</span>
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <x-lucide-star
                                                                                class="w-4 h-4 transition {{ $i <= $entry->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                                fill="currentColor" />
                                                                        @endfor
                                                                        <span
                                                                            class="text-zinc-600 text-xs">({{ $entry->rating }}/5)</span>
                                                                    </div>
                                                                    <div>
                                                                        <span
                                                                            class="italic text-zinc-500 text-xs">"{{ $entry->comment }}"</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @empty
                                                    <div>No feedback found.</div>
                                                @endforelse

                                            </div>
                                        @else
                                            <div
                                                class="flex text-zinc-500 justify-center my-10 text-center items-center">
                                                Empty!
                                            </div>
                                        @endif
                                    </div>


                                </div>
                            </dialog>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
<script>
    document.getElementById('search-box').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.customer-card');

        cards.forEach(card => {
            const business = card.dataset.business || '';
            const email = card.dataset.email || '';

            const matches = business.includes(query) || email.includes(query);
            card.style.display = matches ? 'block' : 'none';
        });
    });
</script>
