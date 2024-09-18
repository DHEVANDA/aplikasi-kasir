<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['name', 'total_price', 'payment_method'];

    // Relasi many-to-many dengan produk
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_product')
            ->withPivot('quantity', 'price') // Menyertakan kolom pivot 'quantity' dan 'price'
            ->withTimestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
    }
}
