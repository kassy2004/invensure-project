<x-app-layout>
    @include('layouts.sidebar')
    
        <div class="py-8 w-full">
            <div class="w-full px-4">
                <div class=" overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between">
                            <h1 class="text-2xl font-bold text-gray-900">Delivery & Logistics</h1>
                            <span class="px-5 py-3 text-sm bg-gray-900 text-white rounded-md cursor-pointer">Schedule New Delivery</span>
                        </div>
                        <div x-data="{ tab: 'overview' }">
                            <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">
                                <span @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs  text-gray-900">Overview</span>
                                <span @click="tab = 'active'" :class="tab === 'active' ? 'bg-gray-50' : 'bg-gray-200'"  class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Active Deliveries</span>
                                <span @click="tab = 'pod'" :class="tab === 'pod' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Proof of Delivery</span>
                                <span @click="tab = 'performance'" :class="tab === 'performance' ? 'bg-gray-50' : 'bg-gray-200'" class="px-4 py-2 rounded-md cursor-pointer text-xs text-gray-900">Performance</span>
                            </div>

                            <div class="flex gap-6 mb-5 mt-5 w-full">
                                <template x-if="tab === 'overview'"  >
                                    @include('components.delivery.overview')
                                </template>
                                <template x-if="tab === 'active'">
                                    @include('components.delivery.active')
                                </template>
                                <template x-if="tab === 'pod'">
                                    @include('components.delivery.pod')
                                </template>
                                <template x-if="tab === 'performance'">
                                    @include('components.delivery.performance')
                                </template>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
         </div>
    </x-app-layout>
    