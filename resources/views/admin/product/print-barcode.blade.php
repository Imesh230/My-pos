<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode - {{ $product->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        .barcode-container {
            max-width: 300px;
            margin: 0 auto;
            text-align: center;
            border: 2px solid #333;
            padding: 20px;
            background: white;
        }
        
        .product-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .product-price {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            color: #333;
        }
        
        .barcode-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        .product-info {
            font-size: 12px;
            color: #888;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            
            .barcode-container {
                max-width: 100%;
                border: none;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Barcode</button>
    
    <div class="barcode-container">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">Rs {{ number_format($product->price, 2) }}</div>
        
        <div class="barcode">{{ $product->barcode }}</div>
        <div class="barcode-label">Barcode</div>
        
        <div class="product-info">
            <div>Category: {{ $product->category->name ?? 'N/A' }}</div>
            <div>Stock: {{ $product->count }} units</div>
            <div>ID: {{ $product->id }}</div>
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
