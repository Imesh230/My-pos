<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_code',
        'warranty_id',
        'claim_date',
        'problem_description',
        'customer_complaint',
        'claim_type',
        'status',
        'technician_notes',
        'resolution_notes',
        'estimated_cost',
        'actual_cost',
        'resolution_date',
        'resolved_by',
        'admin_notes'
    ];

    protected $casts = [
        'claim_date' => 'date',
        'resolution_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2'
    ];

    // Relationship with warranty
    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    // Generate unique claim code
    public static function generateClaimCode()
    {
        do {
            $code = 'CLM' . date('Ymd') . rand(1000, 9999);
        } while (static::where('claim_code', $code)->exists());
        return $code;
    }

    // Get status badge class
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-warning';
            case 'approved':
                return 'badge-info';
            case 'rejected':
                return 'badge-danger';
            case 'in_progress':
                return 'badge-primary';
            case 'completed':
                return 'badge-success';
            default:
                return 'badge-secondary';
        }
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    // Get claim type text
    public function getClaimTypeTextAttribute()
    {
        return ucfirst($this->claim_type);
    }
}
