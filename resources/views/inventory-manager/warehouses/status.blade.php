
    <div class="flex gap-6 flex-wrap lg:flex-nowrap">
        <!-- Total Equipment Card -->
        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total Available Stock</p>
                        </div>
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="p-0 btn h-0 bg-transparent m-0 shadow-none border-none">
                                <x-lucide-eye  class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                            </div>
                          
                            
                            <ul tabindex="0"
                            class="dropdown-content flex flex-col px-2 border border-zinc-300 bg-gray-100 rounded-box z-10 w-98  overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap pb-2">
                            @foreach ($availableItem as $item)
                            {{-- <li
                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                            2024</li> --}}
                            <li class=" text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                <span>No. {{$item->id}}</span>
                                <span class="truncate block max-w-[200px] text-ellipsis overflow-hidden whitespace-nowrap">{{$item->data_entry}}</span>
                                <span>{{$item->left}} days left</span>
                                
                            </li>
                            @endforeach
                           
                        </ul>
                        </div>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ number_format($available) ?? '24,500' }}</p>
                        {{-- <span class="text-xs text-gray-500">+20.1% from last month</span> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Borrowings Card -->
        <div class="bg-zinc-50 rounded-lg p-6 border-2 border-gray-200 w-full ">
            <div class="flex items-center">

                <div class="flex flex-col w-full gap-3">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <p class="text-gray-700 font-semibold text-sm">Total Expiring Soon</p>
                        </div>
                        
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="p-0 btn h-0 bg-transparent m-0 shadow-none border-none">
                                <x-lucide-eye  class="h-5 w-5 shrink-0 text-gray-500 cursor-pointer hover:text-gray-800 transition duration-200 ease-in-out" />
                            </div>
                          
                            
                            <ul tabindex="0"
                            class="dropdown-content flex flex-col px-2 border border-zinc-300 bg-gray-100 rounded-box z-10 w-98  overflow-y-auto max-h-64 overflow-x-auto whitespace-nowrap pb-2">
                            @foreach ($expiringItem as $item)
                            {{-- <li
                            class="text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                            2024</li> --}}
                            <li class=" text-xs text-zinc-500 uppercase font-semibold px-1 flex justify-between mt-3 cursor-pointer hover:bg-zinc-300 py-1 rounded-md">
                                <span>No. {{$item->id}}</span>
                                <span class="truncate block max-w-[200px] text-ellipsis overflow-hidden whitespace-nowrap">{{$item->data_entry}}</span>
                                <span>{{$item->left}} days left</span>
                                
                            </li>
                            @endforeach
                           
                        </ul>
                        </div>
                        
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">  {{ number_format($expiring) ?? '24,500' }}</p>
                    </div>
                </div>
            </div>
        </div>

        
    </div>



   
