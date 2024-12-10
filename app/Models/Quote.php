<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes'; // Ensure this matches your actual table name

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
        'quote_date' => 'datetime', // This ensures quote_date is cast to a Carbon instance
    ];

    /**
     * Define the relationship with the Customer model.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with QuoteMachine (machines linked to the quote).
     */
    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'quote_machines')->withPivot('quantity');
    }

    /**
     * Define the relationship with QuoteBean (beans linked to the quote).
     */
    public function beans()
    {
        return $this->belongsToMany(Product::class, 'quote_beans')->withPivot('quantity');
    }

    /**
     * Accessor for formatted total price.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return '€ ' . number_format($this->total_price, 2, ',', '.');
    }
}
