<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Bill - {{ $repair->repair_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .bill-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .bill-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .bill-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: bold;
        }
        .bill-header p {
            margin: 5px 0 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .bill-content {
            padding: 30px;
        }
        .bill-section {
            margin-bottom: 30px;
        }
        .bill-section h3 {
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            min-width: 150px;
        }
        .info-value {
            color: #333;
            text-align: right;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-diagnosed { background-color: #17a2b8; color: #fff; }
        .status-in_progress { background-color: #007bff; color: #fff; }
        .status-completed { background-color: #28a745; color: #fff; }
        .status-delivered { background-color: #28a745; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
        .cost-highlight {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        .cost-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        .bill-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        @media print {
            .print-btn { display: none; }
            .bill-container { box-shadow: none; margin: 0; }
            body { background: white; }
        }
    </style>
</head>
<body>
    <button class="btn btn-primary print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Print Bill
    </button>

    <div class="bill-container">
        <!-- Bill Header -->
        <div class="bill-header">
            <h1><i class="fas fa-tools"></i> REPAIR BILL</h1>
            <p>{{ $shopSettings->shop_name }}</p>
            <p>{{ $shopSettings->contact_number }} | {{ $shopSettings->email }}</p>
            <p>{{ $shopSettings->address }}</p>
        </div>

        <!-- Bill Content -->
        <div class="bill-content">
            <!-- Repair Information -->
            <div class="bill-section">
                <h3><i class="fas fa-wrench"></i> Repair Information</h3>
                <div class="info-row">
                    <span class="info-label">Repair Code:</span>
                    <span class="info-value"><strong>{{ $repair->repair_code }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $repair->status }}">
                            {{ $repair->status_text }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Received Date:</span>
                    <span class="info-value">{{ $repair->received_date->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estimated Completion:</span>
                    <span class="info-value">
                        {{ $repair->estimated_completion ? $repair->estimated_completion->format('M d, Y') : 'Not set' }}
                    </span>
                </div>
                @if($repair->completed_date)
                <div class="info-row">
                    <span class="info-label">Completed Date:</span>
                    <span class="info-value">{{ $repair->completed_date->format('M d, Y') }}</span>
                </div>
                @endif
                @if($repair->delivered_date)
                <div class="info-row">
                    <span class="info-label">Delivered Date:</span>
                    <span class="info-value">{{ $repair->delivered_date->format('M d, Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Customer Information -->
            <div class="bill-section">
                <h3><i class="fas fa-user"></i> Customer Information</h3>
                <div class="info-row">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-value"><strong>{{ $repair->customer_name }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone Number:</span>
                    <span class="info-value">{{ $repair->customer_phone }}</span>
                </div>
                @if($repair->customer_email)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $repair->customer_email }}</span>
                </div>
                @endif
            </div>

            <!-- Device Information -->
            <div class="bill-section">
                <h3><i class="fas fa-mobile-alt"></i> Device Information</h3>
                <div class="info-row">
                    <span class="info-label">Device Brand:</span>
                    <span class="info-value"><strong>{{ $repair->device_brand }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Device Model:</span>
                    <span class="info-value">{{ $repair->device_model }}</span>
                </div>
                @if($repair->device_imei)
                <div class="info-row">
                    <span class="info-label">IMEI Number:</span>
                    <span class="info-value">{{ $repair->device_imei }}</span>
                </div>
                @endif
            </div>

            <!-- Problem Description -->
            <div class="bill-section">
                <h3><i class="fas fa-exclamation-triangle"></i> Problem Description</h3>
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107;">
                    <p style="margin: 0; color: #333;">{{ $repair->problem_description }}</p>
                </div>
            </div>

            <!-- Repair Notes -->
            @if($repair->repair_notes)
            <div class="bill-section">
                <h3><i class="fas fa-sticky-note"></i> Repair Notes</h3>
                <div style="background-color: #e3f2fd; padding: 15px; border-radius: 5px; border-left: 4px solid #2196f3;">
                    <p style="margin: 0; color: #333;">{{ $repair->repair_notes }}</p>
                </div>
            </div>
            @endif

            <!-- Cost Information -->
            <div class="bill-section">
                <h3><i class="fas fa-dollar-sign"></i> Cost Information</h3>
                <div class="cost-highlight">
                    <div class="info-row">
                        <span class="info-label">Estimated Cost:</span>
                        <span class="info-value cost-amount">Rs {{ number_format($repair->estimated_cost, 2) }}</span>
                    </div>
                    @if($repair->final_cost)
                    <div class="info-row">
                        <span class="info-label">Final Cost:</span>
                        <span class="info-value cost-amount">Rs {{ number_format($repair->final_cost, 2) }}</span>
                    </div>
                    @endif
                    @if($repair->technician)
                    <div class="info-row">
                        <span class="info-label">Technician:</span>
                        <span class="info-value">{{ $repair->technician }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Warranty Information -->
            @if($repair->warranty_info)
            <div class="bill-section">
                <h3><i class="fas fa-shield-alt"></i> Warranty Information</h3>
                <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;">
                    <p style="margin: 0; color: #333;">{{ $repair->warranty_info }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Bill Footer -->
        <div class="bill-footer">
            <p style="margin: 0; color: #666;">
                <strong>Thank you for choosing {{ $shopSettings->shop_name }}!</strong><br>
                {{ $shopSettings->footer_notice }}
            </p>
            <p style="margin: 10px 0 0 0; color: #999; font-size: 0.9rem;">
                Bill Generated on: {{ now()->format('M d, Y H:i') }}
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
