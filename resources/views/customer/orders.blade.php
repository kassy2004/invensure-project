<x-app-layout>

    {{-- @include('layouts.sidebar') --}}

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden p-6">

                <div class="flex items-center justify-between w-1/2 mx-auto">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">My Orders</h1>
                        <p class="text-sm text-zinc-500">View your order history, provide feedback, and request returns
                            within 12 hours of delivery.</p>

                    </div>
                </div>
                <div class="w-1/2 mx-auto">

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
                    @foreach ($order as $orders)
                        <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                            <div class="flex justify-between items-center">

                                <div class="flex flex-col">

                                    <div class="flex gap-2 items-center">
                                        <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                        <span class="text-zinc-900 text-lg font-semibold">Order
                                            #{{ $orders->order_id }}
                                        </span>
                                    </div>
                                    <span class="text-zinc-500">Ordered on {{ $orders->transaction_date }}
                                        {{-- • Delivered on 12/30/2024 at 2:30:00 PM --}}
                                    </span>
                                </div>

                                <div class="flex flex-col justify-end items-end">
                                    @php
                                        $statusColor = match ($orders->status) {
                                            'delivered' => 'bg-orange-500',
                                            'pending' => 'bg-gray-500',
                                            'in transit' => 'bg-blue-500',
                                            default => 'bg-blue-500', // fallback just in case
                                        };
                                    @endphp
                                    <div
                                        class="flex text-xs  rounded-full p-1 gap-1 items-center px-2
                                       {{ $statusColor }} text-white">
                                        <x-lucide-truck class="h-3 w-3" />
                                        {{ ucwords(str_replace('_', ' ', $orders->status)) }}
                                    </div>
                                    {{-- <span class="text-lg text-orange-500 font-bold">₱ 9,500</span> --}}
                                </div>
                            </div>

                            <div x-data="{
                                currentPage: 1,
                                itemsPerPage: 5,
                                get totalPages() {
                                    return Math.ceil({{ count($orders->products) }} / this.itemsPerPage);
                                },
                                get paginatedProducts() {
                                    const start = (this.currentPage - 1) * this.itemsPerPage;
                                    return {{ Js::from($orders->products) }}.slice(start, start + this.itemsPerPage);
                                }
                            }" class="flex flex-col gap-2">

                                <!-- Product List -->
                                <div class="flex flex-col gap-4 mt-5 mb-2 ">
                                    <template x-for="(product, index) in paginatedProducts" :key="index">
                                        <div
                                            class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-zinc-700"
                                                    x-text="`${(index + 1) + (currentPage - 1) * itemsPerPage}. ${product.description}`"></span>
                                                <span class="text-xs text-zinc-600"
                                                    x-text="`${product.quantity} - ${product.kilogram}kg`"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Pagination Controls -->
                                <div class="flex justify-between items-center text-xs text-zinc-600">
                                    <button class="px-2 py-1 border rounded" @click="if(currentPage > 1) currentPage--"
                                        :disabled="currentPage === 1">
                                        Prev
                                    </button>

                                    <span>Page <span x-text="currentPage"></span> of <span
                                            x-text="totalPages"></span></span>

                                    <button class="px-2 py-1 border rounded"
                                        @click="if(currentPage < totalPages) currentPage++"
                                        :disabled="currentPage === totalPages">
                                        Next
                                    </button>
                                </div>

                            </div>


                            <hr class="mt-5">
                            @if (!$orders->has_return)
                                @if ($orders->status === 'delivered')
                                    {{-- Feedback Section --}}
                                    @if ($orders->has_feedback)
                                        <div x-data="{ rating: {{ $orders->feedback_data->rating ?? 0 }} }"
                                            class="flex flex-col gap-3 rounded-lg border border-zinc-300 p-3 mt-5">
                                            <div class="flex gap-2 items-center">
                                                <x-lucide-circle-check-big class="h-4 w-4 text-green-600" />
                                                <span class="text-xs text-green-600">Feedback Submitted</span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <div class="flex">
                                                    <template x-for="star in 5" :key="star">
                                                        <div>
                                                            {{-- Unfilled star --}}
                                                            <x-lucide-star x-show="rating < star"
                                                                class="h-4 w-4 text-zinc-300" />
                                                            {{-- Filled star --}}
                                                            <x-lucide-star x-show="rating >= star"
                                                                class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                                        </div>
                                                    </template>
                                                </div>
                                                <span class="text-zinc-500 text-xs" x-text="`(${rating}/5)`"></span>
                                            </div>

                                            <div class="p-3 border rounded-md">
                                                <span class="text-zinc-700 text-xs font-semibold">
                                                    {{ $orders->feedback_data->comment ?? 'No comment' }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex gap-3 mt-5">
                                            <div class="flex items-start">
                                                <button onclick="feedback{{ $orders->id }}.showModal()"
                                                    class="text-zinc-700 bg-zinc-50 shadow-none cursor-pointer flex gap-2 text-sm items-center border border-zinc-300 rounded-lg py-2 px-4 w-auto">
                                                    <x-lucide-message-square class="h-4 w-4" />
                                                    <span>Give Feedback</span>
                                                </button>
                                            </div>

                                            @if ($orders->can_request_return)
                                                <button onclick="returnModal{{ $orders->id }}.showModal()"
                                                    class="text-red-500 bg-zinc-50 shadow-none cursor-pointer flex gap-2 text-sm items-center py-2 px-4 w-auto rounded-lg hover:border hover:border-red-400 hover:bg-red-100 transition duration-300 ease-in-out">
                                                    <span>Request Return</span>
                                                </button>
                                            @else
                                                <div class="flex gap-2 p-2 bg-zinc-100 rounded-md">
                                                    <x-lucide-clock-8 class="h-4 w-4 text-zinc-700" />
                                                    <span class="text-xs text-red-500">Return period expired - <span
                                                            class="text-xs text-zinc-700">Returns must be requested
                                                            within 12 hours of
                                                            delivery</span></span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="flex flex-col gap-5 mt-5">

                                    <div class="flex gap-2 items-center">
                                        <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                        <span class="text-zinc-900 text-md font-semibold">Return Requests</span>
                                    </div>
                                    <div class="border border-zinc-300 rounded-lg p-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-semibold text-zinc-700">Order
                                                #{{ $orders->order_id }}</span>
                                            @php
                                                $statusColor = match ($orders->return_data->status) {
                                                    'approved' => 'bg-green-500',
                                                    'pending' => 'bg-gray-500',
                                                    'rejected' => 'bg-red-500',
                                                    default => 'bg-gray-500', // fallback just in case
                                                };
                                            @endphp
                                            <div
                                                class="flex text-xs {{ $statusColor }}  rounded-full p-1 gap-1 text-white items-center px-2">
                                                @if ($orders->return_data->status === 'approved')
                                                    <x-lucide-circle-check-big class="h-3 w-3" />
                                                @elseif($orders->return_data->status === 'rejected')
                                                    <x-lucide-ticket-x class="h-3 w-3" />

                                                @else
                                                    <x-lucide-clock class="h-3 w-3" />
                                                @endif

                                                <span>{{ ucwords(str_replace('_', ' ',$orders->return_data->status)) }} </span>
                                            </div>

                                        </div>
                                        <span class="text-zinc-500 text-xs">Requested on
                                            {{ \Carbon\Carbon::parse($orders->return_data->created_at)->format('M d, Y h:i A') }}</span>

                                        <div class="mt-5">
                                            <span class="text-zinc-700 text-xs font-semibold">Reason for Return</span>
                                            <div class="bg-zinc-100 p-2 rounded-md flex flex-col gap-3">
                                                @if ($orders->return_data->reason_for_return)
                                                    <div class="text-zinc-500 text-xs">
                                                        <span class="font-semibold">Issue:</span>
                                                        {{ $orders->return_data->reason_for_return }}
                                                    </div>
                                                @endif

                                                <span class="text-zinc-500 text-xs">
                                                    Description: {{ $orders->return_data->others }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="flex items-center gap-2 mt-5 text-green-600 text-sm font-medium">
                                    <x-lucide-check-circle class="w-4 h-4" />
                                    <span>Return request submitted</span>
                                </div> --}}
                            @endif


                            <dialog id="returnModal{{ $orders->id }}" class="modal">
                                <div class="modal-box bg-zinc-50">
                                    <form method="dialog">
                                        <button
                                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                                    </form>

                                    <form method="POST" action="{{ url('/return-order') }}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $orders->order_id }}">

                                        <div>
                                            <h3 class="text-lg font-bold text-zinc-700">Return Request for Order
                                                #{{ $orders->order_id }}</h3>
                                            <p class="text-sm text-zinc-500 mt-1">
                                                Please select the issue you encountered with this chicken order.
                                            </p>
                                        </div>

                                        <div class="flex flex-col gap-4 mt-5">

                                            <!-- Return Reason -->
                                            <div>
                                                <label for="reason"
                                                    class="block text-sm text-zinc-600 mb-1 font-medium">Reason for
                                                    Return</label>
                                                <select name="reason" id="reason" required
                                                    class="w-full border border-zinc-300 px-3 py-2 rounded-md text-zinc-800 focus:outline-none focus:border-blue-400">
                                                    <option value="" disabled selected>Select a reason</option>
                                                    <option value="spoiled">Product was spoiled or thawed</option>
                                                    <option value="wrong-weight">Wrong weight or quantity</option>
                                                    <option value="damaged-packaging">Damaged or leaking packaging
                                                    </option>
                                                    <option value="wrong-item">Wrong product delivered</option>
                                                    <option value="contamination">Signs of contamination</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>

                                            <!-- Comments -->
                                            <div>
                                                <label class="block text-sm text-zinc-600 mb-1 font-medium">Additional
                                                    Details (Optional)</label>
                                                <textarea name="comments" rows="4"
                                                    class="w-full border border-zinc-300 px-3 py-2 rounded-md text-zinc-800 focus:outline-none focus:border-blue-400"
                                                    placeholder="Describe the issue you noticed..."></textarea>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                    Submit Return Request
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </dialog>

                            <dialog id="feedback{{ $orders->id }}" class="modal">
                                <div class="modal-box bg-zinc-50">
                                    <form method="dialog">
                                        <button
                                            class="btn btn-sm btn-circle shadow-none btn-ghost hover:bg-zinc-200 hover:border-zinc-200 absolute right-2 top-2 text-zinc-800">✕</button>
                                    </form>
                                    <form method="POST" action="{{ url('/feedback') }}">
                                        @csrf
                                        <div>
                                            <input type="hidden" name="order_id" value="{{ $orders->order_id }}">
                                            <h3 class="text-lg font-bold text-zinc-700">Feedback</h3>
                                            <p class=" text-zinc-500">How was your experience with Order
                                                #{{ $orders->order_id }}</p>
                                        </div>
                                        <div class="flex flex-col mt-5">

                                            <div class="w-full flex flex-col gap-5">

                                                <div x-data="{ rating: 0 }"
                                                    class="flex items-center justify-center gap-1 w-full mt-5">
                                                    <template x-for="star in 5" :key="star">
                                                        <button type="button" @click="rating = star"
                                                            class="focus:outline-none">
                                                            <x-lucide-star x-show="rating < star"
                                                                class="w-10 h-10 text-zinc-300 hover:text-yellow-400 transition" />
                                                            <x-lucide-star x-show="rating >= star"
                                                                class="w-10 h-10 text-yellow-400 transition"
                                                                fill="currentColor" />
                                                        </button>
                                                    </template>
                                                    <input type="hidden" name="rating" :value="rating">
                                                </div>
                                                <div class="mt-5">
                                                    <fieldset class="fieldset">
                                                        <legend class="fieldset-legend text-zinc-600">Comments
                                                            (Optional)</legend>
                                                        <textarea type="text" name="comments"
                                                            class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                                            placeholder="Tell us about your experience..."></textarea>

                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="flex justify-end mt-5">
                                                <button type="submit"
                                                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                    Submit Feedback
                                                </button>
                                            </div>



                                        </div>

                                    </form>
                                </div>
                            </dialog>


                        </div>
                        <!-- You can open the modal using ID.showModal() method -->
                    @endforeach



                    {{-- <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                        <div class="flex justify-between">

                            <div class="flex flex-col">

                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-lg font-semibold">Order 1</span>
                                </div>
                                <span class="text-zinc-500">Ordered on 12/28/2024 • Delivered on 12/30/2024 at
                                    2:30:00
                                    PM</span>
                            </div>

                            <div class="flex flex-col justify-end items-end">
                                <div
                                    class="flex text-xs bg-orange-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                    <x-lucide-truck class="h-3 w-3" />
                                    <span>Delivered</span>
                                </div>
                                <span class="text-lg text-orange-500 font-bold">₱ 9,500</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 mt-5">
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                               
                            </div>
                            <div class="flex flex-col border rounded-lg p-3 border-zinc-300">
                                <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 0.5KG</span>
                                <span class="text-xs text-zinc-600">200 - 100.0kg</span>
                            </div>
                            <hr>
                            <div class="flex gap-2 p-2 bg-zinc-100 rounded-md">
                                <x-lucide-clock-8 class="h-4 w-4 text-zinc-700" />
                                <span class="text-xs text-red-500">Return period expired - <span
                                        class="text-xs text-zinc-700">Returns must be requested within 12 hours of
                                        delivery</span></span>
                            </div>
                            <div class="flex flex-col gap-3 rounded-lg bg-emerald-100 p-3">
                                <div class="flex gap-2 item-center">
                                    <x-lucide-circle-check-big class="h-4 w-4 text-emerald-500" />
                                    <span class="text-zinc-700 text-xs">Feedback Submitted</span>

                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">

                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />
                                        <x-lucide-star class="h-4 w-4 text-yellow-500 fill-yellow-500" />

                                    </div>
                                    <span class="text-zinc-500 text-xs">(5/5)</span>

                                </div>
                                <span class="text-zinc-700 text-xs">no comment</span>
                            </div>

                        </div>



                    </div> --}}
                    {{-- 
                    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 w-1/2 mx-auto">
                        <div class="flex justify-between">

                            <div class="flex flex-col">

                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-lg font-semibold">Order 1</span>
                                </div>
                                <span class="text-zinc-500">Ordered on 12/28/2024 • Delivered on 12/30/2024 at
                                    2:30:00
                                    PM</span>
                            </div>

                            <div class="flex flex-col justify-end items-end">
                                <div
                                    class="flex text-xs bg-orange-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                    <x-lucide-truck class="h-3 w-3" />
                                    <span>Delivered</span>
                                </div>
                                <span class="text-lg text-orange-500 font-bold">₱ 9,500</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 mt-5">
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <div class="flex justify-between border rounded-lg p-3 border-zinc-300 items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-zinc-700">GROUND CHICKEN SKIN ON - 1KG</span>
                                    <span class="text-xs text-zinc-600">100 - 100.0kg</span>
                                </div>
                                <div class="text-zinc-500 text-sm">
                                    <span class="cursor-pointer hover:text-red-500">Return</span>
                                </div>

                            </div>
                            <hr>
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-2 items-center">
                                    <x-lucide-package class="h-5 w-5 text-zinc-700" />
                                    <span class="text-zinc-900 text-md font-semibold">Return Requests</span>
                                </div>

                                <div class="border border-zinc-300 rounded-lg p-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-semibold text-zinc-700">Return #RET-001</span>
                                        <div
                                            class="flex text-xs bg-emerald-500 rounded-full p-1 gap-1 text-white items-center px-2">
                                            <x-lucide-circle-check-big class="h-3 w-3" />
                                            <span>Approved </span>
                                        </div>
                                    </div>
                                    <span class="text-zinc-500 text-xs">GROUND CHICKEN SKIN ON - 1KG - Requested on
                                        12/22/2024</span>

                                    <div class="mt-5">
                                        <span class="text-zinc-700 text-xs font-semibold">Reason for Return</span>
                                        <div class="bg-zinc-200 p-2 rounded-md ">
                                            <span class="text-zinc-500 text-xs">
                                                Hematoma
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="text-zinc-700 cursor-pointer flex gap-2 text-sm items-center border border-zinc-300 rounded-lg py-2 px-4 w-auto">
                                    <x-lucide-message-square class="h-4 w-4" />
                                    <span>Give Feedback</span>
                                </div>
                            </div>

                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
</x-app-layout>
