<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_code',
        'product_name',
        'product_type',
        'brand',
        'model',
        'serial_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'purchase_date',
        'warranty_start_date',
        'warranty_end_date',
        'warranty_period_months',
        'purchase_price',
        'warranty_terms',
        'status',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    // Relationship with warranty claims
    public function claims()
    {
        return $this->hasMany(WarrantyClaim::class);
    }

    // Generate unique warranty code
    public static function generateWarrantyCode()
    {
        do {
            $code = 'WAR' . date('Ymd') . rand(1000, 9999);
        } while (static::where('warranty_code', $code)->exists());
        return $code;
    }

    // Check if warranty is active
    public function isActive()
    {
        return $this->status === 'active' && $this->warranty_end_date >= now()->toDateString();
    }

    // Check if warranty is expired
    public function isExpired()
    {
        return $this->warranty_end_date < now()->toDateString();
    }

    // Get status badge class
    public function getStatusBadgeAttribute()
    {
        if ($this->isExpired()) {
            return 'badge-danger';
        }
        
        switch ($this->status) {
            case 'active':
                return 'badge-success';
            case 'expired':
                return 'badge-danger';
            case 'void':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        return ucfirst($this->status);
    }
}
