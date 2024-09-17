<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price'];

    // Relasi many-to-many dengan transaksi
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
