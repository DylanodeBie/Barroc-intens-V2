<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'invoices';

    // Mass assignable fields
    protected $fillable = [
        'customer_id',
        'user_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'notes',
        'status',
    ];

    /**
     * Relationship: Invoice belongs to a Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship: Invoice belongs to a User (creator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Invoice has many Items.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Helper Method: Calculate total amount based on items.
     */
    public function calculateTotal()
    {
        return $this->items()->sum('subtotal');
    }
}
