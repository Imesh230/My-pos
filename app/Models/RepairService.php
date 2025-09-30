<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairService extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'device_brand',
        'device_model',
        'device_imei',
        'problem_description',
        'repair_notes',
        'estimated_cost',
        'final_cost',
        'status',
        'received_date',
        'estimated_completion',
        'completed_date',
        'delivered_date',
        'technician',
        'warranty_info'
    ];

    protected $casts = [
        'received_date' => 'date',
        'estimated_completion' => 'date',
        'completed_date' => 'date',
        'delivered_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
    ];

    // Generate unique repair code
    public static function generateRepairCode()
    {
        do {
            $code = 'REP' . date('Ymd') . rand(1000, 9999);
        } while (static::where('repair_code', $code)->exists());
        
        return $code;
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'diagnosed' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'diagnosed' => 'Diagnosed',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        return $texts[$this->status] ?? 'Unknown';
    }
}
