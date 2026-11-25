
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Job Order Form</title>

    <style>
        @page {
            size: A4;
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
        }

        .job-meta {
            width: 100%;
            margin-bottom: 18px;
        }

        .job-meta td {
            padding: 4px 0;
        }

        .section-title {
            background: #222;
            color: #fff;
            padding: 6px 9px;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 5px 7px;
            border: 1px solid #ddd;
        }

        .label {
            width: 25%;
            font-weight: bold;
            background: #f5f5f5;
        }

        .services th,
        .services td {
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
        }

        .services th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right !important;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }

        .description {
            border: 1px solid #ddd;
            padding: 9px;
            min-height: 45px;
        }

        .signatures {
            width: 100%;
            margin-top: 55px;
        }

        .signatures td {
            width: 50%;
            text-align: center;
            padding: 8px 20px;
        }

        .signature-line {
            border-top: 1px solid #222;
            padding-top: 6px;
            margin-top: 25px;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            color: #777;
            margin-top: 35px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>BSA AUTO REPAIR SHOP</h1>
        <p>JOB ORDER FORM</p>
    </div>

    {{-- JOB ORDER DETAILS --}}
    <table class="job-meta">
        <tr>
            <td>
                <strong>Job Order No.:</strong>
                JO-{{ str_pad($jobOrder->job_order_id, 6, '0', STR_PAD_LEFT) }}
            </td>

            <td class="text-right">
                <strong>Date Issued:</strong>
                {{ \Carbon\Carbon::parse($jobOrder->date_issued)->format('F d, Y') }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Status:</strong>
                {{ $jobOrder->status }}
            </td>

            <td class="text-right">
                <strong>Expected Completion:</strong>
                {{ $jobOrder->expected_empl_date
                    ? \Carbon\Carbon::parse($jobOrder->expected_empl_date)->format('F d, Y')
                    : 'Not specified' }}
            </td>
        </tr>
    </table>

    {{-- CUSTOMER INFORMATION --}}
    <div class="section-title">CUSTOMER INFORMATION</div>

    <table class="details">
        <tr>
            <td class="label">Customer Name</td>
            <td>
                {{ $jobOrder->customer->first_name ?? '' }}
                {{ $jobOrder->customer->middle_name ?? '' }}
                {{ $jobOrder->customer->last_name ?? '' }}
            </td>
        </tr>

        <tr>
            <td class="label">Contact Number</td>
            <td>{{ $jobOrder->customer->contact_number ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td class="label">Address</td>
            <td>{{ $jobOrder->customer->address ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- VEHICLE INFORMATION --}}
    <div class="section-title">VEHICLE INFORMATION</div>

    <table class="details">
        <tr>
            <td class="label">Plate Number</td>
            <td>{{ $jobOrder->vehicle->plate_number ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td class="label">Make</td>
            <td>{{ $jobOrder->vehicle->make ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td class="label">Engine Model</td>
            <td>{{ $jobOrder->vehicle->engine_model ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- JOB DETAILS --}}
    <div class="section-title">JOB DETAILS</div>

    <strong>Problem Description</strong>
    <div class="description">
        {{ $jobOrder->problem_description }}
    </div>

    {{-- SERVICES --}}
    <div class="section-title">SERVICES</div>

    <table class="services">
        <thead>
            <tr>
                <th style="width: 8%;">No.</th>
                <th>Service</th>
                <th>Description</th>
                <th class="text-right">Price</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($jobOrder->services as $index => $service)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ $service->job_desc ?? 'N/A' }}</td>
                    <td class="text-right">
                        ₱{{ number_format($service->price, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">
                        No services recorded.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total Cost: ₱{{ number_format($jobOrder->total_cost, 2) }}
    </div>

    {{-- ASSIGNED STAFF --}}
    <div class="section-title">ASSIGNED MECHANIC / STAFF</div>

    <table class="details">
        @forelse ($jobOrder->assignments as $assignment)
            <tr>
                <td class="label">Assigned Staff</td>
                <td>
                    {{ $assignment->staff->staff_first ?? '' }}
                    {{ $assignment->staff->staff_middle ?? '' }}
                    {{ $assignment->staff->staff_last ?? '' }}
                </td>
            </tr>

            <tr>
                <td class="label">Assignment Date</td>
                <td>
                    {{ $assignment->assigned_date
                        ? \Carbon\Carbon::parse($assignment->assigned_date)->format('F d, Y')
                        : 'N/A' }}
                </td>
            </tr>

            @if ($assignment->remarks)
                <tr>
                    <td class="label">Assignment Remarks</td>
                    <td>{{ $assignment->remarks }}</td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="2">No staff assigned yet.</td>
            </tr>
        @endforelse
    </table>

    {{-- JOB ORDER REMARKS --}}
    <div class="section-title">REMARKS</div>

    <div class="description">
        {{ $jobOrder->remarks ?? 'No additional remarks.' }}
    </div>

    {{-- SIGNATURES --}}
    <table class="signatures">
        <tr>
            <td>
                <div class="signature-line">
                    Prepared By
                </div>
            </td>

            <td>
                <div class="signature-line">
                    Approved By
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        BSA Auto Repair Shop — Job Order Record
    </div>

</body>
</html>
