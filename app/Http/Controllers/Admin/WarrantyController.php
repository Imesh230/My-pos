<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warranties = Warranty::with('claims')->orderBy('created_at', 'desc')->paginate(10);
        
        // Today's warranty summary
        $today = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        
        $todayWarranties = Warranty::whereBetween('created_at', [$today, $todayEnd])->get();
        $todayClaims = WarrantyClaim::whereBetween('created_at', [$today, $todayEnd])->get();
        
        $todaySummary = [
            'total_warranties' => $todayWarranties->count(),
            'total_claims' => $todayClaims->count(),
            'active_warranties' => $todayWarranties->where('status', 'active')->count(),
            'pending_claims' => $todayClaims->where('status', 'pending')->count(),
        ];
        
        return view('admin.warranty.index', compact('warranties', 'todaySummary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warranty.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_type' => 'required|in:charger,power_bank,mobile_accessory',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'purchase_date' => 'required|date',
            'warranty_period_months' => 'required|integer|min:1|max:60',
            'purchase_price' => 'required|numeric|min:0',
            'warranty_terms' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $warranty = Warranty::create([
            'warranty_code' => Warranty::generateWarrantyCode(),
            'product_name' => $request->product_name,
            'product_type' => $request->product_type,
            'brand' => $request->brand,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'purchase_date' => $request->purchase_date,
            'warranty_start_date' => $request->purchase_date,
            'warranty_end_date' => now()->parse($request->purchase_date)->addMonths($request->warranty_period_months),
            'warranty_period_months' => $request->warranty_period_months,
            'purchase_price' => $request->purchase_price,
            'warranty_terms' => $request->warranty_terms,
            'notes' => $request->notes,
            'status' => 'active'
        ]);

        Alert::success('Success', 'Warranty created successfully!');
        return redirect()->route('warranty.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        $warranty->load('claims');
        return view('admin.warranty.show', compact('warranty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warranty $warranty)
    {
        return view('admin.warranty.edit', compact('warranty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warranty $warranty)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_type' => 'required|in:charger,power_bank,mobile_accessory',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'purchase_date' => 'required|date',
            'warranty_period_months' => 'required|integer|min:1|max:60',
            'purchase_price' => 'required|numeric|min:0',
            'warranty_terms' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,expired,void'
        ]);

        $warranty->update([
            'product_name' => $request->product_name,
            'product_type' => $request->product_type,
            'brand' => $request->brand,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'purchase_date' => $request->purchase_date,
            'warranty_start_date' => $request->purchase_date,
            'warranty_end_date' => now()->parse($request->purchase_date)->addMonths($request->warranty_period_months),
            'warranty_period_months' => $request->warranty_period_months,
            'purchase_price' => $request->purchase_price,
            'warranty_terms' => $request->warranty_terms,
            'notes' => $request->notes,
            'status' => $request->status
        ]);

        Alert::success('Success', 'Warranty updated successfully!');
        return redirect()->route('warranty.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        $warranty->delete();
        Alert::success('Success', 'Warranty deleted successfully!');
        return redirect()->route('warranty.index');
    }

    /**
     * Create a warranty claim
     */
    public function createClaim(Warranty $warranty)
    {
        return view('admin.warranty.create-claim', compact('warranty'));
    }

    /**
     * Store a warranty claim
     */
    public function storeClaim(Request $request, Warranty $warranty)
    {
        $request->validate([
            'problem_description' => 'required|string',
            'customer_complaint' => 'required|string',
            'claim_type' => 'required|in:repair,replacement,refund',
            'estimated_cost' => 'nullable|numeric|min:0'
        ]);

        WarrantyClaim::create([
            'claim_code' => WarrantyClaim::generateClaimCode(),
            'warranty_id' => $warranty->id,
            'claim_date' => now()->toDateString(),
            'problem_description' => $request->problem_description,
            'customer_complaint' => $request->customer_complaint,
            'claim_type' => $request->claim_type,
            'estimated_cost' => $request->estimated_cost,
            'status' => 'pending'
        ]);

        Alert::success('Success', 'Warranty claim created successfully!');
        return redirect()->route('warranty.show', $warranty);
    }

    /**
     * Update claim status
     */
    public function updateClaimStatus(Request $request, WarrantyClaim $claim)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,in_progress,completed',
            'resolution_notes' => 'nullable|string',
            'actual_cost' => 'nullable|numeric|min:0',
            'resolved_by' => 'nullable|string|max:255'
        ]);

        $claim->update([
            'status' => $request->status,
            'resolution_notes' => $request->resolution_notes,
            'actual_cost' => $request->actual_cost,
            'resolved_by' => $request->resolved_by,
            'resolution_date' => $request->status === 'completed' ? now()->toDateString() : null
        ]);

        Alert::success('Success', 'Claim status updated successfully!');
        return redirect()->back();
    }
}
