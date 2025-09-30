<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcodes - {{ $products->count() }} Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        .barcode-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .barcode-item {
            border: 2px solid #333;
            padding: 15px;
            text-align: center;
            background: white;
            page-break-inside: avoid;
        }
        
        .product-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
            word-wrap: break-word;
        }
        
        .product-price {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 15px 0;
            padding: 8px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            color: #333;
        }
        
        .barcode-label {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }
        
        .product-info {
            font-size: 10px;
            color: #888;
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            
            .barcode-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }
            
            .no-print {
                display: none;
            }
            
            .barcode-item {
                border: 1px solid #333;
                padding: 10px;
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
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print All Barcodes</button>
    
    <div class="header">
        <h1>Product Barcodes</h1>
        <p>{{ $products->count() }} Products - {{ date('Y-m-d H:i:s') }}</p>
    </div>
    
    <div class="barcode-grid">
        @foreach($products as $product)
        <div class="barcode-item">
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
        @endforeach
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
        
        // Close window after printing
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>
