<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quote';
    
    protected $fillable = [
        'customer_id', 'user_id', 'status', 'quote_date'
    ];
    
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
