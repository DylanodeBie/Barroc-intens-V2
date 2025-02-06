<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'brand', 'description', 'stock', 'price', 'image'
    ];


    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product')
                    ->withPivot('amount', 'price');
    }

    public function leasecontracts()
    {
        return $this->belongsToMany(Leasecontract::class, 'leasecontract_products')
                    ->withPivot('amount');
    }
}
