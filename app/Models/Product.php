<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'categories_id',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}