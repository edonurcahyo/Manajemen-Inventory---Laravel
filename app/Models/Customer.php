<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'alamat',
        'no_telepon',
        'email',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}