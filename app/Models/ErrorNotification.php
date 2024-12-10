<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorNotification extends Model
{
    protected $table = 'error_notifications';

    protected $fillable = [
        'customer_id', 'user_id', 'error_date', 'status'
    ];
    
    public function customers()
    {
        return $this->belongsTo(customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'error_notification_id');
    }
}
