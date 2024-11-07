<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leasecontract extends Model
{
    protected $table = 'leasecontract';

    protected $fillable = [
        'customer_id', 'user_id', 'start_date', 'end_date', 'payment_method', 
        'machine_amount', 'notice_period', 'status'
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'leasecontract_product', 'leasecontract_id', 'product_id')
                    ->withPivot('amount', 'price');
    }
}
