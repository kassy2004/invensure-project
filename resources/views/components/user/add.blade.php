<div x-data="userForm()" x-init="init" class="flex flex-col lg:flex-row justify-between gap-5 w-full">
    <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
        <h1 class="text-xl text-gray-800 font-semibold">User Information</h1>
        <p class="text-sm text-gray-500">Enter the user’s information and role assignment</p>
        <form action="{{url('/add-user')}}" method="post">
            @csrf
        <div class="flex flex-col gap-3 mt-5">

            <div>
                <label class="fieldset-legend text-gray-600 text-sm">Full Name</label>
                <input type="text" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter full name" name="name"/>
            </div>
            <div>
                <label class="fieldset-legend text-gray-600 text-sm">Email Address</label>
                <input type="text" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter email address" name="email"/>
            </div>
            <div>
                <label class="fieldset-legend text-gray-600 text-sm">Password</label>
                <input type="password" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter password" name="password"/>
            </div>
            <div>
                <label class="fieldset-legend text-gray-600 text-sm">Contact Number</label>
                <input type="text" class="input input-primary bg-gray-50 border border-gray-300 focus:text-gray-800 outline-none text-xs pl-3 w-full text-gray-800" placeholder="Enter contact number" name="number"/>
            </div>
            <div>
                <label class="fieldset-legend text-gray-600 text-sm">Role</label>
                <select
                id="roleSelect"
                 name="role"
                  class="select select-primary w-full bg-gray-50 border border-gray-300 text-xs pl-3 text-gray-400"
                  x-model="selectedRole">
                    <option class="text-gray-400" value="customer">Customer</option>
                    <option class="text-gray-400" value="inventory_manager">Inventory Manager</option>
                    <option class="text-gray-400" value="logistics_coordinator">Logistics Coordinator</option>
                    <option class="text-gray-400" value="admin">Admin</option>
                  </select>

            </div>

            <div class="flex justify-center w-full">
                <button class="w-full flex gap-2 justify-center bg-orange-500 text-white py-2 px-4 rounded-lg items-center">
                    <x-lucide-plus class="h-5 w-5"/>
                  Add User
                </button>
              </div>
        </div>
    </form>

    </div>
    
    {{-- Role permission description --}}
    <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
        <h1 class="text-xl text-gray-800 font-semibold">Role Permissions</h1>
        <p class="text-sm text-gray-500" x-text="`Permissions for ${roleLabels[selectedRole]}`"></p>
        <div id="permissionsList" class="mt-5">
            <template x-for="permission in rolePermissions[selectedRole]" :key="permission">
                <div class="flex item-centers text-gray-800 gap-2 mb-3">
                        <x-lucide-check class="w-5 h-5 text-green-500"/>
                        <span class="text-sm" x-text="permission">View order history</span>
                </div>
            </template>
        </div>

        <div class="bg-gray-200 rounded-md p-4">
            <p class="text-xs text-gray-400">
                Note: Role permissions are predefined based on organizational needs. Contact the system administrator for custom permission requests.
            </p>
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    function userForm() {
        return {
            selectedRole: 'customer',
            roleLabels: {
                customer: 'Customer',
                inventory_manager: 'Inventory Manager',
                logistics_coordinator: 'Logistics Coordinator',
                admin: 'Admin',
            },
            rolePermissions: {
                customer: [
                    'View order history',
                    'Submit new orders',
                    'Request return',
                    'Submit feedback',
                    
                ],
                inventory_manager: [
                    'Manage product inventory',
                    'Update stock levels',
                    'Generate inventory reports',
                    'View supplier details'
                ],
                logistics_coordinator: [
                    'Assign delivery personnel',
                    'Track shipment statuses',
                    'Coordinate delivery schedules',
                    'Update logistics records'
                ],
                admin: [
                    'Create and manage users',
                    'Access all system data',
                    'Modify application settings',
                    'Audit system activities'
                ]
            },
            init() {
                this.selectedRole = 'customer';
    // Call updatePermissions to sync any dependent UI or logic
    this.updatePermissions();
                console.log('Alpine userForm initialized');
            }
        }
    }
</script>

