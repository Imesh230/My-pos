@extends('admin.layouts.master')

@section('content')
    <!-- Mobile Responsive Styles for Cashier Screen -->
    <style>
        @media (max-width: 768px) {
            .cashier-container {
                padding: 0.5rem;
            }
            
            .product-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }
            
            .product-card {
                padding: 0.5rem;
                margin-bottom: 0.5rem;
            }
            
            .product-card img {
                width: 60px;
                height: 60px;
            }
            
            .product-card h6 {
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
            
            .product-card .price {
                font-size: 0.75rem;
            }
            
            .cart-item {
                padding: 0.5rem;
                border-bottom: 1px solid #eee;
            }
            
            .cart-item .item-details {
                font-size: 0.875rem;
            }
            
            .cart-item .quantity-controls {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .quantity-controls .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .cart-summary {
                font-size: 0.875rem;
            }
            
            .payment-section {
                margin-top: 1rem;
            }
            
            .payment-section .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .btn-checkout {
                width: 100%;
                padding: 0.75rem;
                font-size: 1rem;
                margin-top: 1rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .receipt-content {
                font-size: 12px;
                padding: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            
            .product-card {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .product-card img {
                width: 50px;
                height: 50px;
            }
            
            .cart-item {
                padding: 0.25rem;
            }
            
            .cart-item .item-details {
                font-size: 0.75rem;
            }
        }
        
        /* Touch-friendly elements */
        @media (hover: none) and (pointer: coarse) {
            .product-card {
                min-height: 80px;
                cursor: pointer;
            }
            
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .quantity-controls .btn {
                min-height: 36px;
                min-width: 36px;
            }
        }
    </style>
    
    <!-- Cashier Screen -->
    <div class="container-fluid">
        <div class="row">
            <!-- Product Selection Panel -->
            <div class="col-lg-8 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Selection</h6>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="barcodeScanner" class="form-control" placeholder="Scan barcode or enter barcode..." autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <select id="categoryFilter" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div class="row product-grid" id="productGrid">
                            @foreach($products as $product)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 product-item" data-category="{{ $product->category_id }}">
                                    <div class="card h-100 product-card" data-product-id="{{ $product->id }}">
                                        <img src="{{ asset('productImages/' . $product->image) }}" 
                                             class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $product->name }}</h6>
                                            <p class="card-text text-primary font-weight-bold">Rs {{ $product->price }}</p>
                                            <p class="card-text small">Stock: {{ $product->count }}</p>
                                            <button class="btn btn-primary btn-sm w-100 add-to-cart" 
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-product-price="{{ $product->price }}"
                                                    data-product-stock="{{ $product->count }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart and Checkout Panel -->
            <div class="col-lg-4 col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Shopping Cart</h6>
                    </div>
                    <div class="card-body">
                        <div id="cartItems">
                            <p class="text-muted text-center">No items in cart</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong id="cartTotal">Rs 0</strong>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" id="customerName" class="form-control" placeholder="Walk-in Customer">
                        </div>
                        <div class="mb-3">
                            <label for="customerPhone" class="form-label">Phone (Optional)</label>
                            <input type="text" id="customerPhone" class="form-control" placeholder="Phone number">
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Payment</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="kpay">KPay</option>
                                <option value="wave">Wave Money</option>
                                <option value="ezcash">eZ Cash</option>
                                <option value="mobitel">Mobitel Pay</option>
                                <option value="dialog">Dialog Pay</option>
                                <option value="installment">Installment Plan</option>
                            </select>
                        </div>
                        
                        <!-- Cash Payment Section -->
                        <div id="cashPaymentSection" style="display: none;">
                            <div class="mb-3">
                                <label for="amountReceived" class="form-label">Amount Received (Rs)</label>
                                <input type="number" id="amountReceived" class="form-control" placeholder="Enter amount received" min="0" step="0.01">
                            </div>
                            <div class="alert alert-info" id="balanceInfo" style="display: none;">
                                <strong>Balance to Return: <span id="balanceAmount">Rs 0</span></strong>
                            </div>
                        </div>
                        
                        <button id="processSale" class="btn btn-success btn-lg w-100" disabled>
                            <i class="fa-solid fa-cash-register"></i> Process Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Sale Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="receiptContent">
                    <!-- Receipt content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-section')
<script>
let cart = [];
let total = 0;

// Add to cart functionality
$(document).on('click', '.add-to-cart', function() {
    const productId = $(this).data('product-id');
    const productName = $(this).data('product-name');
    const productPrice = $(this).data('product-price');
    const productStock = $(this).data('product-stock');
    
    // Check if product already in cart
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        if (existingItem.quantity < productStock) {
            existingItem.quantity++;
        } else {
            alert('Not enough stock!');
            return;
        }
    } else {
        if (productStock > 0) {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1,
                stock: productStock
            });
        } else {
            alert('Product out of stock!');
            return;
        }
    }
    
    updateCartDisplay();
});

// Remove from cart
$(document).on('click', '.remove-from-cart', function() {
    const productId = $(this).data('product-id');
    cart = cart.filter(item => item.id !== productId);
    updateCartDisplay();
});

// Update quantity
$(document).on('change', '.quantity-input', function() {
    const productId = $(this).data('product-id');
    const newQuantity = parseInt($(this).val());
    const item = cart.find(item => item.id === productId);
    
    if (item) {
        if (newQuantity <= 0) {
            cart = cart.filter(item => item.id !== productId);
        } else if (newQuantity <= item.stock) {
            item.quantity = newQuantity;
        } else {
            alert('Not enough stock!');
            $(this).val(item.quantity);
            return;
        }
    }
    
    updateCartDisplay();
});

// Update cart display
function updateCartDisplay() {
    const cartItems = $('#cartItems');
    total = 0;
    
    if (cart.length === 0) {
        cartItems.html('<p class="text-muted text-center">No items in cart</p>');
        $('#processSale').prop('disabled', true);
    } else {
        let html = '';
        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <small class="font-weight-bold">${item.name}</small><br>
                        <small class="text-muted">Rs ${item.price} x ${item.quantity}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="number" class="form-control form-control-sm quantity-input" 
                               value="${item.quantity}" min="1" max="${item.stock}" 
                               data-product-id="${item.id}" style="width: 60px;">
                        <button class="btn btn-sm btn-danger ml-1 remove-from-cart" 
                                data-product-id="${item.id}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        cartItems.html(html);
        $('#processSale').prop('disabled', false);
    }
    
    $('#cartTotal').text('Rs ' + total.toLocaleString());
}

// Payment method change handler
$('#paymentMethod').change(function() {
    const paymentMethod = $(this).val();
    if (paymentMethod === 'cash') {
        $('#cashPaymentSection').show();
        $('#amountReceived').focus();
    } else {
        $('#cashPaymentSection').hide();
        $('#balanceInfo').hide();
    }
});

// Amount received change handler
$('#amountReceived').on('input', function() {
    const amountReceived = parseFloat($(this).val()) || 0;
    const total = getCartTotal();
    const balance = amountReceived - total;
    
    if (amountReceived > 0) {
        $('#balanceInfo').show();
        $('#balanceAmount').text('Rs ' + balance.toLocaleString());
        
        if (balance >= 0) {
            $('#balanceInfo').removeClass('alert-danger').addClass('alert-success');
            $('#processSale').prop('disabled', false);
        } else {
            $('#balanceInfo').removeClass('alert-success').addClass('alert-danger');
            $('#processSale').prop('disabled', true);
        }
    } else {
        $('#balanceInfo').hide();
        $('#processSale').prop('disabled', true);
    }
});

// Get cart total
function getCartTotal() {
    let total = 0;
    cart.forEach(item => {
        total += item.price * item.quantity;
    });
    return total;
}

// Process sale
$('#processSale').click(function() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }
    
    const paymentMethod = $('#paymentMethod').val();
    if (!paymentMethod) {
        alert('Please select payment method!');
        return;
    }
    
    // For cash payments, check if amount received is sufficient
    if (paymentMethod === 'cash') {
        const amountReceived = parseFloat($('#amountReceived').val()) || 0;
        const total = getCartTotal();
        
        if (amountReceived < total) {
            alert('Amount received is less than total amount!');
            return;
        }
    }
    
    const customerName = $('#customerName').val() || 'Walk-in Customer';
    const customerPhone = $('#customerPhone').val() || '';
    const amountReceived = paymentMethod === 'cash' ? parseFloat($('#amountReceived').val()) || 0 : getCartTotal();
    
    const saleData = {
        products: cart.map(item => ({
            id: item.id,
            quantity: item.quantity
        })),
        customer_name: customerName,
        customer_phone: customerPhone,
        payment_method: paymentMethod,
        amount_received: amountReceived,
        _token: '{{ csrf_token() }}'
    };
    
    $.ajax({
        url: '{{ route("cashier.quick-sale") }}',
        method: 'POST',
        data: saleData,
        success: function(response) {
            if (response.success) {
                showReceipt(response);
                // Clear cart and form
                cart = [];
                updateCartDisplay();
                $('#customerName').val('');
                $('#customerPhone').val('');
                $('#paymentMethod').val('');
                $('#amountReceived').val('');
                $('#cashPaymentSection').hide();
                $('#balanceInfo').hide();
            }
        },
        error: function(xhr) {
            alert('Error processing sale: ' + xhr.responseJSON.message);
        }
    });
});

// Show receipt
function showReceipt(saleData) {
    // Get shop settings via AJAX
    $.get('{{ route("shop.settings.get") }}', function(shopSettings) {
        // Get current values
        const amountReceived = parseFloat($('#amountReceived').val()) || 0;
        const totalAmount = saleData.total_amount;
        const paymentMethod = $('#paymentMethod').val();
        const changeAmount = Math.max(0, amountReceived - totalAmount);
        
        // Ensure amount received is properly set for cash payments
        const finalAmountReceived = paymentMethod === 'cash' ? amountReceived : totalAmount;
        
        // Debug: Log values (remove in production)
        console.log('Amount Received:', amountReceived);
        console.log('Total Amount:', totalAmount);
        console.log('Payment Method:', paymentMethod);
        console.log('Change Amount:', changeAmount);
        console.log('Final Amount Received:', finalAmountReceived);
        
        const receiptContent = `
            <div class="professional-receipt" style="width: 100%; max-width: 600px; font-family: 'Courier New', monospace; background: white; color: black; line-height: 1.4; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <!-- Company Header -->
                <div style="text-align: center; margin-bottom: 15px;">
                    ${shopSettings.logo ? `<img src="/shopAssets/${shopSettings.logo}" style="max-height: 40px; margin-bottom: 8px;" alt="Logo"><br>` : ''}
                    <div style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">${shopSettings.shop_name}</div>
                    <div style="font-size: 12px; margin-bottom: 2px;">${shopSettings.address}</div>
                    <div style="font-size: 12px; margin-bottom: 2px;">Phone: ${shopSettings.contact_number}</div>
                    <div style="font-size: 12px; margin-bottom: 8px;">Email: ${shopSettings.email}</div>
                </div>
                
                <!-- Receipt Details -->
                <div style="border-top: 1px dotted #000; border-bottom: 1px dotted #000; padding: 8px 0; margin-bottom: 8px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Receipt No.:</span>
                        <span style="font-weight: bold;">${saleData.order_code}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Date and Time:</span>
                        <span>${new Date().toLocaleDateString()}. ${new Date().toLocaleTimeString()}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span>User:</span>
                        <span>${$('#customerName').val() || 'Walk-in Customer'}</span>
                    </div>
                </div>
                
                <!-- Items Section -->
                <div style="border-bottom: 1px dotted #000; padding-bottom: 8px; margin-bottom: 8px;">
                    ${cart.map(item => `
                        <div style="margin-bottom: 6px;">
                            <div style="font-size: 13px; font-weight: bold; margin-bottom: 2px;">${item.name}</div>
                            <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 2px;">
                                <span>${item.quantity}x Rs ${item.price.toLocaleString()}</span>
                                <span>Rs ${(item.price * item.quantity).toLocaleString()}</span>
                            </div>
                        </div>
                    `).join('')}
                    <div style="font-size: 12px; margin-top: 4px; text-align: right;">
                        Items count: ${cart.length}
                    </div>
                </div>
                
                <!-- Summary Section -->
                <div style="border-bottom: 1px dotted #000; padding-bottom: 8px; margin-bottom: 8px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Subtotal:</span>
                        <span>Rs ${saleData.total_amount.toLocaleString()}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Tax 0.00%:</span>
                        <span>Rs 0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; margin-top: 4px;">
                        <span>TOTAL:</span>
                        <span>Rs ${saleData.total_amount.toLocaleString()}</span>
                    </div>
                </div>
                
                <!-- Payment Section -->
                <div style="border-bottom: 1px dotted #000; padding-bottom: 8px; margin-bottom: 8px;">
                    ${paymentMethod === 'cash' ? `
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Payment Method:</span>
                        <span>Cash</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Amount Received (Rs):</span>
                        <span>Rs ${finalAmountReceived.toLocaleString()}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Paid amount:</span>
                        <span>Rs ${totalAmount.toLocaleString()}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span>Change:</span>
                        <span>Rs ${Math.max(0, finalAmountReceived - totalAmount).toLocaleString()}</span>
                    </div>
                    ` : `
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
                        <span>Payment Method:</span>
                        <span>${$('#paymentMethod option:selected').text()}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span>Paid amount:</span>
                        <span>Rs ${totalAmount.toLocaleString()}</span>
                    </div>
                    `}
                </div>
                
                <!-- Footer -->
                <div style="text-align: center; font-size: 12px; margin-top: 8px;">
                    <div>${shopSettings.footer_notice}</div>
                </div>
            </div>
        `;
        
        $('#receiptContent').html(receiptContent);
        $('#receiptModal').modal('show');
    });
}

// Print receipt
function printReceipt() {
    const printContent = document.getElementById('receiptContent').innerHTML;
    const printWindow = window.open('', '', 'height=600,width=400');
    printWindow.document.write(`
        <html>
            <head>
                <title>Professional Receipt</title>
                <style>
                    @media print {
                        @page { 
                            size: 80mm auto; 
                            margin: 0; 
                        }
                        body { 
                            margin: 0; 
                            padding: 5px; 
                            font-family: 'Courier New', monospace;
                            background: white;
                            color: black;
                        }
                        .professional-receipt {
                            width: 80mm !important;
                            max-width: 80mm !important;
                        }
                    }
                    body { 
                        font-family: 'Courier New', monospace;
                        margin: 0;
                        padding: 5px;
                        background: white;
                        color: black;
                    }
                    .professional-receipt {
                        width: 80mm;
                        max-width: 80mm;
                    }
                    .text-center { text-align: center; }
                    .text-left { text-align: left; }
                    .d-flex { display: flex; }
                    .justify-content-between { justify-content: space-between; }
                </style>
            </head>
            <body>${printContent}</body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Product search
$('#productSearch').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();
    $('.product-item').each(function() {
        const productName = $(this).find('.card-title').text().toLowerCase();
        if (productName.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

// Category filter
$('#categoryFilter').change(function() {
    const selectedCategory = $(this).val();
    $('.product-item').each(function() {
        if (selectedCategory === '' || $(this).data('category') == selectedCategory) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

// Barcode scanner functionality
let barcodeBuffer = '';
let barcodeTimeout;

$('#barcodeScanner').on('input', function() {
    const input = $(this).val();
    
    // Clear previous timeout
    clearTimeout(barcodeTimeout);
    
    // If input is longer than 3 characters, treat as barcode
    if (input.length >= 3) {
        barcodeTimeout = setTimeout(() => {
            searchProductByBarcode(input);
            $(this).val(''); // Clear input after scanning
        }, 100);
    }
});

// Function to search product by barcode
function searchProductByBarcode(barcode) {
    // Make AJAX call to search by barcode
    $.ajax({
        url: '{{ route("cashier.search-by-barcode") }}',
        method: 'GET',
        data: { barcode: barcode },
        success: function(response) {
            if (response.success) {
                // Add product to cart
                addToCart(response.product.id);
                
                // Show success message
                showNotification('Product "' + response.product.name + '" added to cart via barcode scan!', 'success');
            } else {
                // Show error message
                showNotification(response.message, 'error');
            }
        },
        error: function() {
            showNotification('Error searching for barcode: ' + barcode, 'error');
        }
    });
}

// Add barcode data to product items
$('.product-item').each(function() {
    const productId = $(this).data('product-id');
    const product = products.find(p => p.id == productId);
    if (product && product.barcode) {
        $(this).attr('data-barcode', product.barcode);
    }
});

// Notification function
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = $(`
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);
    
    $('body').append(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.alert('close');
    }, 3000);
}
</script>
@endsection
