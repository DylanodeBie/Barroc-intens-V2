<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leasecontract extends Model
{
    protected $table = 'leasecontracts';

    protected $fillable = [
        'customer_id',
        'user_id',
        'start_date',
        'end_date',
        'payment_method',
        'machine_amount',
        'notice_period',
        'status',
        'total_price',
        'approved_by',
        'rejected_by',
        'approved_at',
        'rejected_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($leasecontract) {
            if (empty($leasecontract->status)) {
                $leasecontract->status = 'pending';
            }
        });
    }


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
        return $this->belongsToMany(Product::class, 'leasecontract_products', 'leasecontract_id', 'product_id')
            ->withPivot('amount', 'price');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
