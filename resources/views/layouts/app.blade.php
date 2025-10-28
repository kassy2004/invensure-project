<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Invensure
        @auth
            @php
                $roles = [
                    'admin' => 'Admin',
                    'customer' => 'Customer',
                    'inventory_manager' => 'Inventory Manager',
                    'logistics_coordinator' => 'Logistics Coordinator',
                ];
                $userRole = auth()->user()->role ?? null;
            @endphp

            {{ isset($roles[$userRole]) ? ' | ' . $roles[$userRole] : '' }}
        @endauth
    </title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="/path/to/starability-all.css"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@29.3.5/styles/ag-grid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@29.3.5/styles/ag-theme-alpine.css" />
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@29.3.5/dist/ag-grid-community.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script type="module" src="https://unpkg.com/cally"></script>
<link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
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
                    'Track current orders',
                    'Submit new orders',
                    'Update account information',
                    'Access product catalog'
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
                console.log('Alpine userForm initialized');
            }
        }
    }


    setTimeout(() => {
        const alertBox = document.getElementById('alert');
        if (alertBox) {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500); // remove after fade-out
        }
    }, 5000);
  
</script>

</html>
