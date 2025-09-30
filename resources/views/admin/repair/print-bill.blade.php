<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Bill - {{ $repair->repair_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.2;
            color: #000;
            background: white;
            width: 80mm;
            margin: 0 auto;
        }
        
        .receipt {
            width: 80mm;
            max-width: 80mm;
            margin: 0;
            padding: 2mm;
            background: white;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }
        
        .shop-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 1mm;
        }
        
        .shop-details {
            font-size: 9px;
            margin-bottom: 0.5mm;
        }
        
        .repair-code {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 2mm 0;
            padding: 1mm;
            border: 1px solid #000;
        }
        
        .section {
            margin-bottom: 2mm;
        }
        
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 1mm;
            font-size: 10px;
        }
        
        .info-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5mm;
            font-size: 10px;
        }
        
        .label {
            font-weight: bold;
        }
        
        .value {
            text-align: right;
        }
        
        .status {
            padding: 0.5mm 1mm;
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            margin: 0.5mm 0;
            font-size: 9px;
        }
        
        .problem-box {
            border: 1px solid #000;
            padding: 1mm;
            margin: 1mm 0;
            background: white;
            font-size: 9px;
        }
        
        .cost-section {
            border: 2px solid #000;
            padding: 2mm;
            margin: 2mm 0;
            text-align: center;
        }
        
        .cost-amount {
            font-size: 12px;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 2mm;
            margin-top: 3mm;
        }
        
        .footer-notice {
            font-size: 9px;
            margin-bottom: 1mm;
        }
        
        .date-info {
            font-size: 8px;
            color: #666;
        }
        
        @media print {
            body { 
                margin: 0; 
                padding: 0;
                width: 80mm;
            }
            .receipt { 
                margin: 0; 
                padding: 1mm;
                width: 80mm;
            }
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
        
        /* Status colors - removed for thermal printing */
        .status-pending { background: white; }
        .status-diagnosed { background: white; }
        .status-in_progress { background: white; }
        .status-completed { background: white; }
        .status-delivered { background: white; }
        .status-cancelled { background: white; }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="shop-name">{{ $shopSettings->shop_name }}</div>
            <div class="shop-details">{{ $shopSettings->contact_number }}</div>
            <div class="shop-details">{{ $shopSettings->email }}</div>
            <div class="shop-details">{{ $shopSettings->address }}</div>
        </div>
        
        <!-- Repair Code -->
        <div class="repair-code">
            REPAIR BILL<br>
            {{ $repair->repair_code }}
        </div>
        
        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">CUSTOMER INFORMATION</div>
            <div class="info-line">
                <span class="label">Name:</span>
                <span class="value">{{ $repair->customer_name }}</span>
            </div>
            <div class="info-line">
                <span class="label">Phone:</span>
                <span class="value">{{ $repair->customer_phone }}</span>
            </div>
            @if($repair->customer_email)
            <div class="info-line">
                <span class="label">Email:</span>
                <span class="value">{{ $repair->customer_email }}</span>
            </div>
            @endif
        </div>
        
        <!-- Device Info -->
        <div class="section">
            <div class="section-title">DEVICE INFORMATION</div>
            <div class="info-line">
                <span class="label">Brand:</span>
                <span class="value">{{ $repair->device_brand }}</span>
            </div>
            <div class="info-line">
                <span class="label">Model:</span>
                <span class="value">{{ $repair->device_model }}</span>
            </div>
            @if($repair->device_imei)
            <div class="info-line">
                <span class="label">IMEI:</span>
                <span class="value">{{ $repair->device_imei }}</span>
            </div>
            @endif
        </div>
        
        <!-- Status -->
        <div class="section">
            <div class="section-title">REPAIR STATUS</div>
            <div class="status status-{{ $repair->status }}">
                {{ strtoupper($repair->status_text) }}
            </div>
        </div>
        
        <!-- Dates -->
        <div class="section">
            <div class="section-title">DATES</div>
            <div class="info-line">
                <span class="label">Received:</span>
                <span class="value">{{ $repair->received_date->format('M d, Y') }}</span>
            </div>
            @if($repair->estimated_completion)
            <div class="info-line">
                <span class="label">Est. Completion:</span>
                <span class="value">{{ $repair->estimated_completion->format('M d, Y') }}</span>
            </div>
            @endif
            @if($repair->completed_date)
            <div class="info-line">
                <span class="label">Completed:</span>
                <span class="value">{{ $repair->completed_date->format('M d, Y') }}</span>
            </div>
            @endif
            @if($repair->delivered_date)
            <div class="info-line">
                <span class="label">Delivered:</span>
                <span class="value">{{ $repair->delivered_date->format('M d, Y') }}</span>
            </div>
            @endif
        </div>
        
        <!-- Problem Description -->
        <div class="section">
            <div class="section-title">PROBLEM DESCRIPTION</div>
            <div class="problem-box">
                {{ $repair->problem_description }}
            </div>
        </div>
        
        <!-- Repair Notes -->
        @if($repair->repair_notes)
        <div class="section">
            <div class="section-title">REPAIR NOTES</div>
            <div class="problem-box">
                {{ $repair->repair_notes }}
            </div>
        </div>
        @endif
        
        <!-- Cost Information -->
        <div class="section">
            <div class="section-title">COST INFORMATION</div>
            <div class="cost-section">
                <div class="info-line">
                    <span class="label">Estimated Cost:</span>
                    <span class="value cost-amount">Rs {{ number_format($repair->estimated_cost, 2) }}</span>
                </div>
                @if($repair->final_cost)
                <div class="info-line">
                    <span class="label">Final Cost:</span>
                    <span class="value cost-amount">Rs {{ number_format($repair->final_cost, 2) }}</span>
                </div>
                @endif
                @if($repair->technician)
                <div class="info-line">
                    <span class="label">Technician:</span>
                    <span class="value">{{ $repair->technician }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Warranty -->
        @if($repair->warranty_info)
        <div class="section">
            <div class="section-title">WARRANTY INFORMATION</div>
            <div class="problem-box">
                {{ $repair->warranty_info }}
            </div>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-notice">
                {{ $shopSettings->footer_notice }}
            </div>
            <div class="date-info">
                Generated: {{ now()->format('M d, Y H:i') }}
            </div>
        </div>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
        
        // Close window after printing
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>
