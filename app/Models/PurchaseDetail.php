<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_details'; // <== Tambahkan ini

    protected $fillable = [
        'purchase_id',
        'product_id',
        'jumlah',
        'harga_beli',
        'subtotal',
        'status',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
