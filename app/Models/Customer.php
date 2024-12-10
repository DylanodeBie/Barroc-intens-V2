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
    protected $table = 'customers';  // Zorg ervoor dat dit de juiste tabelnaam is

    protected $fillable = [
        'company_name',
        'contact_person',
        'phonenumber',
        'address',
        'email',
        'bkr_check',
    ];

    /**
     * Relatie naar invoices (facturen).
     * Verwijst naar 'customer_id' in de invoices-tabel.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    /**
     * Relatie naar error notifications.
     * Verwijst naar 'customer_id' in de error_notifications-tabel.
     */
    public function errorNotifications()
    {
        return $this->hasMany(ErrorNotification::class, 'customer_id');
    }

    /**
     * Relatie naar visits (bezoeken).
     * Verwijst naar 'customer_id' in de visits-tabel.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, 'customer_id');
    }

    /**
     * Relatie naar quotes (offertes).
     * Verwijst naar 'customer_id' in de quotes-tabel.
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class, 'customer_id');
    }

    /**
     * Relatie naar lease contracts (huurcontracten).
     * Verwijst naar 'customer_id' in de leasecontracts-tabel.
     */
    public function leasecontracts()
    {
        return $this->hasMany(Leasecontract::class, 'customer_id');
    }
}
