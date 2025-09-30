<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SaleInfoController extends Controller
{
    //saleInfoList
    public function saleInfoList()
    {
        $today = Carbon::today();
        $order = Order::select('orders.id as order_id', 'orders.totalPrice as price',
            'orders.created_at', 'orders.order_code', 'orders.status',
            'users.name as username', 'products.name as productname',
            'products.image as productimage', 'orders.count as ordercount')
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->where('orders.status', 1)
            ->whereDate('orders.created_at', $today)
            ->groupBy('orders.order_code')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(5);

        // Calculate daily sales total
        $dailySalesTotal = Order::where('orders.status', 1)
            ->whereDate('orders.created_at', $today)
            ->sum('orders.totalPrice');

        // Get daily sales count
        $dailySalesCount = Order::where('orders.status', 1)
            ->whereDate('orders.created_at', $today)
            ->count();

        // Get today's date for display
        $todayDate = $today->format('F d, Y');

        return view('admin.saleInfo.list', compact('order', 'dailySalesTotal', 'dailySalesCount', 'todayDate'));
    }

    public function salesReportPage()
    {
        return view('admin.saleInfo.salesReport');
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $sales = Order::select('orders.id as order_id', 'orders.totalPrice as price',
                                'orders.created_at', 'orders.order_code', 'products.count as instock',
                                'products.name as productname',
                                'orders.count as sold', 'orders.created_at as date')
                        ->leftJoin('products', 'orders.product_id', 'products.id')
                        ->where('orders.status', 1)
                        ->whereDate('orders.created_at', '>=', $startDate)
                        ->whereDate('orders.created_at', '<=', $endDate)
                        ->groupBy(DB::raw('DATE(orders.created_at)'))
                        ->orderBy('orders.id')
                        ->get();

        // Calculate total sales for the period
        $totalSalesAmount = Order::where('orders.status', 1)
            ->whereDate('orders.created_at', '>=', $startDate)
            ->whereDate('orders.created_at', '<=', $endDate)
            ->sum('orders.totalPrice');

        // Get total orders count for the period
        $totalOrdersCount = Order::where('orders.status', 1)
            ->whereDate('orders.created_at', '>=', $startDate)
            ->whereDate('orders.created_at', '<=', $endDate)
            ->count();

        //   dd($sales->toArray());
        return view('admin.saleInfo.salesReport', compact('sales','startDate', 'endDate', 'totalSalesAmount', 'totalOrdersCount'));
    }

    public function productReportPage(){
        return view('admin.saleInfo.productanalysisReport');
    }

    public function productReport(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $results = [];

        if ($startDate && $endDate) {
            $stock = Product::select(
                                'products.id as product_id',
                                'products.name as product_name',
                                'products.count as in_stock',
                                DB::raw('SUM(orders.count) as units_sold'),
                                DB::raw('products.count - IFNULL(SUM(orders.count), 0) as remaining_stock'),
                                'categories.name as category_name'
                            )
                        ->leftJoin('categories', 'products.category_id', 'categories.id')
                        ->leftJoin('orders', function($join) use ($startDate, $endDate) {
                                    $join->on('products.id', '=', 'orders.product_id')
                                         ->whereDate('orders.created_at', '>=', $startDate)
                                         ->whereDate('orders.created_at', '<=', $endDate);
                                })
                        ->groupBy('products.id', 'products.name', 'products.count', 'categories.name')
                        ->get();

            // dd($stock);

        }
        return view('admin.saleInfo.productanalysisReport', compact('stock', 'startDate', 'endDate'));
    }

    public function profitlossreportpage(){
        return view ('admin.saleInfo.profit&lost');
    }

    public function profitlossReport(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $productsales = Product::join('orders', 'products.id', '=', 'orders.product_id')
                                ->select(
                                    'products.id',
                                    'products.name',
                                    'products.price as sell_price',
                                    'products.purchase_price',
                                    DB::raw('SUM(orders.count) as units_sold'),
                                    DB::raw('(products.price - products.purchase_price) * SUM(orders.count) as total_profit')
                                )
                                ->whereBetween('orders.created_at', [$startDate, $endDate])
                                ->groupBy('products.id', 'products.name', 'products.price', 'products.purchase_price')
                                ->get();

        // dd($productsales->toArray());

    return view('admin.saleInfo.profit&lost', compact('productsales','startDate', 'endDate'));
    }
}
