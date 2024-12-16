<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes'; // Zorg dat dit overeenkomt met je tabelnaam

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
        'quote_date' => 'datetime', // Dit zorgt ervoor dat quote_date een Carbon-instance is
    ];

    /**
     * Relatie met het Customer-model.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relatie met het User-model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relatie met machines die gekoppeld zijn aan de offerte.
     */
    public function machines()
    {
        // Add the appropriate relationship or logic here
    }

    /**
     * Relatie met beans die gekoppeld zijn aan de offerte.
     */
    public function beans()
    {
        return $this->belongsToMany(Product::class, 'quote_beans')->withPivot('quantity');
    }

    /**
     * Relatie met de Invoice (factuur) gekoppeld aan de offerte.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'quote_id');
    }

    /**
     * Accessor voor de geformatteerde totaalprijs.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return '€ ' . number_format($this->total_price, 2, ',', '.');
    }
}

