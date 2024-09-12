<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'transactions';

    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'product_id',
        'quantity',
        'total_price',
    ];

    // Menggunakan cast untuk atribut decimal
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Mendefinisikan relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
