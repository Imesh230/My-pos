<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'contact_number',
        'email',
        'address',
        'footer_notice',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Get active shop settings (singleton pattern)
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::createDefault();
    }

    // Create default shop settings if none exist
    public static function createDefault()
    {
        return static::create([
            'shop_name' => 'My POS Shop',
            'contact_number' => '+94 11 123 4567',
            'email' => 'info@myposshop.com',
            'address' => '123 Main Street, Colombo, Sri Lanka',
            'footer_notice' => 'Thank you for your business!',
            'is_active' => true
        ]);
    }
}
