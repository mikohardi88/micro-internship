<!-- Notification Dropdown -->
<div class="relative mr-4">
    <x-dropdown align="right" width="80">
        <x-slot name="trigger">
            <button id="notification-trigger" class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                <i class="fas fa-bell"></i>
                @php
                    $unreadCount = Auth::user()->unreadNotifications()->count();
                @endphp
                @if($unreadCount > 0)
                    <span id="notification-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="block px-4 py-2 text-xs text-gray-400">
                Notifikasi
            </div>

            @forelse(Auth::user()->notifications()->latest()->limit(5)->get() as $notification)
                <a 
                    href="{{ route('notifications.mark-as-read', $notification->id) }}"
                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out 
                           {{ $notification->read_at ? 'bg-white' : 'bg-gray-50' }}"
                >
                    <div class="font-medium">
                        {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">
                        {{ $notification->data['message'] ?? $notification->data['body'] ?? 'Tidak ada pesan' }}
                    </div>
                    
                    @if(is_null($notification->read_at))
                        <span class="inline-block mt-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">
                            Belum dibaca
                        </span>
                    @endif
                </a>
            @empty
                <div class="px-4 py-4 text-sm text-gray-500 text-center">
                    Tidak ada notifikasi
                </div>
            @endforelse

            @if(Auth::user()->notifications()->count() > 0)
                <div class="border-t border-gray-200">
                    <a 
                        href="{{ route('notifications.index') }}" 
                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"
                    >
                        Lihat Semua
                    </a>
                </div>
            @endif
        </x-slot>
    </x-dropdown>
</div>

<script>
    // Update notification count function
    function updateNotificationCount() {
        fetch('{{ route('notifications.unread-count') }}')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('notification-count');
                if (data.count > 0) {
                    if (countElement) {
                        countElement.textContent = data.count;
                    } else {
                        const trigger = document.getElementById('notification-trigger');
                        trigger.innerHTML += `<span id="notification-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">${data.count}</span>`;
                    }
                } else {
                    if (countElement) {
                        countElement.remove();
                    }
                }
            })
            .catch(error => console.error('Error fetching notification count:', error));
    }

    // Update count every 30 seconds
    setInterval(updateNotificationCount, 30000);
</script>