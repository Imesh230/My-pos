<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate barcodes for existing products that don't have one
        $products = Product::whereNull('barcode')->get();
        
        foreach ($products as $product) {
            $product->barcode = Product::generateBarcode();
            $product->save();
        }
        
        $this->command->info('Generated barcodes for ' . $products->count() . ' products');
    }
}
