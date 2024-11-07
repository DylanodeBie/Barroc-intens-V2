<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'customer_id', 'user_id', 'invoice_date', 'price', 'is_paid'
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
        return $this->belongsToMany(Product::class, 'invoice_id', 'product_id')
                    ->withPivot('amount', 'price');
    }
}
