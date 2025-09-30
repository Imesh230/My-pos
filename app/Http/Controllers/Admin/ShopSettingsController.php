<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ShopSettingsController extends Controller
{
    // Show shop settings
    public function index()
    {
        $settings = ShopSetting::getActive();
        return view('admin.settings.index', compact('settings'));
    }

    // Update shop settings
    public function update(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'footer_notice' => 'nullable|string',
        ]);

        $settings = ShopSetting::getActive();
        
        $settingsData = [
            'shop_name' => $request->shop_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'footer_notice' => $request->footer_notice,
        ];

        // Handle logo upload
        if($request->hasFile('logo')){
            // Delete old logo if exists
            if($settings->logo && file_exists(public_path('shopAssets/' . $settings->logo))){
                unlink(public_path('shopAssets/' . $settings->logo));
            }
            
            $fileName = uniqid() . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path(). '/shopAssets/' , $fileName);
            $settingsData['logo'] = $fileName;
        } else {
            $settingsData['logo'] = $settings->logo;
        }

        $settings->update($settingsData);
        
        Alert::success('Success', 'Shop settings updated successfully!');
        return redirect()->route('shop.settings');
    }

    // Reset to default settings
    public function reset()
    {
        $settings = ShopSetting::getActive();
        $settings->update([
            'shop_name' => 'My POS Shop',
            'contact_number' => '+94 11 123 4567',
            'email' => 'info@myposshop.com',
            'address' => '123 Main Street, Colombo, Sri Lanka',
            'footer_notice' => 'Thank you for your business!',
        ]);
        
        Alert::success('Success', 'Shop settings reset to default!');
        return redirect()->route('shop.settings');
    }

    // Get shop settings for AJAX requests
    public function getSettings()
    {
        $settings = ShopSetting::getActive();
        return response()->json($settings);
    }
}