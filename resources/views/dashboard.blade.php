<x-app-layout>
    @include('layouts.sidebar')

    <div class="py-8 w-full">
        <div class="w-full px-4">
            <div class=" overflow-hidden">
                <div class="p-6 ">
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

                        <div x-data="{ tab: 'dashboardOverview' }">
                            <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                                <span @click="tab = 'dashboardOverview'"
                                    :class="tab === 'dashboardOverview' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Overview</span>
                                <span @click="tab = 'analytics'"
                                    :class="tab === 'analytics' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Analytics</span>
                                <span @click="tab = 'reports'"
                                    :class="tab === 'reports' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Reports</span>
                                <span @click="tab = 'notifications'"
                                    :class="tab === 'notifications' ? 'bg-gray-50' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Notifications</span>
                            </div>
                            <div class="flex gap-6 mb-5 mt-5 w-full">
                                <template x-if="tab === 'dashboardOverview'">
                                    @include('components.dashboard.overview')
                                </template>
                                <template x-if="tab === 'analytics'">
                                    @include('components.dashboard.analytics')
                                </template>
                                <template x-if="tab === 'reports'">
                                    @include('components.dashboard.reports')
                                </template>
                                <template x-if="tab === 'notifications'">
                                    @include('components.dashboard.notifications')
                                </template>
                            </div>
                        </div>
                    @endif















                    @if (auth()->check() && auth()->user()->role === 'customer')
                        <h1 class="text-2xl font-bold text-gray-900">Customer Dashboard</h1>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'inventory_manager')
                        <h1 class="text-2xl font-bold text-gray-900">Inventory Manager Dashboard</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
