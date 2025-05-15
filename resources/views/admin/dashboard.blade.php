@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
            <p class="mt-1 text-sm text-gray-500">Welcome back, Supply Chain Manager</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <div class="relative">
                <div class="flex items-center">
                    <input type="text" class="w-full sm:w-auto form-input rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" placeholder="Select date range">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button class="btn btn-sm btn-outline border-gray-300 text-gray-700 hover:bg-gray-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
                
                <button class="btn btn-sm btn-outline border-gray-300 text-gray-700 hover:bg-gray-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </div>
        </div>
    </div>
    
    <!-- Metric cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                <div class="p-2 bg-green-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">$1,284,943</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        8.2%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs last month</span>
                </div>
            </div>
        </div>
        
        <!-- Active Orders -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Active Orders</h3>
                <div class="p-2 bg-blue-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">342</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        4.3%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs last week</span>
                </div>
            </div>
        </div>
        
        <!-- Inventory Status -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Inventory Status</h3>
                <div class="p-2 bg-yellow-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">87%</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        2.1%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs optimal level</span>
                </div>
            </div>
        </div>
        
        <!-- Active Users -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
                <div class="p-2 bg-purple-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">127</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        12%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs last month</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab navigation -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="#" class="border-primary text-primary border-b-2 py-4 px-6 text-center text-sm font-medium">
                    Overview
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-6 text-center text-sm font-medium">
                    Analytics
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-6 text-center text-sm font-medium">
                    Reports
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-6 text-center text-sm font-medium">
                    Notifications
                </a>
            </nav>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Progress Overview -->
                <div class="lg:col-span-1 space-y-6">
                    <h3 class="text-lg font-medium text-gray-800">Progress Overview</h3>
                    
                    <!-- Inventory Progress -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Inventory</span>
                            <span class="text-sm font-medium text-gray-700">87%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: 87%"></div>
                        </div>
                        <p class="text-xs text-gray-500">Optimal inventory level maintained</p>
                    </div>
                    
                    <!-- Logistics Progress -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Logistics</span>
                            <span class="text-sm font-medium text-gray-700">92%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-secondary h-2 rounded-full" style="width: 92%"></div>
                        </div>
                        <p class="text-xs text-gray-500">On-time delivery performance</p>
                    </div>
                    
                    <!-- Quality Control Progress -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Quality Control</span>
                            <span class="text-sm font-medium text-gray-700">95%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-accent h-2 rounded-full" style="width: 95%"></div>
                        </div>
                        <p class="text-xs text-gray-500">Product quality compliance rate</p>
                    </div>
                    
                    <div class="pt-4">
                        <button class="btn btn-sm btn-outline w-full border-gray-300 text-gray-700 hover:bg-gray-100">
                            View Detailed Report
                        </button>
                    </div>
                </div>
                
                <!-- Performance Metrics -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Performance Metrics</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <!-- Chart placeholder -->
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-md flex items-center justify-center">
                            <p class="text-gray-500">Performance chart will be displayed here</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <!-- Delivery Performance -->
                            <div class="bg-white p-4 rounded-md shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-500">Delivery</p>
                                        <p class="text-lg font-semibold text-gray-800">98.3%</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Inventory Turnover -->
                            <div class="bg-white p-4 rounded-md shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-500">Inventory Turnover</p>
                                        <p class="text-lg font-semibold text-gray-800">12.5x</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Customer Satisfaction -->
                            <div class="bg-white p-4 rounded-md shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-yellow-100 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-500">Customer Satisfaction</p>
                                        <p class="text-lg font-semibold text-gray-800">4.8/5</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Timeline & Recent Activities -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Activities</h3>
        
        <div class="flow-root">
            <ul class="-mb-8">
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <p class="text-sm text-gray-800">New order <span class="font-medium">#ORD-7895</span> received from <span class="font-medium">Sunny & Scramble's</span></p>
                                    <p class="mt-0.5 text-sm text-gray-500">30 minutes ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <p class="text-sm text-gray-800">Inventory update: <span class="font-medium">Fresh Chicken Breast</span> stock replenished</p>
                                    <p class="mt-0.5 text-sm text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <p class="text-sm text-gray-800"><span class="font-medium">Alert:</span> Temperature fluctuation detected in Cold Storage Unit #3</p>
                                    <p class="mt-0.5 text-sm text-gray-500">5 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <p class="text-sm text-gray-800">System maintenance scheduled for tonight at 2:00 AM</p>
                                    <p class="mt-0.5 text-sm text-gray-500">8 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="mt-6 text-center">
            <a href="#" class="text-sm font-medium text-primary hover:text-accent">View all activities →</a>
        </div>
    </div>
</div>
@endsection 