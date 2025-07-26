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
        'category_id',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'minimum_stock',
        'deskripsi'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
