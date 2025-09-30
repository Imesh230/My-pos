<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','barcode','price','category_id','description','count','image','purchase_price'];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Generate unique barcode
    public static function generateBarcode()
    {
        do {
            $barcode = 'POS' . date('Ymd') . rand(1000, 9999);
        } while (static::where('barcode', $barcode)->exists());
        
        return $barcode;
    }

    // Auto-generate barcode if not exists
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->barcode)) {
                $product->barcode = static::generateBarcode();
            }
        });
    }
}
