<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RepairServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = RepairService::orderBy('created_at', 'desc')->paginate(10);
        
        // Today's repair summary
        $today = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        
        $todayRepairs = RepairService::whereBetween('created_at', [$today, $todayEnd])->get();
        
        $todaySummary = [
            'total_repairs' => $todayRepairs->count(),
            'total_estimated_cost' => $todayRepairs->sum('estimated_cost'),
            'total_actual_cost' => $todayRepairs->sum('actual_cost'),
            'completed_today' => $todayRepairs->where('status', 'completed')->count(),
            'pending_today' => $todayRepairs->where('status', 'pending')->count(),
            'in_progress_today' => $todayRepairs->where('status', 'in_progress')->count(),
        ];
        
        return view('admin.repair.index', compact('repairs', 'todaySummary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.repair.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'device_brand' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:20',
            'problem_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'estimated_completion' => 'nullable|date|after:today',
            'technician' => 'nullable|string|max:255',
        ]);

        $repair = RepairService::create([
            'repair_code' => RepairService::generateRepairCode(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'device_brand' => $request->device_brand,
            'device_model' => $request->device_model,
            'device_imei' => $request->device_imei,
            'problem_description' => $request->problem_description,
            'estimated_cost' => $request->estimated_cost,
            'estimated_completion' => $request->estimated_completion,
            'technician' => $request->technician,
            'received_date' => now()->toDateString(),
            'status' => 'pending'
        ]);

        Alert::success('Success', 'Repair service created successfully!');
        return redirect()->route('repair.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairService $repair)
    {
        return view('admin.repair.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairService $repair)
    {
        return view('admin.repair.edit', compact('repair'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairService $repair)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'device_brand' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:20',
            'problem_description' => 'required|string',
            'repair_notes' => 'nullable|string',
            'estimated_cost' => 'required|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,diagnosed,in_progress,completed,delivered,cancelled',
            'estimated_completion' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'delivered_date' => 'nullable|date',
            'technician' => 'nullable|string|max:255',
            'warranty_info' => 'nullable|string',
        ]);

        $repair->update($request->all());

        Alert::success('Success', 'Repair service updated successfully!');
        return redirect()->route('repair.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairService $repair)
    {
        $repair->delete();
        Alert::success('Success', 'Repair service deleted successfully!');
        return redirect()->route('repair.index');
    }

    /**
     * Update repair status
     */
    public function updateStatus(Request $request, RepairService $repair)
    {
        $request->validate([
            'status' => 'required|in:pending,diagnosed,in_progress,completed,delivered,cancelled',
            'repair_notes' => 'nullable|string',
            'final_cost' => 'nullable|numeric|min:0',
        ]);

        $data = ['status' => $request->status];
        
        if ($request->repair_notes) {
            $data['repair_notes'] = $request->repair_notes;
        }
        
        if ($request->final_cost) {
            $data['final_cost'] = $request->final_cost;
        }

        // Set completion date if status is completed
        if ($request->status === 'completed') {
            $data['completed_date'] = now()->toDateString();
        }

        // Set delivered date if status is delivered
        if ($request->status === 'delivered') {
            $data['delivered_date'] = now()->toDateString();
        }

        $repair->update($data);

        Alert::success('Success', 'Repair status updated successfully!');
        return redirect()->route('repair.show', $repair);
    }

    /**
     * Search repairs
     */
    public function search(Request $request)
    {
        $query = RepairService::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('repair_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('device_brand', 'like', "%{$search}%")
                  ->orWhere('device_model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $repairs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.repair.index', compact('repairs'));
    }

    /**
     * Generate repair bill
     */
    public function generateBill(RepairService $repair)
    {
        $shopSettings = \App\Models\ShopSetting::getActive();
        return view('admin.repair.bill', compact('repair', 'shopSettings'));
    }

    /**
     * Print repair bill
     */
    public function printBill(RepairService $repair)
    {
        $shopSettings = \App\Models\ShopSetting::getActive();
        return view('admin.repair.print-bill', compact('repair', 'shopSettings'));
    }

    /**
     * Print thermal receipt
     */
    public function thermalReceipt(RepairService $repair)
    {
        $shopSettings = \App\Models\ShopSetting::getActive();
        return view('admin.repair.thermal-receipt', compact('repair', 'shopSettings'));
    }
}