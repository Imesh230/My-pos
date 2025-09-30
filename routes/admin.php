<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SaleInfoController;
use App\Http\Controllers\Admin\OrderBoardController;
use App\Http\Controllers\Admin\RoleChangeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\ShopSettingsController;
use App\Http\Controllers\Admin\RepairServiceController;
use App\Http\Controllers\Admin\WarrantyController;

//admin
Route::group(['prefix' => 'admin' , 'middleware' => ['auth','admin']], function(){
    Route::get('/home', [AdminDashboardController::class, 'index'])->name('adminDashboard');

    //category
    Route::prefix('category')->group(function(){
        Route::get('list',[CategoryController::class, 'list'])->name('categoryList');
        Route::get('create',[CategoryController::class, 'createPage'])->name('categoryCreatePage');
        Route::post('create',[CategoryController::class, 'create'])->name('categoryCreate');
        Route::get('delete/{id}',[CategoryController::class, 'delete'])->name('categoryDelete');
        Route::get('edit/{id}',[CategoryController::class, 'edit'])->name('categoryEdit');
        Route::post('update',[CategoryController::class, 'update'])->name('categoryUpdate');

    });

    //product
    Route::prefix('product')->group(function(){
        Route::get('list',[ProductController::class, 'list'])->name('productList');
        Route::get('create',[ProductController::class, 'createPage'])->name('productCreate');
        Route::post('create',[ProductController::class, 'productCreate'])->name('product#Create');
        Route::get('delete/{id}',[ProductController::class, 'delete'])->name('productDelete');
        Route::get('details/{id}',[ProductController::class, 'details'])->name('productDetails');
        Route::get('edit/{id}',[ProductController::class, 'edit'])->name('productEdit');
        Route::post('update',[ProductController::class, 'update'])->name('productUpdate');
        Route::get('{id}/print-barcode',[ProductController::class, 'printBarcode'])->name('product.print-barcode');
        Route::post('print-bulk-barcodes',[ProductController::class, 'printBulkBarcodes'])->name('products.print-bulk-barcodes');

    });


    //password
    Route::prefix('password')->group(function(){
        Route::get('change', [AuthController::class, 'changePasswordPage'])->name('passwordChange');
        Route::post('change', [AuthController::class, 'changePassword'])->name('changePassword');
        Route::get('reset', [AuthController::class, 'resetPasswordPage'])->name('resetPasswordPage');
        Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('resetPassword');

    });

    //profile
    Route::prefix('profile')->group(function(){
        Route::get('detail', [ProfileController::class, 'profileDetails'])->name('profileDetails');
        Route::post('update', [ProfileController::class, 'update'])->name('adminProfileUpdate');
        Route::get('account/{id}', [ProfileController::class, 'accountProfile'])->name('accountProfile');


        Route::get('create/adminAccount', [ProfileController::class, 'createAdminAccount'])->name('createAdminAccount');
        Route::post('create/adminAccount', [ProfileController::class, 'create'])->name('createAdmin');
    });

    //role
    Route::prefix('role')->group(function(){
        Route::get('list',[RoleChangeController::class, 'adminList'])->name('adminList');
        Route::get('deleteAdminAccount/{id}',[RoleChangeController::class, 'deleteAdminAccount'])->name('deleteAdminAccount');
        Route::get('changeUserRole/{id}',[RoleChangeController::class, 'changeUserRole'])->name('changeUserRole');

        Route::get('userList',[RoleChangeController::class, 'userList'])->name('userList');
        Route::get('deleteUserAccount/{id}',[RoleChangeController::class, 'deleteUserAccount'])->name('deleteUserAccount');
        Route::get('changeAdminRole/{id}',[RoleChangeController::class, 'changeAdminRole'])->name('changeAdminRole');

    });

    //Order Board Page
    Route::prefix('order')->group(function(){
        Route::get('list',[OrderBoardController::class, 'orderListPage'])->name('orderListPage');
        Route::get('details/{orderCode}',[OrderBoardController::class, 'userOrderDetails'])->name('userOrderDetails');
        Route::get('change/status',[OrderBoardController::class, 'changeStatus'])->name('changeStatus');
        Route::post('update/status', [OrderBoardController::class, 'updateStatus'])->name('updateOrderStatus');
        Route::post('reject', [OrderBoardController::class, 'rejectOrder']);
        Route::post('removereject', [OrderBoardController::class, 'removeRejectReason']);
    });

    //Sale Info
    Route::prefix('saleinfo')->group(function(){
        Route::get('list', [SaleInfoController::class, 'saleInfoList'])->name('saleInfoList');
    });

    // Reports
    Route::prefix('reports')->group(function(){
        Route::get('salesReportPage', [SaleInfoController::class, 'salesReportPage'])->name('salesReportPage');
        Route::get('sales',[SaleInfoController::class, 'salesReport'])->name('salesReport');
        Route::get('productReportPage',[SaleInfoController::class, 'productReportPage'])->name('productReportPage');
        Route::get('productReport',[SaleInfoController::class, 'productReport'])->name('productReport');
        Route::get('profitlossreportpage',[SaleInfoController::class, 'profitlossreportpage'])->name('profitlossreportpage');
        Route::get('profitlossReport',[SaleInfoController::class, 'profitlossReport'])->name('profitlossReport');

    });

    // Cashier Management (Super Admin Only)
    Route::prefix('cashier')->group(function(){
        Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
        Route::get('/create', [CashierController::class, 'create'])->name('cashier.create');
        Route::post('/', [CashierController::class, 'store'])->name('cashier.store');
        Route::get('/{id}', [CashierController::class, 'show'])->name('cashier.show');
        Route::get('/{id}/edit', [CashierController::class, 'edit'])->name('cashier.edit');
        Route::put('/{id}', [CashierController::class, 'update'])->name('cashier.update');
        Route::delete('/{id}', [CashierController::class, 'destroy'])->name('cashier.destroy');
        
        // Cashier Screen Routes
        Route::get('/screen/pos', [CashierController::class, 'cashierScreen'])->name('cashier.screen');
        Route::post('/quick-sale', [CashierController::class, 'quickSale'])->name('cashier.quick-sale');
        Route::get('/product/{id}', [CashierController::class, 'getProduct'])->name('cashier.product');
        Route::get('/search/products', [CashierController::class, 'searchProducts'])->name('cashier.search-products');
        Route::get('/search/barcode', [CashierController::class, 'searchByBarcode'])->name('cashier.search-by-barcode');
    });

    // Shop Settings (Super Admin Only)
    Route::prefix('settings')->group(function(){
        Route::get('/shop', [ShopSettingsController::class, 'index'])->name('shop.settings');
        Route::put('/shop', [ShopSettingsController::class, 'update'])->name('shop.settings.update');
        Route::post('/shop/reset', [ShopSettingsController::class, 'reset'])->name('shop.settings.reset');
        Route::get('/shop/get', [ShopSettingsController::class, 'getSettings'])->name('shop.settings.get');
    });

    // Repair Services
    Route::resource('repair', RepairServiceController::class);
    Route::post('repair/{repair}/update-status', [RepairServiceController::class, 'updateStatus'])->name('repair.update-status');
    Route::get('repair-search', [RepairServiceController::class, 'search'])->name('repair.search');
    Route::get('repair/{repair}/bill', [RepairServiceController::class, 'generateBill'])->name('repair.bill');
    Route::get('repair/{repair}/print-bill', [RepairServiceController::class, 'printBill'])->name('repair.print-bill');
    Route::get('repair/{repair}/thermal-receipt', [RepairServiceController::class, 'thermalReceipt'])->name('repair.thermal-receipt');

    // Warranty Management
    Route::resource('warranty', WarrantyController::class);
    Route::get('warranty/{warranty}/create-claim', [WarrantyController::class, 'createClaim'])->name('warranty.create-claim');
    Route::post('warranty/{warranty}/store-claim', [WarrantyController::class, 'storeClaim'])->name('warranty.store-claim');
    Route::post('warranty-claim/{claim}/update-status', [WarrantyController::class, 'updateClaimStatus'])->name('warranty-claim.update-status');

});
