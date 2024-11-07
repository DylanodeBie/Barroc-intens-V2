<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'customer_id', 'user_id', 'error_notification_id', 'visit_date', 'error_details', 'address', 'used_parts'
    ];
    
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function error_notifications()
    {
        return $this->belongsTo(ErrorNotification::class, 'error_notification_id');
    }
}
