<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>POD PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        p {
            font-size: 12px;
        }

        h1,
        h3,
        h4 {
            margin: 4px 0;
        }

        p {
            margin: 2px 0;
        }
    </style>

</head>

<body>
    <h1>Proof of Delivery</h1>

    @foreach ($pods as $pod)
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="text-align: left; border: none;">
                    <h4 style="margin: 0;">Sunny & Scramble</h4>
                </td>
                <td style="text-align: right; border: none;">

                </td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; border: none;">
                    <p style="margin: 0; padding: 0;">Customer: {{ $pod->business_name }}</p>
                </td>
                <td style="text-align: right; border: none;">
                    <p style="margin: 0; padding: 0;">Date:
                        {{ \Carbon\Carbon::parse($pod->created_at)->format('F j, Y') }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; border: none;">
                    <p style="margin: 0; padding: 0;">Address: {{ $pod->address }}</p>
                </td>
                <td style="text-align: right; border: none;">
                    <p style="margin: 0; padding: 0;">Time:
                        {{ \Carbon\Carbon::parse($pod->created_at)->format('h:i A') }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; border: none;">
                    <p style="margin: 0; padding: 0;">Delivery Date:
                        {{ \Carbon\Carbon::parse($pod->created_at)->format('F j, Y') }}</p>
                </td>
                <td style="text-align: right; border: none;">
                    <h4 style="margin: 0; padding: 0; color: #f97316; font-weight: bold;">POD #: {{ $pod->pod_number }}
                    </h4>
                </td>
            </tr>
        </table>


        {{-- <p>Driver: {{ $pod->driver_name }}</p> --}}


        <table style="font-size: 12px">
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Quantity</th>
                    <th>Kilogram</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pod->items as $item)
                    <tr>
                        <td>{{ $item['particulars'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['kilogram'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $pod->total_quantity }}</strong></td>
                    <td><strong>{{ $pod->total_kilogram }}</strong></td>
                </tr>
            </tbody>
        </table>


        <table style="width: 100%; margin-top: 40px; font-size: 14px;">
            <tr>
                {{-- Left Column: Planner + Driver --}}
                <td style="width: 50%; vertical-align: top; padding-right: 16px;">
                    {{-- Prepared By --}}
                    <div style="margin-bottom: 20px;">
                        <div style="margin-bottom: 8px; color: #374151;">
                            <strong>Prepared by:</strong><br>
                            <span>{{ $pod->planner_name }}</span>
                        </div>
                        <div style="text-align: center; font-size: 12px; color: #6b7280;">
                            @if ($pod->planner_signature)
                                <img src="{{ $pod->planner_signature }}" alt="Planner Signature"
                                    style="height: 60px;"><br>
                            @else
                                <div style="height: 60px;"></div>
                            @endif
                            <hr style="border: 0.5px solid #ccc;">
                            <span>Signature over printed name</span>
                        </div>
                    </div>

                    {{-- Driver --}}
                    <div>
                        <div style="margin-bottom: 8px; color: #374151;">
                            <strong>Driver:</strong><br>
                            <span>{{ $pod->driver_name }}</span>
                        </div>
                        <div style="text-align: center; font-size: 12px; color: #6b7280;">
                            @if ($pod->driver_signature)
                                <img src="{{ $pod->driver_signature }}" alt="Driver Signature"
                                    style="height: 60px;"><br>
                            @else
                                <div style="height: 60px;"></div>
                            @endif
                            <hr style="border: 0.5px solid #ccc;">
                            <span>Signature over printed name</span>
                        </div>
                    </div>
                </td>

                {{-- Right Column: Customer + Trucking Info --}}
                <td style="width: 50%; vertical-align: top; padding-left: 16px;">
                    {{-- Customer --}}
                    <div style="margin-bottom: 20px;">
                        <div style="margin-bottom: 8px; color: #374151;">
                            <strong>Customer:</strong><br>
                            <span>{{ $pod->customer_name }}</span>
                        </div>
                        <div style="text-align: center; font-size: 12px; color: #6b7280;">
                            @if ($pod->customer_signature)
                                <img src="{{ $pod->customer_signature }}" alt="Customer Signature"
                                    style="height: 60px;"><br>
                            @else
                                <div style="height: 60px;"></div>
                            @endif
                            <hr style="border: 0.5px solid #ccc;">
                            <span>Signature over printed name</span>
                        </div>
                    </div>

                    {{-- Trucking Details --}}
                    <div style="margin-top: 20px;">
                        <strong>Trucking Details:</strong><br>
                        STS/TR No.: {{ $pod->allocation_id }} &nbsp;&nbsp;&nbsp; SEAL No.:
                        {{ $pod->pod_number }}<br><br>

                        <strong>Trucking Contractor:</strong> {{ $pod->driver_name ?? 'N/A' }}<br><br>
                        <strong>Plate Number:</strong> {{ $pod->plate_number ?? 'N/A' }}
                    </div>
                </td>
            </tr>
        </table>
    @endforeach
</body>

</html>
