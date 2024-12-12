<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'user_id',
        'quote_id',
        'invoice_date',
        'price',
        'is_paid',
    ];

    // Relatie met Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relatie met Quote
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    // Relatie met Products (via een pivot-tabel)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product', 'invoice_id', 'product_id')
                    ->withPivot('amount', 'price')
                    ->withTimestamps();
    }
}
