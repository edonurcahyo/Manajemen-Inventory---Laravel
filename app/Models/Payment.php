<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'transaksi_id',
        'jumlah',
        'tanggal',
        'keterangan',
    ];
}