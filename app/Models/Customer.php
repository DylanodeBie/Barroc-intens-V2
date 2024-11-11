<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ErrorNotification;
use App\Models\Visit;
use App\Models\Quote;
use App\Models\Invoice;
use App\Models\Leasecontract;

class Customer extends Model
{
    protected $table = 'customers';  // wijzig hier 'customer' naar 'customers'

    protected $fillable = [
        'company_name', 'contact_person', 'phonenumber', 'address', 'email', 'bkr_check'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_id');
    }

    public function error_notifications()
    {
        return $this->hasMany(ErrorNotification::class, 'error_notification_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'visit_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'quote_id');
    }

    public function leasecontracts()
    {
        return $this->hasMany(Leasecontract::class, 'leasecontract_id');
    }
}
