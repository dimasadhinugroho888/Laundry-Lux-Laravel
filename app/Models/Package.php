<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'price',
        'unit',
    ];

    // satu paket bisa ada di banyak transaksi
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'package_transaction')
            ->withPivot('qty', 'total')
            ->withTimestamps();
    }
}
