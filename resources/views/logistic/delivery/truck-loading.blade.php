<div>
    <h1 class="text-lg font-semibold text-zinc-900">
        Truck Loading Management
    </h1>
    <h4 class="text-zinc-700">Manage truck loading and dispatch operations</h4>
    @foreach ($truck_loading as $item)
        
    <div class=" p-5 bg-zinc-50  h-auto rounded-lg border border-zinc-300 mt-5 hover:shadow-md transition duration-300">

        <div class="flex gap-5 items-center justify-between">
            <h1 class="text-lg font-semibold text-zinc-900">
                {{$item->plate_number}}
            </h1>
            <span class="text-xs rounded-full px-2 py-1
            {{ $item->status === 'delivered' ? 'bg-yellow-500' : 'bg-blue-500' }} text-white">
            {{ ucwords(str_replace('_', ' ', $item->status ?? 'in_transit')) }}
        </span>
        </div>
        <div class="flex text-gray-500 text-xs items-center gap-1">
            <x-lucide-calendar class="h-4 w-4 " />
            <span>Loading Date: {{ \Carbon\Carbon::parse($item->created_at)->format('m/d/Y, h:i A') }}</span>
        </div>

        <div class="flex justify-between w-full">
            <div class="w-full mt-5">
                <span class="text-zinc-700 text-sm font-semibold">Driver Information</span>
                <div class="flex flex-col gap-1 mt-3">

                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-user class="h-3 w-3 " />

                        <span>
                            {{ $item->driver_name}}
                        </span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-phone class="h-3 w-3 " />
                        <span>
                            {{ $item->driver_contact}}
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full mt-5">
                <span class="text-zinc-700 text-sm font-semibold">Load Information</span>
                <div class="flex flex-col gap-1 mt-3">

                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-weight class="h-3 w-3 " />

                        <span>
                            {{ $item->loaded_weight}} kg / {{ $item->capacity_kg}} kg
                        </span>
                    </div>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-package class="h-3 w-3 " />
                        <span>
                            {{ $item->allocation_count}} allocation/s
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <span class="text-zinc-700 text-sm font-semibold mb-2">Allocations</span>
            <div class="border rounded-md p-3 mt-2">
                <div>
                    <span class="text-zinc-700 text-sm ">{{ $item->alloc_id}}</span>
                    <div class="flex text-gray-500 text-xs items-center gap-1">
                        <x-lucide-map-pin class="h-3 w-3 " />
                        <span>{{ $item->address}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
