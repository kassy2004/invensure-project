<x-app-layout>
    @include('layouts.sidebar')
    
        <div class="w-full">
            <div class="w-full px-2 lg:px-4">
                <div class=" overflow-hidden">
                    <div class="lg:p-6">
                        <div class="flex flex-wrap lg:flex-nowrap gap-6 mb-5 mt-5">

                            <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 w-full">
                            <h1 class="text-2xl font-bold text-gray-900">XGBoost Forecast vs. Actual Sales</h1>
                            <div class="inline-flex mt-5 py-1 px-1 rounded-md space-x-2 bg-gray-200">

                                <span class="px-3 py-1 rounded-md cursor-pointer text-xs bg-orange-400 text-gray-100">Weekly</span>
                                <span class="px-3 py-1 rounded-md cursor-pointer text-xs text-gray-900">Monthy</span>
                                <span class="px-3 py-1 rounded-md cursor-pointer text-xs text-gray-900">Quarterly</span>
                            </div>

                            <div class="relative w-full h-130 bg-gray-300 mt-5 border border-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">
                                    Chart
                                </span>

                                <div class="absolute bottom-5 flex lg:gap-10">
                                    <div class="flex gap-2 items-center">
                                        <div class="h-4 w-4 bg-blue-500 rounded-full"></div>
                                        <span class="text-gray-700 text-sm">Actual Sales</span>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="h-4 w-4 bg-yellow-500 rounded-full"></div>
                                        <span class="text-gray-700 text-sm">Dressed Chicken (Medium Seasonality)</span>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="h-4 w-4 bg-green-500 rounded-full"></div>
                                        <span class="text-gray-700 text-sm">Choice Cuts (High Seasonality)</span>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="h-4 w-4 bg-indigo-500 rounded-full"></div>
                                        <span class="text-gray-700 text-sm">Fillet (Medium Seasonality)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mt-5">

                                <div class="flex gap-5">

                                    <div class="flex gap-2">
                                        <span class="text-gray-500">Model:</span>
                                        <span class="text-gray-800">XGBoost v2.3</span>
                                    </div>

                                    <div class="flex gap-2 font-semibold ">
                                        <span class="text-gray-500">Date Range:</span>
                                        <span class="text-gray-800">3 years</span>
                                    </div>
                                </div>

                                <div class="flex gap-5">
                                    <button type="button" class="border border-gray-300 text-gray-700 rounded-md px-4 py-2 text-sm">Export Data</button>
                                    <button type="button" class="bg-gray-900 text-gray-200 rounded-md px-4 py-2 text-sm">Run New Forecast</button>
                                </div>

                            </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </div>
    </x-app-layout>
    