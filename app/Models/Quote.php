<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'customer_id',
        'user_id',
        'status',
        'quote_date',
        'agreement_length',
        'maintenance_agreement',
        'total_price',
    ];

    protected $casts = [
        'quote_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'quote_machines')->withPivot('quantity');
    }

    public function beans()
    {
        return $this->belongsToMany(Product::class, 'quote_beans')->withPivot('quantity');
    }

    public function getFormattedTotalPriceAttribute()
    {
        return '€ ' . number_format($this->total_price, 2, ',', '.');
    }
}
