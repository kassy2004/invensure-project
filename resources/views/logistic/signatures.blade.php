<x-app-layout>

    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-2 lg:px-4">
            <div class=" overflow-hidden lg:p-6">

                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-zinc-900">Digital Signatures</h1>
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


                <form method="POST" action="{{ route('signatures.submit') }}">
                    @csrf
                    <div class="flex flex-col lg:flex-row gap-6 mb-5 mt-5 w-full ">
                        <div class="w-full border rounded-lg p-6 bg-zinc-50 border-zinc-300">
                            <div>
                                <h1 class="text-xl font-bold text-zinc-900">Signature Details</h1>
                                <h4 class="text-zinc-700">Enter information for the digital signature</h4>
                            </div>

                            <div class="flex flex-col gap-4 mt-5 pr-2 max-h-128" x-data="{ open: false, search: '', selected: null, truckId: null, signedTypes: [] }">
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Type</legend>
                                    <div class="flex">

                                        <div class="flex gap-2 ml-5 items-center">
                                            <input type="radio" name="type" value="customer"
                                                :disabled="signedTypes.includes('customer')"
                                                class="radio radio-xs bg-red-100 border-orange-300 
        checked:bg-orange-200 checked:text-orange-600 checked:border-orange-600 
        disabled:opacity-50 disabled:cursor-not-allowed" />
                                            <span class="text-zinc-700">Customer</span>
                                        </div>

                                        <div class="flex gap-2 ml-5 items-center">
                                            <input type="radio" name="type" value="driver"
                                                :disabled="signedTypes.includes('driver')"
                                                class="radio radio-xs bg-red-100 border-orange-300 
        checked:bg-orange-200 checked:text-orange-600 checked:border-orange-600 
        disabled:opacity-50 disabled:cursor-not-allowed" />
                                            <span class="text-zinc-700">Driver</span>
                                        </div>

                                        <div class="flex gap-2 ml-5 items-center">
                                            <input type="radio" name="type" value="planner"
                                                :disabled="signedTypes.includes('planner')"
                                                class="radio radio-xs bg-red-100 border-orange-300 
        checked:bg-orange-200 checked:text-orange-600 checked:border-orange-600 
        disabled:opacity-50 disabled:cursor-not-allowed" />
                                            <span class="text-zinc-700">Logistics Staff</span>
                                        </div>

                                    </div>

                                </fieldset>


                                <div class="relative w-full">
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend text-zinc-600">POD Number</legend>
                                    </fieldset>
                                    <input type="text" x-model="search" @focus="open = true"
                                        @click.away="open = false" placeholder="Search or enter POD..."
                                        class="w-full border border-zinc-300 rounded-md px-3 py-2 text-zinc-800" />

                                    <div x-show="open"
                                        class="absolute z-[9999] mt-1 w-full bg-white border border-zinc-300 rounded-md max-h-48 overflow-y-auto">
                                        @forelse ($pod as $items)
                                            <div x-show="`{{ $items->pod_number }}`.toLowerCase().includes(search.toLowerCase())"
                                                @click="
                                                selected = '{{ $items->pod_number }}';
                                                truckId = '{{ $items->truck_id }}';
                                                search = '{{ $items->pod_number }}';
                                                signedTypes = @js($items->signed_types); 
                                                open = false"
                                                class="px-3 py-2 cursor-pointer hover:bg-zinc-100 text-sm text-zinc-700 flex flex-col">
                                                <span>{{ $items->pod_number }}</span>
                                                {{-- <span class="text-gray-500 text-xs">{{ $trucks->driver_name }}</span>
                                                <span class="text-gray-500 text-xs">Capacity:
                                                    {{ $trucks->capacity_kg }}kg</span> --}}
                                                {{-- <span class="text-gray-500 text-xs">Truck ID: {{ $items->truck_id }}</span> --}}
                                            </div>
                                        @empty
                                            <div class="px-3 py-2 text-sm text-zinc-500 select-none">
                                                No PODs available
                                            </div>
                                        @endforelse
                                    </div>
                                    <input type="hidden" name="pod_number" :value="selected" required />
                                    <input type="hidden" name="truck_id" :value="truckId" required />


                                </div
                                {{-- <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">POD Number</legend>
                                    <input type="text" name="pod_number"
                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                        placeholder="Enter POD Number" required />

                                </fieldset> --}}

                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend text-zinc-600">Signatory Name</legend>
                                    <input type="text" name="name"
                                        class="border border-gray-300 px-3 py-2 rounded-md text-gray-800 focus:outline-none focus:text-blue-600 focus:border-blue-400  w-full"
                                        placeholder="Enter name of person signing" required />

                                </fieldset>
                            </div>
                        </div>
                        <div class="w-full border rounded-lg p-6 bg-zinc-50 border-zinc-300">
                            <div class="mb-5">
                                <h1 class="text-xl font-bold text-zinc-900">Signature
                                </h1>
                                <h4 class="text-zinc-700">Use your finger or stylus to sign in the area below</h4>
                            </div>
                            <div>
                                <canvas id="signature"
                                    class="w-full h-64 border border-gray-300 bg-white rounded-lg"></canvas>
                            </div>
                            <div class="flex justify-between mt-3">
                                <button id="clear" type="button"
                                    class="px-6 py-2 text-zinc-700 flex gap-3 text-sm border rounded-md items-center hover:bg-gray-100 transition duration-300">
                                    <x-lucide-undo-2 class="h-4 w-4 " />
                                    <span>Clear</span>

                                </button>
                                <button id="save"
                                    class="px-6 py-2  text-white bg-orange-500 flex gap-3 text-sm border rounded-md items-center hover:bg-orange-400 transition duration-300">
                                    <x-lucide-check class="h-4 w-4 " />
                                    <span>Submit Signature</span>

                                </button>
                            </div>
                            <img id="signature-image" class="mt-4 hidden border rounded" alt="Signature Preview">
                            <input id="signature_path" type="hidden" name="signature_path">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const canvas = document.getElementById('signature');
    const signaturePad = new SignaturePad(canvas);



    function resizeCanvas() {
        const ratio = window.devicePixelRatio || 1;
        const styles = getComputedStyle(canvas);
        const width = parseInt(styles.width);
        const height = parseInt(styles.height);

        canvas.width = width * ratio;
        canvas.height = height * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // Important: clear previous drawing
        signaturePad.clear();
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    document.getElementById('clear').addEventListener('click', () => {
        signaturePad.clear();
    });

    document.getElementById('save').addEventListener('click', () => {
        if (signaturePad.isEmpty()) {
            alert("Please provide a signature.");
            return;
        }
        const dataURL = signaturePad.toDataURL();
        // const img = document.getElementById('signature-image');
        document.getElementById('signature_path').value = dataURL;
        // img.src = dataURL;
        // img.classList.remove('hidden');

    });
</script>
