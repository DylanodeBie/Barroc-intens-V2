<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeasecontractProduct extends Model
{
    protected $table = 'leasecontract_products';

    protected $fillable = [
        'leasecontract_id',
        'product_id',
        'amount'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'leasecontract_products');
    }
}
