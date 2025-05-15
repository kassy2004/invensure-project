@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Sales Forecasting</h2>
            <p class="mt-1 text-sm text-gray-500">Predictive analytics for supply chain optimization</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <div class="relative">
                <select class="form-select rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                    <option>Last 12 months</option>
                    <option>Custom range</option>
                </select>
            </div>
            
            <div class="flex space-x-2">
                <button class="btn btn-sm btn-outline border-gray-300 text-gray-700 hover:bg-gray-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
                
                <button class="btn btn-sm bg-primary hover:bg-accent text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Run Forecast
                </button>
            </div>
        </div>
    </div>
    
    <!-- Forecast Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Forecasted Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Forecasted Revenue</h3>
                <div class="p-2 bg-green-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">$1,458,200</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        12.8%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs previous quarter</span>
                </div>
            </div>
        </div>
        
        <!-- Forecasted Orders -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Forecasted Orders</h3>
                <div class="p-2 bg-blue-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">3,842</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        8.5%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs previous quarter</span>
                </div>
            </div>
        </div>
        
        <!-- Forecast Accuracy -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Forecast Accuracy</h3>
                <div class="p-2 bg-yellow-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">94.7%</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm font-medium text-green-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        2.3%
                    </span>
                    <span class="text-xs text-gray-500 ml-2">vs previous model</span>
                </div>
            </div>
        </div>
        
        <!-- Historical Data -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Historical Data</h3>
                <div class="p-2 bg-purple-100 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-semibold text-gray-800">3 years</p>
                <div class="flex items-center mt-2">
                    <span class="text-xs text-gray-500">Last updated: June 15, 2023</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Forecast Chart & Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h3 class="text-lg font-medium text-gray-800">Sales Forecast Comparison</h3>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                <div class="relative">
                    <select class="form-select rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 text-sm py-1">
                        <option>All Products</option>
                        <option>Fresh Chicken</option>
                        <option>Frozen Products</option>
                        <option>Processed Goods</option>
                    </select>
                </div>
                
                <div class="relative">
                    <select class="form-select rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 text-sm py-1">
                        <option>Monthly</option>
                        <option>Quarterly</option>
                        <option>Yearly</option>
                    </select>
                </div>
                
                <div class="relative">
                    <select class="form-select rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 text-sm py-1">
                        <option>Show Seasonality</option>
                        <option>Hide Seasonality</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Chart -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="aspect-w-16 aspect-h-9 bg-white rounded-md border border-gray-200">
                <div class="p-4">
                    <div class="h-full flex items-center justify-center">
                        <p class="text-gray-500">Interactive forecast chart will be displayed here</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="h-3 w-3 bg-primary rounded-full"></span>
                        <span class="ml-2 text-xs text-gray-600">XGBoost Forecast</span>
                    </div>
                    <div class="flex items-center">
                        <span class="h-3 w-3 bg-gray-500 rounded-full"></span>
                        <span class="ml-2 text-xs text-gray-600">Actual Sales</span>
                    </div>
                    <div class="flex items-center">
                        <span class="h-3 w-3 bg-accent opacity-30 rounded-full"></span>
                        <span class="ml-2 text-xs text-gray-600">Confidence Interval</span>
                    </div>
                </div>
                
                <div>
                    <button class="btn btn-xs btn-outline border-gray-300 text-gray-700">
                        Download CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Model Settings & Configuration -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Model Settings -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Model Settings</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">XGBoost v2.3</h4>
                        <p class="text-xs text-gray-500">Current active model</p>
                    </div>
                    <div class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">ARIMA</h4>
                        <p class="text-xs text-gray-500">Secondary model</p>
                    </div>
                    <div class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Available</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Neural Net</h4>
                        <p class="text-xs text-gray-500">Experimental model</p>
                    </div>
                    <div class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Available</div>
                </div>
                
                <div class="pt-4">
                    <button class="btn btn-sm btn-outline w-full border-gray-300 text-gray-700 hover:bg-gray-100">
                        Configure Model Parameters
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Forecast Configuration -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Forecast Configuration</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Forecast Horizon</label>
                        <select class="form-select w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                            <option>3 months</option>
                            <option>6 months</option>
                            <option>12 months</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confidence Level</label>
                        <select class="form-select w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                            <option>80%</option>
                            <option>90%</option>
                            <option>95%</option>
                            <option>99%</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auto-Update Schedule</label>
                    <select class="form-select w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20">
                        <option>Daily (at midnight)</option>
                        <option>Weekly (every Monday)</option>
                        <option>Monthly (1st of month)</option>
                        <option>Manual updates only</option>
                    </select>
                </div>
                
                <div class="flex items-center">
                    <input id="include-seasonality" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="include-seasonality" class="ml-2 block text-sm text-gray-700">Include seasonality adjustments</label>
                </div>
                
                <div class="flex items-center">
                    <input id="auto-alerts" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="auto-alerts" class="ml-2 block text-sm text-gray-700">Enable anomaly detection alerts</label>
                </div>
                
                <div class="pt-4">
                    <button class="btn btn-sm bg-primary hover:bg-accent text-white w-full">
                        Save Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 