<x-app-layout>
    @include('layouts.sidebar')
    
        <div class="py-8 w-full">
            <div class="w-full px-4">
                <div class=" overflow-hidden">
                    <div class="p-6 ">
                        @if (session('success'))
                        <div id="successAlert" role="alert" class="alert alert-success mb-6 transition-opacity duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">

                            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                            {{-- <div class="bg-gray-900 flex items-center px-3 py-2 rounded-md gap-2">
                                <x-lucide-user-plus class="h-4 w-4 shrink-0 text-gray-100"/>
                                <span class="text-gray-100 text-sm">Add New User</span>
                            </div> --}}
                        </div>
                          
                        <div x-data="{ tab: 'allUsers' }">
                            <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                            <span @click="tab = 'allUsers'" :class="tab === 'allUsers' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">All Users</span>
                            <span @click="tab = 'add'" :class="tab === 'add' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Add Users</span>
                            <span @click="tab = 'logs'" :class="tab === 'logs' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Audit Logs</span>
                        </div>

                        <div class="mt-5 w-full">
                            <div x-show="tab === 'allUsers'"   x-transition class="flex flex-col gap-6 w-full ">
                                @include('components.user.all')
                            </div>
                            <div x-show="tab === 'add'"  x-transition class="flex flex-col gap-6 w-full ">
                                @include('components.user.add')
                            </div>
                            <div x-show="tab === 'logs'"  x-transition class="flex flex-col gap-6 w-full ">
                                @include('components.user.logs')
                            </div>
                           
                            </div>
                    </div>


                       
                    </div>
                </div>
            </div>
        </div>
         </div>
    </x-app-layout>
   