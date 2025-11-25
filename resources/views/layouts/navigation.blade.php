<div class="navbar bg-white border-b border-zinc-300 z-99">
    <div class="flex-1">
        <x-invensure-logo class=" ml-2 lg:ml-10" />


    </div>
    <div class="flex gap-4">
        <div class="dropdown dropdown-end">
            <button type="button" id="notifBell"
                class="btn btn-ghost btn-circle hover:border-orange-300 hover:bg-transparent shadow-none transition duration-300 ease-in-out ">
                <div class="indicator">
                    <x-lucide-bell class="h-5 w-5 text-zinc-600" />

                    @if ($global_unread_count > 0)
                        <span
                            class="badge badge-xs indicator-item text-2xs bg-orange-500 border-orange-500 unread-badge">
                            {{ $global_unread_count }}
                        </span>
                    @endif
                </div>
            </button>
            <div tabindex="0" class="card card-compact dropdown-content bg-zinc-50 z-1 mt-3 w-86 lg:w-96 shadow h-96">
                <div class="card-body">
                    <div class=" mb-5 flex justify-between items-center text-center">
                        <span class="text-lg font-bold text-zinc-700">Notifications</span>
                        <span class="text-blue-500 cursor-pointer hover:text-blue-400" id="marked">Mark all as
                            read</span>
                    </div>
                    <div class="overflow-y-auto space-y-3 h-68 pr-2" id="notifList">
                        @forelse($global_notifications as $notif)
                            <div class="notif-item border-l-4 gap-4 mt-3  pl-3 mb-4 flex justify-between h-16 items-center
                            {{ $notif->marked_as_read === 'marked_as_read'
                                ? 'border-gray-300 opacity-70'
                                : ($notif->type === 'warning'
                                    ? 'border-yellow-400'
                                    : ($notif->type === 'success'
                                        ? 'border-green-500'
                                        : ($notif->type === 'error'
                                            ? 'border-red-500'
                                            : ($notif->type === 'info'
                                                ? 'border-blue-500'
                                                : '')))) }}"
                                data-id="{{ $notif->id }}">
                                <div class="w-2/3">
                                    <p class="text-sm font-medium text-gray-800">{{ $notif->title }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $notif->message }}</p>
                                </div>
                                <div class="w-1/3 flex justify-center">
                                    <span
                                        class="text-xs text-gray-500 ">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                                </div>

                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No notifications</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown dropdown-end mr-5">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full overflow-hidden">
                    @if (session('google_avatar'))
                        <div class="w-10 rounded-full">
                            <img alt="User Avatar" src="{{ session('google_avatar') }}" class="object-cover" />
                        </div>
                    @else
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-400 text-white font-normal">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                </div>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-white rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li class=" text-gray-500 rounded-md pointer-events-none cursor-default">
                    <div class="flex gap-2 items-center">

                        @if (session('google_avatar'))
                            <div class="w-8 rounded-full">
                                <img alt="User Avatar" src="{{ session('google_avatar') }}" class="object-cover" />
                            </div>
                        @else
                            <div
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-orange-400 text-white font-normal">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <a class="pointer-events-none cursor-default">{{ auth()->user()->name }}</a>
                    </div>

                </li>
                <hr class="my-2">
                <li class="hover:bg-gray-200 text-gray-700 rounded-md ">
                    <a onclick="logoutModal.showModal()" class="hidden lg:flex gap-2">
                        <x-lucide-log-out class="h-4 w-4 shrink-0" />
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <dialog id="logoutModal" class="modal" x-data="{ loading: false }">
            <div class="modal-box bg-zinc-50">
                <h3 class="text-lg font-bold text-zinc-800">Sign Out</h3>
                <p class="text-zinc-600">Do you really want to sign out?</p>
                <div class="flex justify-end mt-5">

                    <div class="flex gap-3">
                        <button type="button" onclick="logoutModal.close()"
                            class="text-gray-400 py-2 px-4 text-sm hover:bg-gray-100 rounded-lg transition ease-in-out duration-300">Cancel</button>


                        <form method="POST" action="{{ route('logout') }}" x-on:submit="loading = true">
                            @csrf
                            <button type="submit" :disabled="loading"
                                class="text-sm py-2 px-4 bg-red-500 rounded-lg text-white hover:bg-red-600  transition ease-in-out duration-300">

                                <span class="flex items-center gap-2">
                                    <span x-show="!loading">Sign Out</span>

                                    <span x-show="loading" class="flex items-center gap-2" x-cloak>
                                        <x-lucide-loader class="w-4 h-4 animate-spin" />
                                    </span>
                                </span>
                            </button>

                        </form>

                    </div>

                </div>




            </div>


        </dialog>



        <div class="flex top-4 right-4 z-50 lg:hidden">
            <button id="mobile-sidebar-toggle" onclick="toggleMobileSidebar()"
                class="p-2 rounded-md bg-white shadow text-gray-800 z-50 relative">
                <x-lucide-menu class="h-6 w-6" />
            </button>
        </div>

        <!-- Dark Overlay -->

    </div>

</div>

<div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"
    onclick="toggleMobileSidebar()">
</div>

<div id="mobile-sidebar"
    class="fixed top-0 bottom-0 z-60 bg-white  right-0 w-64 transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden overflow-y-auto flex flex-col justify-between">

    <!-- Header -->
    <div>

        <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-300">
            <span class="text-lg font-bold text-gray-700">
                @auth
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                @endauth
            </span>
            <button id="mobile-sidebar-toggle" onclick="toggleMobileSidebar()"
                class="p-2 rounded-md bg-white shadow text-gray-800 z-50 relative ">
                <x-lucide-x id="mobile-close-icon" class="h-6 w-6 transition-transform duration-500 ease-in-out" />
            </button>

        </div>

        <!-- Sidebar links -->
        <ul class="space-y-2 py-2 px-2">
            @if (auth()->check() && auth()->user()->role === 'admin')
                <x-sidebar-link label="Dashboard" url="/dashboard" icon="layout-dashboard" />
                <x-sidebar-link label="Sales Forecasting" url="/sales" icon="line-chart" />
                <x-sidebar-link label="Customer" url="/customer" icon="book-user" />
                <x-sidebar-link label="User Management" url="/user" icon="users" />
            @endif

            @if (auth()->check() && auth()->user()->role === 'customer')
                <x-sidebar-link label="Orders" url="/orders" icon="package-2" />
            @endif

            @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                <x-sidebar-label label="Main" />
                <x-sidebar-link label="Dashboard" url="/dashboard" icon="layout-dashboard" />
                <x-sidebar-link label="Item Master" url="/item-master" icon="archive" />
                <x-sidebar-link label="Return Item" url="/return-item" icon="rotate-ccw" />
                <x-sidebar-label label="Warehouse" />
                <x-sidebar-link label="PCSI" url="/warehouse/pcsi" icon="warehouse" />
                <x-sidebar-link label="3JFPC" url="/warehouse/jfpc" icon="warehouse" />
            @endif

            @if (auth()->check() && auth()->user()->role === 'logistics_coordinator')
                <x-sidebar-link label="Delivery Ops." url="/operations" icon="truck" />
                <x-sidebar-link label="POD Automation" url="/pod" icon="clipboard-check" />
                <x-sidebar-link label="Digital Signatures" url="/signatures" icon="pen-tool" />
            @endif


        </ul>
    </div>
    <div class="border-t border-gray-200 px-5 py-4">
        <form method="POST" action="{{ route('logout') }}"
            class="flex items-center gap-2 text-gray-600 justify-end">
            @csrf
            <x-lucide-log-out class="h-4 w-4 shrink-0" />
            <button type="submit" class="text-sm">Sign Out</button>
        </form>
    </div>
</div>
<script>
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('mobile-overlay');
        const isVisible = !sidebar.classList.contains('translate-x-full');
        const icon = document.getElementById('mobile-close-icon');

        if (isVisible) {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        } else {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            icon.classList.add('rotate-180');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const trigger = document.getElementById('notifBell');
        const marked = document.getElementById('marked');


        const badge = document.querySelector('.unread-badge');
        let hasSent = false;
        if (!trigger) {
            console.warn('🔔 Notification trigger not found');
            return;
        }

        const globalUnreadCount = {{ $global_unread_count }};


        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('🔔 Bell clicked');

            if (globalUnreadCount > 0 && !hasSent) {
                hasSent = true;
                fetch('/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        console.log('📡 Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Marked as read:', data);

                        if (badge) badge.remove();


                    })
                    .catch(error => {
                        console.error('❌ Error marking notifications as read:', error);
                    });
            }
        });


        marked.addEventListener('click', function() {
            console.log('Marked as read clicked!');
            fetch('/notifications/marked', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log('📡 Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('✅ Marked as read:', data);

                    if (badge) badge.remove();

                    document.querySelectorAll('.notif-item').forEach(item => {
                        item.classList.remove('border-yellow-400');
                        item.classList.add('border-gray-300', 'opacity-70');
                    });
                })
                .catch(error => {
                    console.error('❌ Error marking notifications as read:', error);
                });
        });
    });
</script>
