<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'visit_date',
        'start_time',
        'end_time',
        'address',
        'error_notification_id',
        'error_details',
        'used_parts',
        'status',
        'type',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function maintenanceReport()
    {
        return $this->hasOne(MaintenanceReport::class);
    }
}
