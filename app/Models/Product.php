<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    // Mendefinisikan relasi dengan model Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
