<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShopSetting;

class MobileShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Product::truncate();
        Category::truncate();
        
        // Create mobile shop categories
        $categories = [
            ['name' => 'Smartphones'],
            ['name' => 'Phone Cases'],
            ['name' => 'Chargers & Cables'],
            ['name' => 'Screen Protectors'],
            ['name' => 'Power Banks'],
            ['name' => 'Earphones & Headphones'],
            ['name' => 'Phone Accessories'],
            ['name' => 'Mobile Repair Parts']
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
        
        // Get category IDs
        $smartphones = Category::where('name', 'Smartphones')->first();
        $cases = Category::where('name', 'Phone Cases')->first();
        $chargers = Category::where('name', 'Chargers & Cables')->first();
        $protectors = Category::where('name', 'Screen Protectors')->first();
        $powerbanks = Category::where('name', 'Power Banks')->first();
        $earphones = Category::where('name', 'Earphones & Headphones')->first();
        $accessories = Category::where('name', 'Phone Accessories')->first();
        $repair = Category::where('name', 'Mobile Repair Parts')->first();
        
        // Create mobile shop products
        $products = [
            // Smartphones
            ['name' => 'Samsung Galaxy A15', 'price' => 45000, 'purchase_price' => 40000, 'category_id' => $smartphones->id, 'count' => 10, 'description' => 'Samsung Galaxy A15 128GB'],
            ['name' => 'iPhone 13', 'price' => 120000, 'purchase_price' => 110000, 'category_id' => $smartphones->id, 'count' => 5, 'description' => 'Apple iPhone 13 128GB'],
            ['name' => 'Huawei Nova 11i', 'price' => 35000, 'purchase_price' => 32000, 'category_id' => $smartphones->id, 'count' => 8, 'description' => 'Huawei Nova 11i 128GB'],
            ['name' => 'Oppo A78', 'price' => 28000, 'purchase_price' => 25000, 'category_id' => $smartphones->id, 'count' => 12, 'description' => 'Oppo A78 128GB'],
            ['name' => 'Vivo Y27', 'price' => 32000, 'purchase_price' => 29000, 'category_id' => $smartphones->id, 'count' => 7, 'description' => 'Vivo Y27 128GB'],
            
            // Phone Cases
            ['name' => 'Samsung Galaxy Case', 'price' => 2500, 'purchase_price' => 1500, 'category_id' => $cases->id, 'count' => 25, 'description' => 'Clear TPU Case for Samsung Galaxy'],
            ['name' => 'iPhone Case', 'price' => 3000, 'purchase_price' => 2000, 'category_id' => $cases->id, 'count' => 20, 'description' => 'Silicone Case for iPhone'],
            ['name' => 'Universal Phone Case', 'price' => 1500, 'purchase_price' => 800, 'category_id' => $cases->id, 'count' => 30, 'description' => 'Universal Clear Case'],
            ['name' => 'Leather Wallet Case', 'price' => 4500, 'purchase_price' => 3000, 'category_id' => $cases->id, 'count' => 15, 'description' => 'Genuine Leather Wallet Case'],
            
            // Chargers & Cables
            ['name' => 'Fast Charger 25W', 'price' => 3500, 'purchase_price' => 2500, 'category_id' => $chargers->id, 'count' => 20, 'description' => '25W Fast Charger with Cable'],
            ['name' => 'USB-C Cable', 'price' => 1200, 'purchase_price' => 600, 'category_id' => $chargers->id, 'count' => 40, 'description' => '1.5m USB-C to USB-C Cable'],
            ['name' => 'Lightning Cable', 'price' => 1500, 'purchase_price' => 800, 'category_id' => $chargers->id, 'count' => 35, 'description' => '1m Lightning to USB Cable'],
            ['name' => 'Wireless Charger', 'price' => 5500, 'purchase_price' => 4000, 'category_id' => $chargers->id, 'count' => 10, 'description' => '15W Wireless Charging Pad'],
            
            // Screen Protectors
            ['name' => 'Tempered Glass 6.1"', 'price' => 800, 'purchase_price' => 400, 'category_id' => $protectors->id, 'count' => 50, 'description' => 'Tempered Glass Screen Protector'],
            ['name' => 'Privacy Screen Protector', 'price' => 1200, 'purchase_price' => 700, 'category_id' => $protectors->id, 'count' => 25, 'description' => 'Privacy Tempered Glass'],
            ['name' => 'Anti-Glare Protector', 'price' => 1000, 'purchase_price' => 500, 'category_id' => $protectors->id, 'count' => 30, 'description' => 'Anti-Glare Screen Protector'],
            
            // Power Banks
            ['name' => '10000mAh Power Bank', 'price' => 4500, 'purchase_price' => 3000, 'category_id' => $powerbanks->id, 'count' => 15, 'description' => '10000mAh Portable Power Bank'],
            ['name' => '20000mAh Power Bank', 'price' => 7500, 'purchase_price' => 5500, 'category_id' => $powerbanks->id, 'count' => 10, 'description' => '20000mAh Fast Charging Power Bank'],
            ['name' => 'Wireless Power Bank', 'price' => 6500, 'purchase_price' => 4500, 'category_id' => $powerbanks->id, 'count' => 8, 'description' => '10000mAh Wireless Power Bank'],
            
            // Earphones & Headphones
            ['name' => 'Bluetooth Earphones', 'price' => 3500, 'purchase_price' => 2500, 'category_id' => $earphones->id, 'count' => 20, 'description' => 'True Wireless Bluetooth Earphones'],
            ['name' => 'Wired Earphones', 'price' => 1200, 'purchase_price' => 600, 'category_id' => $earphones->id, 'count' => 30, 'description' => '3.5mm Wired Earphones'],
            ['name' => 'Bluetooth Headphones', 'price' => 5500, 'purchase_price' => 4000, 'category_id' => $earphones->id, 'count' => 12, 'description' => 'Over-Ear Bluetooth Headphones'],
            
            // Phone Accessories
            ['name' => 'Phone Stand', 'price' => 1500, 'purchase_price' => 800, 'category_id' => $accessories->id, 'count' => 25, 'description' => 'Adjustable Phone Stand'],
            ['name' => 'Car Mount', 'price' => 2500, 'purchase_price' => 1500, 'category_id' => $accessories->id, 'count' => 15, 'description' => 'Magnetic Car Phone Mount'],
            ['name' => 'Phone Ring Holder', 'price' => 800, 'purchase_price' => 400, 'category_id' => $accessories->id, 'count' => 40, 'description' => 'Sticky Phone Ring Holder'],
            ['name' => 'Phone Cleaning Kit', 'price' => 1000, 'purchase_price' => 500, 'category_id' => $accessories->id, 'count' => 20, 'description' => 'Complete Phone Cleaning Kit'],
            
            // Mobile Repair Parts
            ['name' => 'iPhone Battery', 'price' => 8500, 'purchase_price' => 6000, 'category_id' => $repair->id, 'count' => 8, 'description' => 'Original iPhone Battery'],
            ['name' => 'Samsung Screen', 'price' => 12000, 'purchase_price' => 9000, 'category_id' => $repair->id, 'count' => 5, 'description' => 'Samsung Galaxy Screen Replacement'],
            ['name' => 'Charging Port', 'price' => 2500, 'purchase_price' => 1500, 'category_id' => $repair->id, 'count' => 15, 'description' => 'Universal Charging Port'],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
        
        // Update shop settings for mobile shop
        $shopSettings = ShopSetting::first();
        if ($shopSettings) {
            $shopSettings->update([
                'shop_name' => 'Chamara Mobile Shop',
                'contact_number' => '0718986399',
                'email' => 'chamara.mobile@gmail.com',
                'address' => 'Kekirawa Bus Stand, Anuradhapura',
                'footer_notice' => 'Thank you for choosing Chamara Mobile! We provide quality mobile phones and accessories with warranty.',
            ]);
        } else {
            ShopSetting::create([
                'shop_name' => 'Chamara Mobile Shop',
                'contact_number' => '0718986399',
                'email' => 'chamara.mobile@gmail.com',
                'address' => 'Kekirawa Bus Stand, Anuradhapura',
                'footer_notice' => 'Thank you for choosing Chamara Mobile! We provide quality mobile phones and accessories with warranty.',
                'is_active' => true
            ]);
        }
        
        $this->command->info('Mobile shop setup completed successfully!');
        $this->command->info('Created ' . count($categories) . ' categories');
        $this->command->info('Created ' . count($products) . ' products');
        $this->command->info('Updated shop settings for mobile shop');
    }
}