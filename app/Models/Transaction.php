<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'status',
    ];

    // relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // relasi ke banyak package (pivot)
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_transaction')
            ->withPivot('qty', 'total')
            ->withTimestamps();
    }
}
