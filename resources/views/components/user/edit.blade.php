<x-app-layout>
    @include('layouts.sidebar')
    
        <div class="py-8 w-full">
            <div class="w-full px-2 lg:px-4">
                <div class=" overflow-hidden">
                    <div class="lg:p-6 ">
                        @if (session('success'))
                        <div id="successAlert" role="alert" class="alert alert-success mb-6 transition-opacity duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center">
                            
                            <h1 class="text-2xl font-bold text-gray-900">Edit User Information</h1>
                            {{-- <div class="bg-gray-900 flex items-center px-3 py-2 rounded-md gap-2">
                                <x-lucide-user-plus class="h-4 w-4 shrink-0 text-gray-100"/>
                                <span class="text-gray-100 text-sm">Add New User</span>
                            </div> --}}
                        </div>
                       <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full mt-5">
                        <form method="POST" action="{{ route('users.update', $users->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-col gap-3 mt-5">

                                        <div>
                                            <label class="fieldset-legend text-gray-600 text-sm">Full Name</label>
                                            <input value="{{$users->name}}" type="text" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter full name" name="name"/>
                                        </div>
                                        <div>
                                            <label class="fieldset-legend text-gray-600 text-sm">Email Address</label>
                                            <input value="{{$users->email}}" type="text" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter email address" name="email"/>
                                        </div>
                                    
                                        <div>
                                            <label class="fieldset-legend text-gray-600 text-sm">Role</label>
                                            <select
                                            id="roleSelect"
                                            name="role"
                                            class="select select-primary w-full bg-gray-50 border border-gray-300 text-xs pl-3 text-gray-400"
                                            x-model="selectedRole">
                                                <option value="customer" {{ $users->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                                <option value="inventory_manager" {{ $users->role === 'inventory_manager' ? 'selected' : '' }}>Inventory Manager</option>
                                                <option value="logistics_coordinator" {{ $users->role === 'logistics_coordinator' ? 'selected' : '' }}>Logistics Coordinator</option>
                                                <option value="admin" {{ $users->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>

                                        </div>

                                        <div class="flex justify-center w-full">
                                            <button class="w-full flex gap-2 justify-center bg-orange-500 text-white py-2 px-4 rounded-lg items-center">
                                                <x-lucide-check class="h-5 w-5"/>
                                            Update Changes
                                            </button>
                                        </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </div>
    </x-app-layout>
   