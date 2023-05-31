<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected  $fillable = [
        'name',
        'quantity',
        'price',
        'image',
    ];
    public function isAvailable(int $quantity): bool
    {
        return $this->quantity > $quantity;
    }
}
