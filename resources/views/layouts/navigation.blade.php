<div class="navbar bg-white border-b border-zinc-300">
    <div class="flex-1">
        <x-invensure-logo class="ml-10" />


    </div>
    <div class="flex gap-4">
        <div class="dropdown dropdown-end border-r px-4">
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
            <div tabindex="0" class="card card-compact dropdown-content bg-zinc-50 z-1 mt-3 w-96 shadow h-96">
                <div class="card-body">
                    <div class=" mb-5 flex justify-between items-center text-center">
                        <span class="text-lg font-bold text-zinc-700">Notifications</span>
                        <span class="text-blue-500 cursor-pointer hover:text-blue-400" id="marked">Mark all as
                            read</span>
                    </div>
                    <div class="overflow-y-auto space-y-3 h-68 pr-2" id="notifList">
                        @forelse($global_notifications as $notif)
                            <div class="notif-item border-l-4 gap-4   pl-3 mb-4 flex justify-between h-16 items-center
                            {{ $notif->marked_as_read === 'marked_as_read'
                                ? 'border-gray-300 opacity-70'
                                : ($notif->type === 'warning'
                                    ? 'border-yellow-400'
                                    : ($notif->type === 'error'
                                        ? 'border-red-500'
                                        : ($notif->type === 'info'
                                            ? 'border-blue-500'
                                            : ''))) }}"
                                data-id="{{ $notif->id }}">
                                <div class="w-2/3">
                                    <p class="text-sm font-medium text-gray-800">{{ $notif->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $notif->message }}</p>
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
        <div class="border border-gray-200 py-2 px-3 rounded-md text-gray-600 flex items-center gap-2 cursor-pointer">
            <x-lucide-log-out class="h-4 w-4 shrink-0" />
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm">Sign Out</button>
            </form>

        </div>
    </div>
</div>
<script>
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
