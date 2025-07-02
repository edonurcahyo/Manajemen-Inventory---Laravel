<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penjualan',
        'customer_id',
        'tanggal',
        'total_harga',
        'user_id',
        'status',
        'subtotal_amount',
        'tax_percentage',
        'tax_amount',
        'discount_amount',
        'notes'
    ];
    
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $casts = [
        'tanggal' => 'date',
        'subtotal_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // Helper method to calculate totals
    public function calculateTotals()
    {
        $this->subtotal_amount = $this->saleDetails->sum('subtotal');
        $this->tax_amount = ($this->tax_percentage / 100) * $this->subtotal_amount;
        $this->total_harga = $this->subtotal_amount + $this->tax_amount - $this->discount_amount;
    }

    // Scope for filtering by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor for formatted total
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_harga, 2);
    }
}