<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cashier;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CashierController extends Controller
{
    // Cashier list page
    public function index()
    {
        $cashiers = Cashier::when(request('searchKey'), function($query){
            $query->whereAny(['name','email','phone'],'like','%'.request('searchKey').'%');
        })->paginate(5);

        return view('admin.cashier.list', compact('cashiers'));
    }

    // Create cashier page
    public function create()
    {
        return view('admin.cashier.create');
    }

    // Store new cashier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:cashiers,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $cashierData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => true
        ];

        if($request->hasFile('profile')){
            $fileName = uniqid() . $request->file('profile')->getClientOriginalName();
            $request->file('profile')->move(public_path(). '/cashierProfile/' , $fileName);
            $cashierData['profile'] = $fileName;
        }

        Cashier::create($cashierData);
        Alert::success('Success', 'Cashier Created Successfully!');
        return redirect()->route('cashier.index');
    }

    // Show cashier details
    public function show($id)
    {
        $cashier = Cashier::findOrFail($id);
        return view('admin.cashier.details', compact('cashier'));
    }

    // Edit cashier page
    public function edit($id)
    {
        $cashier = Cashier::findOrFail($id);
        return view('admin.cashier.edit', compact('cashier'));
    }

    // Update cashier
    public function update(Request $request, $id)
    {
        $cashier = Cashier::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:cashiers,email,' . $id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $cashierData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->has('is_active')
        ];

        if($request->hasFile('profile')){
            // Delete old image
            if($cashier->profile && file_exists(public_path('cashierProfile/' . $cashier->profile))){
                unlink(public_path('cashierProfile/' . $cashier->profile));
            }
            
            $fileName = uniqid() . $request->file('profile')->getClientOriginalName();
            $request->file('profile')->move(public_path(). '/cashierProfile/' , $fileName);
            $cashierData['profile'] = $fileName;
        } else {
            $cashierData['profile'] = $cashier->profile;
        }

        $cashier->update($cashierData);
        Alert::success('Success', 'Cashier Updated Successfully!');
        return redirect()->route('cashier.index');
    }

    // Delete cashier
    public function destroy($id)
    {
        $cashier = Cashier::findOrFail($id);
        
        // Delete profile image if exists
        if($cashier->profile && file_exists(public_path('cashierProfile/' . $cashier->profile))){
            unlink(public_path('cashierProfile/' . $cashier->profile));
        }
        
        $cashier->delete();
        Alert::success('Success', 'Cashier Deleted Successfully!');
        return redirect()->route('cashier.index');
    }

    // Cashier Screen - Main POS Interface
    public function cashierScreen()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.cashier.screen', compact('products', 'categories'));
    }

    // Quick Sale - Process immediate sale
    public function quickSale(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        $totalAmount = 0;
        $orderCode = 'CASH' . date('YmdHis') . rand(100, 999);

        // Calculate total and create order
        foreach($request->products as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $subtotal = $product->price * $quantity;
            $totalAmount += $subtotal;

            // Create order record
            Order::create([
                'product_id' => $product->id,
                'user_id' => 1, // Default user for cashier sales
                'count' => $quantity,
                'status' => 1, // Completed
                'order_code' => $orderCode,
                'totalPrice' => $subtotal
            ]);

            // Update product stock
            $product->decrement('count', $quantity);
        }

        // Create payment record
        \App\Models\PaySlipHistory::create([
            'customer_name' => $request->customer_name ?? 'Walk-in Customer',
            'phone' => $request->customer_phone ?? '',
            'payment_method' => $request->payment_method,
            'order_code' => $orderCode,
            'order_amount' => $totalAmount,
            'payslip_image' => 'cashier_sale.jpg' // Default for cashier sales
        ]);

        return response()->json([
            'success' => true,
            'order_code' => $orderCode,
            'total_amount' => $totalAmount,
            'message' => 'Sale completed successfully!'
        ]);
    }

    // Get product details for cashier
    public function getProduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    // Search products for cashier
    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    // Search product by barcode
    public function searchByBarcode(Request $request)
    {
        $barcode = $request->get('barcode');
        $product = Product::with('category')
            ->where('barcode', $barcode)
            ->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found with barcode: ' . $barcode
            ]);
        }
    }
}